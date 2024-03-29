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
            'email-to' => 'string|nullable|required_without_all:group_id',
            'group_id' => 'valid_group_ids|required_without_all:email-to',
            'subject' => 'required',
            'message' => 'required',
            'schedule_datetime' => 'date_format:Y-m-d\TH:i',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
        ]);        

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emails = $this->getEmails($request->input('email-to'), $request->input('group_id'));
        $subject = $request->input('subject');
        $message = $request->input('message');
        $scheduleEmail = $request->has('schedule_email');
        $scheduledDateTime = $request->input('schedule_datetime');
        $isScheduled = $scheduleEmail && $scheduledDateTime;
        $attachment = null;

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $tempPath = tempnam(sys_get_temp_dir(), 'email_attachment');
            $attachment->move(dirname($tempPath), basename($tempPath));
            $attachment = $tempPath;
        }

        $this->sendEmail($emails, $subject, $message, $scheduleEmail, $scheduledDateTime, $attachment);

        return redirect()->back()->with('status', $isScheduled ? 'Email scheduled successfully'  : 'Email sent successfully');
    }

    private function sendEmail($emails, $subject, $message, $scheduleEmail, $scheduledDateTime, $attachment = null) {
        $scheduledDateTime = Carbon::parse($scheduledDateTime);
        $sendAt = $scheduleEmail && $scheduledDateTime ? $scheduledDateTime : now();
        foreach ($emails as $email) {
            $client = Client::where('email', $email)->where('user_id', auth()->id())->first();
            
            $replacementResult = $this->replacePlaceholders($message, $subject, $client);
    
            $customMessage = $replacementResult['message'];
            $customSubject = $replacementResult['subject'];
    
            Mail::to($email)->later($sendAt, new SendEmail($customSubject, $customMessage, $attachment));
        }
    }

    private function replacePlaceholders($message, $subject, $client)
    {
        $placeholders = ['{first_name}', '{last_name}', '{sex}', '{birthday}'];
           
        if ($client) {
            $values = [
                $client->first_name,
                $client->last_name,
                $client->sex,
                $client->birthday
            ];

            $replacedText = str_replace($placeholders, $values, $message);
            $replacedText = nl2br($replacedText);
    
            $replacedSubject = str_replace($placeholders, $values, $subject);
            $replacedSubject = nl2br($replacedSubject);
    
            return ['message' => $replacedText, 'subject' => $replacedSubject];
        }
    
        return ['message' => nl2br($message), 'subject' => nl2br($subject)];
    }

    private function getEmails($emailTo, $groupIds) {
        $emails = explode(' ', $emailTo);
        $emails = array_filter($emails, 'strlen');

        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->withErrors(['email-to' => 'Invalid email format'])->withInput();
            }
        }

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

        $emails = array_unique($emails);

        return $emails;
    }
    
}
