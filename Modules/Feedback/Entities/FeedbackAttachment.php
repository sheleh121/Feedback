<?php

namespace Modules\Feedback\Entities;

use Illuminate\Database\Eloquent\Model;

class FeedbackAttachment extends Model
{
    protected $fillable = ['id_feedback_message', 'path', 'name'];
}
