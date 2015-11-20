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
        <form action="/subscribers/{{ $subscriber->id }}" method="post" class="form">
            <div class="form__row">
                <label for="lastName" class="form__label">Фамилия пользователя</label>
                <input class="form__input" required type="text" autocomplete="off" name="lastName" id="lastName" value="{{ $subscriber->last_name }}">
            </div>
            <div class="form__row">
                <label for="firstName" class="form__label">Имя пользователя</label>
                <input class="form__input" id="firstName" autocomplete="off" required type="text" name="firstName" value="{{ $subscriber->first_name }}">
            </div>
            <div class="form__row">
                <label for="middleName" class="form__label">Отчество пользователя</label>
                <input class="form__input" id="middleName" autocomplete="off" required type="text" name="middleName" value="{{ $subscriber->middle_name }}">
            </div>
            <div class="form__row form__row_with-margin">
                <label for="phoneNumber" class="form__label">Номер телефона</label>
                <input class="form__input" required autocomplete="off" type="tel" id="phoneNumber" name="phoneNumber" value="{{ $subscriber->phone_number }}">
            </div>
            <div class="form__footer">
                <button type="submit" class="form__button">Сохранить</button><button type="button" class="form__button form__button_drop" id="dropButton">Удалить</button>
            </div>
        </form>
    </div>




@endsection

@section('scripts')
    <script src="/js/subscribers-view.js"></script>
@endsection