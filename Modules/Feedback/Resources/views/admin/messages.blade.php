@extends('feedback::layouts.app')

@section('content')
    <div class="container">
        <div class="main-wrap">
            <form action="{{ route('admin.feedback.settings.update') }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="support_email">E-mail для уведомлений</label>
                    <input class="form-control @error('support_email') is-invalid @enderror" id="support_email" name="support_email" value="{{ $email_support }}">

                    @error('support_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>Неверный формат e-mail</strong>
                    </span>
                    @enderror
                </div>
                <input onclick ="return confirm('Изменить e-mail?')" class="btn btn-light" type="submit" value="Изменить">
            </form>
        </div>
        @foreach ($messages as $message)
            <div class="main-wrap">
                <div class="row">
                    <div class="col">
                        <h3>{{$message['user_name']}} <small>({{$message['email']}})</small></h3>

                        <div class="text-break">
                            <p>{{$message['body']}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group float-right">
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Действия
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownActions">
                                    <form action="{{ route('admin.feedback.destroy', $message->id) }}" method="post" >
                                        @csrf
                                        @method('DELETE')
                                        <input onclick ="return confirm(' Вы уверены?')" class="dropdown-item" type="submit" value="Удалить">
                                    </form>
                                    <a class="dropdown-item" href="{{ route('admin.feedback.edit', $message->id) }}">Ответить</a>
                                </div>
                            </div>
                            @if (count($message->attachments) > 0)
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownAttachments" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Вложения
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownAttachments">
                                        @foreach($message->attachments as $attachment)
                                            <a class="dropdown-item" href="{{ route('attachment.show', $attachment->id) }}">{{$attachment->name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
            {{ $messages->render() }}
    </div>
@stop