<?php

namespace App\Models\General;

use Illuminate\Mail\Mailable;

class Mail extends Mailable
{

    public $nombre;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("emails/test")
            ->from("desa.zonanube@gmail.com")
            ->subject("Correo enviado desde ZonaContratista");
    }


}