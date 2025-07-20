<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;


use App\Models\User;

class FreelancerApprove extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $locale;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->locale = $user->lang ?? 'ar';

    }

    public function build()
    {
        return $this->subject(
            $this->locale === 'en' ? 'Your Account Has Been Approved' : 'تم قبول حسابك'
        )
            ->view('emails.approve-reject')
            ->with([
                'user' => $this->user,
                'locale' => $this->locale,
                'status' => 'active',
                'reason' => null
            ]);
    }


}
