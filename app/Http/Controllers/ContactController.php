<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:50',
            'service' => 'required|string',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // Send email
            Mail::send('emails.contact', ['data' => $validated], function ($msg) use ($validated) {
                $msg->to('mahdiazou33@gmail.com'); // CHANGE EMAIL HERE
                $msg->subject('Nouvelle demande de contact');
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => __('contact.success')
                ]);
            }

            return back()->with('status', __('contact.success'));
        } catch (\Exception $e) {
            $message = __('contact.error');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error'   => $e->getMessage(),
                    'message' => $message
                ], 500);
            }

            return back()->withErrors(['message' => $message]);
        }
    }
}
