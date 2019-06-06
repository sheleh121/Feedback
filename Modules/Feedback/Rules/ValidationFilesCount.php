<?php

namespace Modules\Feedback\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidationFilesCount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (count($value) > 5) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Количество файлов не должно быть больше 5';
    }
}
