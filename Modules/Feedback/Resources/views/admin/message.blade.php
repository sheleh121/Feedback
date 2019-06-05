@extends('feedback::layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            @if (session('status_error'))
                <div class="alert alert-success">
                    {{ session('status_error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="main-wrap">
                <div class="row">
                    <div class="col">
                        <h3>
                            {{$message->user_name}}
                            <small>
                                <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                            </small>
                        </h3>
                        <div class="text-break">
                            <p>{{$message->body}}</p>
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
                                    <form action="{{ route('admin.feedback.destroy', ['id' => $message->id]) }}" method="post" >
                                        @csrf
                                        @method('DELETE')
                                        <input onclick ="return confirm(' Вы уверены?')" class="dropdown-item" type="submit" value="Удалить">
                                    </form>
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
                <form action="{{ route('admin.feedback.store') }}" method="post">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $message->id }}">
                    <div class="form-group">
                        <label for="answer">Ответ</label>
                        <textarea class="form-control @error('answer') is-invalid @enderror"  id="answer" name="answer" rows="10">{{ old('answer') }}</textarea>

                        @error('answer')
                        <span class="invalid-feedback" role="alert">
                            <strong>Ответ должен содержать от 10 до 1000 символов</strong>
                        </span>
                        @enderror
                    </div>
                    <input onclick ="return confirm(' Отправить?')" class="btn btn-light" type="submit" value="Отправить">
                </form>
            </div>

    </div>
@stop