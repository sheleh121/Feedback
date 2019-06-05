<?php

namespace Modules\Feedback\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Feedback\Entities\AppSetting;

class FeedbackSettingController extends Controller
{
    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response('Method not allowed',405);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'support_email' => 'required|email'
        ]);

        $support_email = AppSetting::where('key', 'support_email')->first();
        $support_email->value = $request->support_email;
        $support_email->save();

        return back()->with('status', 'Изменения сохранены!');
    }
}
