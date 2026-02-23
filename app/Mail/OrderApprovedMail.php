<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmacion de Pago - FECOER Gala de Reconocimientos',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-approved',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.ticket', ['order' => $this->order]);

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                "boleta-orden-{$this->order->id}.pdf"
            )->withMime('application/pdf'),
        ];
    }
}
