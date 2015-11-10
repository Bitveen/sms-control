@extends('index')


@section('page_title', 'Список пользователей')

@section('content')
    @include('nav', ['title' => 'Список пользователей'])

    <div class="container" style="margin-top: 30px">
        @if(count($subscribers) > 0)
            <div class="list-group">

                @foreach($subscribers as $subscriber)
                    <a href="/subscribers/{{ $subscriber->id }}" class="list-group-item">
                        <span>{{ $subscriber->last_name }}</span>
                        <span>{{ $subscriber->first_name }}</span>
                        <span>{{ $subscriber->middle_name }}</span>
                        <span class="label label-primary">{{ $subscriber->phone_number }}</span>
                    </a>
                @endforeach
            </div>
        @else
            <p>Пользователи отсутствуют.</p>
        @endif

    </div>

@endsection

@section('scripts')
@endsection