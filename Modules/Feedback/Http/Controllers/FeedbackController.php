<?php

namespace Modules\Feedback\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Feedback\Emails\NotificationAdmin;
use Modules\Feedback\Entities\AppSetting;
use Modules\Feedback\Entities\FeedbackAttachment;
use Modules\Feedback\Entities\FeedbackMessage;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Feedback\Rules\ValidationFilesCount;
use Modules\Feedback\Rules\ValidationReCaptcha;

class FeedbackController extends Controller
{
    use ValidatesRequests;

    protected function checkRecaptcha($token)
    {
        $response = (new Client)->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret'   => config('recaptcha.secret_key'),
                'response' => $token,
            ],
        ]);
        $response = json_decode((string)$response->getBody(), true);
        return $response['success'];
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('feedback::form', [
            'site_key' => config('recaptcha.site_key')
            ,'captcha_enabled' => config('recaptcha.enabled')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'user_name' => 'required|string|min:2|max:25'
            ,'email' => 'required|email'
            ,'body' => 'required|string|min:10|max:1000'
            ,'attachments' => new ValidationFilesCount
            ,'captcha_token' => new ValidationReCaptcha
        ]);

        $message = new FeedbackMessage;
        $message->user_name = $request->user_name;
        $message->email = $request->email;
        $message->body = $request->body;
        $message->save();

        if ($request->hasFile('attachments')) {

            foreach ($request->file('attachments') as $attachment) {
                $path = 'feedback/attachments/' . $message->id;
                $path = $attachment->store($path);

                FeedbackAttachment::create([
                    'path' => $path
                    ,'id_feedback_message' => $message->id
                    ,'name' => $attachment->getClientOriginalName()
                ]);
            }
        }

        $email = AppSetting::where('key', 'support_email')->value('value');
        Mail::to($email)->send(new NotificationAdmin($message));

        return response('Благодарим за обратную связь! В ближайшее время вы получите ответ на указанный вами адрес электронной почты.', 200);
    }

}
