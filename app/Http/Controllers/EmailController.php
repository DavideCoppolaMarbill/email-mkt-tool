<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Client;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;


class EmailController extends Controller
{
    public function send(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email-to' => 'required_without_all:group_id|string|nullable',
            'group_id' => 'required_without_all:email-to|array',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emails = explode(' ', $request->input('email-to'));
        $emails = array_filter($emails, 'strlen');

        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->withErrors(['email-to' => 'Invalid email format'])->withInput();
            }
        }

        $groupIds = $request->input('group_id');

        if ($groupIds) {
            foreach ($groupIds as $groupId) {
                $clients = Client::whereHas('clientGroups', function ($query) use ($groupId) {
                    $query->where('group_id', $groupId);
                })->get();
            foreach ($clients as $client) {
                $emails[] = $client->email;
            }
        }
        }

        // Remove duplicates
        $emails = array_unique($emails);

        $subject = $request->input('subject');
        $message = $request->input('message');
        $scheduleEmail = $request->has('schedule_email');
        $scheduledDateTime = $request->input('schedule_datetime');

        // If scheduling is selected, queue the email sending job
        if ($scheduleEmail && $scheduledDateTime) {
            $this->scheduleEmail($emails, $subject, $message, $scheduledDateTime);
            return redirect()->back()->with('status', 'Email scheduled successfully');
        }

        // Otherwise, send the emails immediately
        foreach ($emails as $email) {
            $client = Client::where('email', $email)->where('user_id', auth()->id())->first();
            $customMessage = $this->replacePlaceholders($message, $client);
            Mail::to($email)->send(new SendEmail($subject, $customMessage));
        }

        return redirect()->back()->with('status', 'Emails sent successfully');
    }

    private function scheduleEmail($emails, $subject, $message, $scheduledDateTime) {
        $scheduledDateTime = Carbon::parse($scheduledDateTime);
        foreach ($emails as $email) {
            $client = Client::where('email', $email)->where('user_id', auth()->id())->first();
            $customMessage = $this->replacePlaceholders($message, $client);
            Mail::to($email)->later($scheduledDateTime, new SendEmail($subject, $customMessage));
        }
    }

    private function replacePlaceholders($message, $client)
    {
        if ($client) {
            $replacedMessage = str_replace(
                ['{first_name}', '{last_name}', '{sex}', '{birthday}'],
                [
                    $client->first_name,
                    $client->last_name,
                    $client->sex,
                    $client->birthday
                ],
                $message
            );
    
            $replacedMessage = nl2br($replacedMessage);
    
            return $replacedMessage;
        }
    
        return nl2br($message);
    }
    
    
    
}
