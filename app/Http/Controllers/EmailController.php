<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
            'email-to' => 'required|string',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emails = explode(' ', $request->input('email-to'));
        $emails = array_filter($emails, 'strlen'); // Remove empty values
        $emails = array_unique($emails); // Remove duplicates

        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->withErrors(['email-to' => 'Invalid email format'])->withInput();
            }
        }

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
            Mail::to($email)->send(new SendEmail($subject, $message));
        }

        return redirect()->back()->with('status', 'Emails sent successfully');
    }

    private function scheduleEmail($emails, $subject, $message, $scheduledDateTime)
    {
            $scheduledDateTime = Carbon::parse($scheduledDateTime);
            foreach ($emails as $email) {
                Mail::to($email)->later($scheduledDateTime, new SendEmail($subject, $message));
            }
    }
    
    
}
