<?php

namespace Modules\Feedback\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Feedback\Entities\FeedbackMessage;

class NotificationAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $message ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FeedbackMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Новое обращение пользователя через форму обратной связи')
            ->view('feedback::emails/notification_admin')
            ->with([
                'user_name' => $this->message->user_name
                ,'email' => $this->message->email
                ,'body' => $this->message->body
            ]);
    }
}
