<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuperVoteCastMail extends Mailable
{
    use Queueable, SerializesModels;
    public $super;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($super)
    {
        //
        $this->super = $super;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(
            'emails.super_vote_cast',
            ['super' => $this->super]
        )
            ->subject('Notification - Vote submitted')
            ->from('no-reply@ebucodes.ng', 'EbuCodes');
    }
}
