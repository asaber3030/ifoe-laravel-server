<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class SendContactMessage extends Mailable
{
  use Queueable, SerializesModels;

  private $emailValue;
  private $firstNameValue;
  private $lastNameValue;
  private $messageValue;
  private $subjectValue;

  /**
   * Create a new message instance.
   */
  public function __construct($firstNameValue, $lastNameValue, $emailValue, $messageValue, $subjectValue)
  {
    $this->firstNameValue = $firstNameValue;
    $this->lastNameValue = $lastNameValue;
    $this->emailValue = $emailValue;
    $this->messageValue = $messageValue;
    $this->subjectValue = $subjectValue;
  }


  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Contact Message - IFOE Website',
      from: 'abdulrahmansaber120@gmail.com',
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.contact-message',
      with: [
        'firstNameValue' => $this->firstNameValue,
        'lastNameValue' => $this->lastNameValue,
        'emailValue' => $this->emailValue,
        'messageValue' => $this->messageValue,
        'subjectValue' => $this->subjectValue,
      ],
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
