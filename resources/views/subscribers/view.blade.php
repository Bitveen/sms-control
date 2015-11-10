@extends('index')

@section('page_title', 'Просмотр пользователя')

@section('content')
    @include('nav', ['title' => $subscriber->last_name.' '.$subscriber->first_name.' '.$subscriber->middle_name])
    <div class="subscriber-create container">
        <form action="/subscribers/{{ $subscriber->id }}" method="post" class="form">
            <div class="form__row">
                <label for="" class="form__label">Фамилия пользователя</label>
                <input class="form__input" required type="text" name="lastName" value="{{ $subscriber->last_name }}">
            </div>
            <div class="form__row">
                <label for="" class="form__label">Имя пользователя</label>
                <input class="form__input" required type="text" name="firstName" value="{{ $subscriber->first_name }}">
            </div>
            <div class="form__row">
                <label for="" class="form__label">Отчество пользователя</label>
                <input class="form__input" required type="text" name="middleName" value="{{ $subscriber->middle_name }}">
            </div>
            <div class="form__row">
                <label for="" class="form__label">Номер телефона</label>
                <input class="form__input" required type="tel" name="phoneNumber" value="{{ $subscriber->phone_number }}">
            </div>
            <button type="submit" class="form__button">Сохранить</button>
        </form>
    </div>


@endsection

@section('scripts')
@endsection