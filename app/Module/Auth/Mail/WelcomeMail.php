<?php

namespace App\Module\Auth\Mail;

use App\Module\Auth\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
  use Queueable, SerializesModels;

  public function __construct(
    public User $user
  ) {}

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: "Hello and Welcome to our customer community!"
    );
  }

  public function content(): Content
  {
    return new Content(
      view: 'infrastructure.mail.welcome'
    );
  }

  public function attachments(): array
  {
    return [];
  }
}