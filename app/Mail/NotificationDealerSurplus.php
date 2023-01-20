<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationDealerSurplus extends Mailable
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
        $offerSurplus = $this->info['offerSurplus'];
        $client_name = $this->info['client_name'];
        $service = $this->info['service'];
        $msisdn = $this->info['msisdn'];

        return $this->subject($subject)
                    ->view('mails.notificationDealerSurplus',$this->info)
                    ->with([
                            'offerSurplus' => $offerSurplus,
                            'client_name' =>$client_name,
                            'service' => $service,
                            'msisdn'=>$msisdn
                        ]);
    }
}
