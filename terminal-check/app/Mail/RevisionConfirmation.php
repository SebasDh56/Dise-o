<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Cooperativa;

class RevisionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $cooperativa;
    public $revisiones;

    public function __construct(Cooperativa $cooperativa, array $revisiones)
    {
        $this->cooperativa = $cooperativa;
        $this->revisiones = $revisiones;
    }

    public function build()
    {
        return $this->subject('Confirmación de Revisión - ' . $this->cooperativa->nombre)
                    ->view('emails.revision-confirmation');
    }
}