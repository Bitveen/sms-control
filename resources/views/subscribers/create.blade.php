@extends('index')

@section('page_title', 'Создание нового пользователя')

@section('content')
    <header class="header">
        <h3 class="header__page-title">Создание нового пользователя</h3>
        @include('nav')
    </header>

    <div class="subscriber-create">
        <form action="/subscribers" method="post" class="form">
            <div class="form__row">
                <label for="" class="form__label">Фамилия пользователя</label>
                <input class="form__input" required type="text" name="lastName" placeholder="Введите фамилию пользователя">
            </div>
            <div class="form__row">
                <label for="" class="form__label">Имя пользователя</label>
                <input class="form__input" required type="text" name="firstName" placeholder="Введите имя пользователя">
            </div>
            <div class="form__row">
                <label for="" class="form__label">Отчество пользователя</label>
                <input class="form__input" required type="text" name="middleName" placeholder="Введите отчество пользователя">
            </div>
            <div class="form__row">
                <label for="" class="form__label">Номер телефона</label>
                <input class="form__input" required type="tel" name="phoneNumber"
                       placeholder="Номер телефона начинается с 7">
            </div>

            <button type="submit" class="form__button">Создать</button>
        </form>
    </div>


@endsection

@section('scripts')
@endsection