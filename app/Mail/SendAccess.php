<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAccess extends Mailable
{
    use Queueable, SerializesModels;
    public $info;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->info = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->info['subject'];
        $name = $this->info['name'];
        $lastname = $this->info['lastname'];
        $user = $this->info['user'];
        $password = $this->info['password'];

        return $this->subject($subject)
                    ->view('mails.sendAccess',$this->info)
                    ->with([
                        'subject' => $subject,
                        'name' =>$name,
                        'lastname' => $lastname,
                        'user' => $user,
                        'password' => $password
                        ]);
    }
}
