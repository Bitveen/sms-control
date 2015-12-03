@extends('index')

@section('page_title', 'Просмотр подписчика')

@section('content')
    <header class="header">
        @include('nav')
    </header>

    @if(Session::has('subscriberDropSuccess'))
        <p style="text-align: center">{{ Session::get('subscriberDropSuccess') }}</p>
    @endif
    <div class="subscribers-view">
        <h3 class="subscribers-view__header">Просмотр подписчика</h3>
        <form action="/subscribers/{{ $subscriber->id }}" method="post" class="form">
            <div class="form__row">
                <label for="lastName" class="form__label">Фамилия пользователя</label>
                @if(Auth::user()->role == 'admin')
                    <input class="form__input" required type="text" autocomplete="off" name="lastName" id="lastName" value="{{ $subscriber->last_name }}">
                @else
                    <p>
                        {{ $subscriber->last_name }}
                    </p>
                @endif
            </div>
            <div class="form__row">
                <label for="firstName" class="form__label">Имя пользователя</label>
                @if(Auth::user()->role == 'admin')
                    <input class="form__input" id="firstName" autocomplete="off" required type="text" name="firstName" value="{{ $subscriber->first_name }}">
                @else
                    <p>
                        {{ $subscriber->first_name }}
                    </p>
                @endif
            </div>
            <div class="form__row">
                <label for="middleName" class="form__label">Отчество пользователя</label>
                @if(Auth::user()->role == 'admin')
                    <input class="form__input" id="middleName" autocomplete="off" required type="text" name="middleName" value="{{ $subscriber->middle_name }}">
                @else
                    <p>
                        {{ $subscriber->middle_name }}
                    </p>
                @endif
            </div>
            <div class="form__row form__row_with-margin">
                <label for="phoneNumber" class="form__label">Номер телефона</label>
                @if(Auth::user()->role == 'admin')
                    <input class="form__input" required autocomplete="off" type="tel" id="phoneNumber" name="phoneNumber" value="{{ $subscriber->phone_number }}">
                @else
                    <p>
                        {{ $subscriber->phone_number }}
                    </p>
                @endif
            </div>
            <div class="form__footer">
                @if(Auth::user()->role == 'admin')
                    <button type="submit" class="form__button">Сохранить</button><button type="button" class="form__button form__button_drop" id="dropButton">Удалить подписчика</button>
                @endif
            </div>
        </form>
    </div>





    @if(count($breaks) > 0)
        <div class="breaks-list">
            <h3 class="breaks-list__header">Список перерывов</h3>

            @if(Auth::user()->role == 'admin')
                @foreach($breaks as $item)
                    <a href="/breaks/{{ $item->id }}" class="breaks-list__link">
                        <span>Дата начала:
                            {{ $item->start_date->day }}.{{ $item->start_date->month }}.{{ $item->start_date->year }}
                            {{ $item->start_date->format('H') }}:{{ $item->start_date->format('i') }}
                        </span>
                        <span style="float: right">Дата окончания:
                            @if($item->end_date)
                                {{ $item->end_date->day }}.{{ $item->end_date->month }}.{{ $item->end_date->year }}
                                {{ $item->end_date->format('H') }}:{{ $item->end_date->format('i') }}
                            @else
                                Не определено
                            @endif

                        </span>
                    </a>
                @endforeach
            @else
                @foreach($breaks as $item)
                    <div class="breaks-list__link">
                        <span>Дата начала:
                            {{ $item->start_date->day }}.{{ $item->start_date->month }}.{{ $item->start_date->year }}
                            {{ $item->start_date->format('H') }}:{{ $item->start_date->format('i') }}
                        </span>
                        <span style="float: right">Дата окончания:
                            @if($item->end_date)
                                {{ $item->end_date->day }}.{{ $item->end_date->month }}.{{ $item->end_date->year }}
                                {{ $item->end_date->format('H') }}:{{ $item->end_date->format('i') }}
                            @else
                                Не определено
                            @endif

                        </span>
                    </div>
                @endforeach
            @endif


        </div>
    @endif




@endsection

@section('scripts')
    <script src="/js/subscribers-view.js"></script>
@endsection
