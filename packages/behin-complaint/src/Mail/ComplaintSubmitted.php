<?php
namespace Behin\Complaint\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    protected $attachmentPath;
    /**
     * Create a new message instance.
     */
    public function __construct($data, $attachmentPath = null)
    {
        $this->data = $data;
        $this->attachmentPath = $attachmentPath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $email = $this->subject('فرم شکایت جدید')
                      ->view('ComplaintViews::emails.complaint_submitted');

        if ($this->attachmentPath) {
            $email->attach($this->attachmentPath);
        }

        return $email;
    }
}
