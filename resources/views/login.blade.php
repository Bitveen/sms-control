@extends('index')

@section('page_title', 'Вход')

@section('content')
    <header class="header"></header>
    <div class="login-form">
        <form action="/login" method="post" class="form">
            <div class="form__row">
                <div class="form__col-left">
                    <label class="form__label" for="login">Логин:</label>
                </div>
                <div class="form__col-right">
                    <input class="form__input" autocomplete="off" type="text" id="login" name="login" placeholder="Введите Ваш логин">
                </div>
            </div>
            <div class="form__row">
                <div class="form__col-left">
                    <label class="form__label" for="password">Пароль:</label>
                </div>
                <div class="form__col-right">
                    <input class="form__input" autocomplete="off" type="password" id="password" name="password" placeholder="Введите Ваш пароль">
                </div>
            </div>

            <div class="form__footer">
                <button type="submit" class="form__button">Войти</button>
                @if(Session::has('loginError'))
                    <span>{{ Session::get('loginError') }}</span>
                @endif
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection