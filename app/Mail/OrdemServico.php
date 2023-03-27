<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrdemServico extends Mailable
{
    use Queueable, SerializesModels;
    public $assunto;
    public $ordem;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assunto, $ordem)
    {
        $this->ordem = $ordem;
        $this->assunto = $assunto;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            /*from: new Address(config('MAIL_FROM_ADDRESS'), config('MAIL_FROM_NAME')),*/
            subject: $this->assunto,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.ordemservico',
            text: 'emails.ordemservico_text'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    /*public function build()
    {
        return $this->view('emails.ordemservico')
            ->text( 'emails.ordemservico_text' )
            ->subject($this->assunto)
            ->with([
                'ordem' => $this->ordem
            ]);
    }*/
}
