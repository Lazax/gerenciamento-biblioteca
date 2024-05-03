<?php

namespace App\Mail;

use App\Models\LendingBook as ModelsLendingBook;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LendingBook extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public ModelsLendingBook $lendingBook
    )
    {
        $this->lendingBook->loan_date = Carbon::parse($this->lendingBook->loan_date)->format('d/m/Y');
        $this->lendingBook->return_date = Carbon::parse($this->lendingBook->return_date)->format('d/m/Y');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Novo emprestimo - {$this->lendingBook->book->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.lending-book',
            with: [],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
