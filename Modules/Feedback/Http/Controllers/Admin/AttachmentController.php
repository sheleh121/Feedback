<?php

namespace Modules\Feedback\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Feedback\Entities\FeedbackAttachment;

class AttachmentController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('feedback::index');
    }

    public function show($id)
    {
        $file = Storage::get(FeedbackAttachment::find($id)->path);
        return response($file)->header('Content-Type', 'file')->header('Content-Disposition', 'attachment');
    }

}
