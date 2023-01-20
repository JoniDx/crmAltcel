<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyPortability extends Mailable
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
        $clientData = $this->info['clientData'];
        $numberPorted = $this->info['numberPorted'];
        $dida = $this->info['dida'];
        $dcr = $this->info['dcr'];
        $icc = $this->info['icc'];
        $numberTransitory = $this->info['numberTransitory'];
        $imsi = $this->info['imsi'];
        $dateActivate = $this->info['dateActivate'];
        $datePort = $this->info['datePort'];
        $nip = $this->info['nip'];
        $rate = $this->info['rate'];
        $dateSend = $this->info['dateSend'];
        $comments = $this->info['comments'];
        $address = $this->info['address'];

        return $this->subject('SOLICITUD DE PORTABILIDAD ALTCEL2 - CONECTA')
                    ->view('mails.notificationPortability',$this->info)
                    ->with([
                            'subject' => 'SOLICITUD DE PORTABILIDAD',
                            'clientData' =>$clientData,
                            'numberPorted' => $numberPorted,
                            'dida' => $dida,
                            'dcr' => $dcr,
                            'icc' => $icc,
                            'numberTransitory' => $numberTransitory,
                            'imsi' => $imsi,
                            'date' => $dateActivate,
                            'datePort' => $datePort,
                            'nip' => $nip,
                            'rate' => $rate,
                            'dateSend' => $dateSend,
                            'comments'=>$comments,
                            'address'=>$address
                        ]);
    }
}
