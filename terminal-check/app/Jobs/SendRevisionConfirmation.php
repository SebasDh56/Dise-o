<?php

namespace App\Jobs;

use App\Models\Cooperativa;
use App\Mail\RevisionConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRevisionConfirmation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cooperativa;
    public $revisiones;
    public $toEmail;

    public function __construct(Cooperativa $cooperativa, array $revisiones, string $toEmail)
    {
        $this->cooperativa = $cooperativa;
        $this->revisiones = $revisiones;
        $this->toEmail = $toEmail;
    }

    public function handle()
    {
        Mail::to($this->toEmail)->send(new RevisionConfirmation($this->cooperativa, $this->revisiones));
    }
}