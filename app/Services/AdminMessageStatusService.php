<?php

namespace App\Services;

use App\Mail\AdminMessageToUser;
use App\Mail\UserActivated;
use App\Mail\UserDeactivated;
use Illuminate\Support\Facades\Mail;

class AdminMessageStatusService
{
    public function sendMessage($user, string $message)
    {
        if (!$user || !$user->email) {
            return response()->json(['message' => 'Email not found.'], 404);
        }

        Mail::to($user->email)->send(new AdminMessageToUser($message, $user));

        return response()->json(['message' => 'Message sent successfully!']);
    }


    public function toggleStatus($user, $reason = null)
    {
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->status = !$user->status;
        $user->status_reason = $reason;
        $user->save();

        if ($user->status) {
            Mail::to($user->email)->send(new UserActivated($user));
        } else {
            Mail::to($user->email)->send(new UserDeactivated($user, $reason));
        }

        return response()->json(['message' => 'Status updated successfully.']);
    }
}
