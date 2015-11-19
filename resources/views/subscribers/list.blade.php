@extends('index')


@section('page_title', 'Список подписчиков')

@section('content')
    <header class="header">
        @include('nav')
    </header>

    <div class="subscribers-list">
        @if(count($subscribers) > 0)
            @foreach($subscribers as $subscriber)
                <a href="/subscribers/{{ $subscriber->id }}" class="subscribers-list__link">
                    <span>{{ $subscriber->last_name }}</span>
                    <span>{{ $subscriber->first_name }}</span>
                    <span>{{ $subscriber->middle_name }}</span>
                    <span style="float: right">{{ $subscriber->phone_number }}</span>
                </a>
            @endforeach
        @else
            <p>Пользователи отсутствуют.</p>
        @endif
    </div>

@endsection

@section('scripts')
@endsection