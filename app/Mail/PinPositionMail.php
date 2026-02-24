<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PinPositionMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $date;

    public string $pdfUrl;

    public function __construct(string $date, string $pdfUrl)
    {
        $this->date = $date;
        $this->pdfUrl = $pdfUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "ピン位置表（{$this->date}）",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pin_position',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
