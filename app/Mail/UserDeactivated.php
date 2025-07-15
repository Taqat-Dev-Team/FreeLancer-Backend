<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDeactivated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reason;
    public $locale;

    public function __construct(User $user, $reason = null)
    {
        $this->user = $user;
        $this->reason = $reason;
        $this->locale = $user->lang ?? 'ar';

    }

    public function build()
    {
        return $this->subject(
            $this->locale === 'en' ? 'Your Account Has Been Deactivated' : 'تم تعطيل حسابك'
        )
            ->view('emails.status')
            ->with([
                'user' => $this->user,
                'locale' => $this->locale,
                'status' => 'inactive',
                'reason' => $this->reason
            ]);
    }


}
