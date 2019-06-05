<?php

namespace Modules\Feedback\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $answer;
    protected $source_message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($answer, $source_message)
    {
        $this->answer = $answer;
        $this->source_message = $source_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Обратная связь')
            ->view('feedback::emails/response_to_user')
            ->with([
                'answer' => $this->answer
                ,'source_message' => $this->source_message
            ]);
    }
}
