<?php

namespace Modules\Feedback\Http\Controllers\Admin;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\Feedback\Emails\NotificationUser;
use Modules\Feedback\Entities\AppSetting;
use Modules\Feedback\Entities\FeedbackMessage;

class MessageController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $messages = FeedbackMessage::with('attachments')->orderByDesc('id')->paginate(20);
        $email_support = AppSetting::where('key', 'support_email')->value('value');
        return view('feedback::admin/messages')->with([
            'messages' => $messages
            ,'email_support' => $email_support
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
            'answer' => 'string|min:10|max:1000'
        ]);

        $source_message = FeedbackMessage::find($request->id);

        Mail::to($source_message->email)->send(new NotificationUser($request->answer, $source_message));
        return back()->with('status', 'Сообщение успешно отправлено!');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $message = FeedbackMessage::with('attachments')->find($id);
        return view('feedback::admin/message')->with(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $message = FeedbackMessage::with('attachments')->find($id);

        if (count($message->attachments) > 0) {
            foreach ($message->attachments as $attachment) {
                $attachment->delete();
            }
            Storage::deleteDirectory('feedback/attachments/' . $id);
        }
        $message->delete();

        return redirect('admin/feedback');

    }
}
