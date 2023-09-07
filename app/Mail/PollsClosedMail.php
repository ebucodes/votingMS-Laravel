<?php

namespace App\Mail;

use App\Models\Election;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PollsClosedMail extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;
    public $info;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        //
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(
            'emails.polls_closed',
            ['info' => $this->info]
        )
            ->subject('Notification - Polls Closed')
            ->from('no-reply@ebucodes.ng', 'EbuCodes');
    }
}
