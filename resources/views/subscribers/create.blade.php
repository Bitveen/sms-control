@extends('index')

@section('page_title', 'Создание нового подписчика')

@section('content')
    <header class="header">
        @include('nav')
    </header>


    <div class="subscribers-create">
        <h3 class="subscribers-create__header">Создать подписчика</h3>
        <form action="/subscribers" method="post" class="form">
            <div class="form__row">
                <label for="lastName" class="form__label">Фамилия пользователя</label>
                <input class="form__input" id="lastName" autocomplete="off" required type="text" name="lastName" placeholder="Введите фамилию пользователя">
            </div>
            <div class="form__row">
                <label for="firstName" class="form__label">Имя пользователя</label>
                <input class="form__input" id="firstName" autocomplete="off" required type="text" name="firstName" placeholder="Введите имя пользователя">
            </div>
            <div class="form__row">
                <label for="middleName" class="form__label">Отчество пользователя</label>
                <input class="form__input" id="middleName" autocomplete="off" required type="text" name="middleName" placeholder="Введите отчество пользователя">
            </div>
            <div class="form__row form__row_with-margin">
                <label for="phoneNumber" class="form__label">Номер телефона</label>
                <input class="form__input" required type="tel" autocomplete="off" id="phoneNumber" name="phoneNumber"
                       placeholder="Номер телефона начинается с 7">
            </div>
            <div class="form__footer">
                <button type="submit" class="form__button">Создать</button>
                @if(Session::has('subscriberCreateError'))
                    <span>{{ Session::get('subscriberCreateError') }}</span>
                @endif
            </div>
        </form>
    </div>





@endsection

@section('scripts')
@endsection