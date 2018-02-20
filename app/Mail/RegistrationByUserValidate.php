<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationByUserValidate extends Mailable
{
    use Queueable, SerializesModels;

    protected $pass;
    protected $user;

    public function __construct($user, $pass)
    {
        $this->pass = $pass;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $pass = $this->pass;
        $datas = "asasaasasas";
        return $this
            ->from('noreply@versenyhajoholiday.com')
            ->to('kunszt.norbert@gmail.com')
            ->subject('Regisztráció')
            ->view('mail.registration.by_user', compact('user', 'pass'))
            ->with('datas', 'asdasdasd');
    }
}
