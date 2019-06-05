@extends('layouts.app')

@section('nav')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('feedback.index') }}">ФОРМА</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.feedback.index') }}">АДМИНКА</a>
    </li>
@endsection
