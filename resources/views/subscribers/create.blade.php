@extends('index')

@section('page_title', 'Создание нового подписчика')

@section('content')
    <header class="header">
        @include('nav')
    </header>


    <div class="subscribers-create">
        <form action="/subscribers" method="post" class="form">
            <div class="form__row">
                <label for="lastName" class="form__label">Фамилия пользователя</label>
                <input class="form__input" id="lastName" required type="text" name="lastName" placeholder="Введите фамилию пользователя">
            </div>
            <div class="form__row">
                <label for="firstName" class="form__label">Имя пользователя</label>
                <input class="form__input" id="firstName" required type="text" name="firstName" placeholder="Введите имя пользователя">
            </div>
            <div class="form__row">
                <label for="middleName" class="form__label">Отчество пользователя</label>
                <input class="form__input" id="middleName" required type="text" name="middleName" placeholder="Введите отчество пользователя">
            </div>
            <div class="form__row form__row_with-margin">
                <label for="phoneNumber" class="form__label">Номер телефона</label>
                <input class="form__input" required type="tel" id="phoneNumber" name="phoneNumber"
                       placeholder="Номер телефона начинается с 7">
            </div>
            <div class="form__footer">
                <button type="submit" class="form__button">Создать</button>
            </div>
        </form>
    </div>





@endsection

@section('scripts')
@endsection