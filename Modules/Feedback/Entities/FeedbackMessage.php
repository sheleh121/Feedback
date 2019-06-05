<?php

namespace Modules\Feedback\Entities;

use Illuminate\Database\Eloquent\Model;

class FeedbackMessage extends Model
{
    protected $fillable = [];

    public function attachments() {
        return $this->hasMany('Modules\Feedback\Entities\FeedbackAttachment', 'id_feedback_message', 'id');
    }
}
