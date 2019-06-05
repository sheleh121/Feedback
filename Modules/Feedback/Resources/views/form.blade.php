@extends('feedback::layouts.app')

@section('content')
    <div class="container">
        <feedback-component :sitekey="'{{$site_key}}'"/>
    </div>
@endsection

