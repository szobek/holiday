<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateHoliday extends Mailable
{
    use Queueable, SerializesModels;

    protected $sender;
    protected $owner;
    protected $holiday;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender, $owner, $holiday = null)
    {

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }


}
