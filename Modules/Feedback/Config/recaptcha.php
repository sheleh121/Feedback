<?php
/**
 * Created by PhpStorm.
 * User: s112
 * Date: 02.06.19
 * Time: 23:38
 */

return [
    'enabled' => env('RECAPTCHA_ENABLED', true),
    'site_key'     => env('RECAPTCHA_SITE_KEY'),
    'secret_key'  => env('RECAPTCHA_SECRET_KEY'),
];