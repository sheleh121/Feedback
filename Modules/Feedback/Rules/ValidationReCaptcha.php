<?php

namespace Modules\Feedback\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class ValidationReCaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if (config('recaptcha.enabled')){
            $response = (new Client)->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret'   => config('recaptcha.secret_key'),
                    'response' => $value,
                ],
            ]);
            $response = json_decode((string)$response->getBody(), true);
            return $response['success'];
        } else return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Неверный токен ReCaptcha';
    }
}
