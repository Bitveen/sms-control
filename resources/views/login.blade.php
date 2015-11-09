@extends('index')

@section('page_title', 'Вход')

@section('content')
    <header class="header">
        <h3 class="header__title">Вход</h3>
    </header>
    <div class="login-form">
        <form action="/login" method="post" class="form">
            <div class="form__row">
                <label class="form__label" for="">Логин</label>
                <input class="form__input" type="text" name="login" placeholder="Введите Ваш логин">
            </div>
            <div class="form__row">
                <label class="form__label" for="">Пароль</label>
                <input class="form__input" type="password" name="password" placeholder="Введите Ваш пароль">
            </div>
            <button class="form__button" type="submit">Войти</button>
            @if(Session::has('loginError'))
                <span>{{ Session::get('loginError') }}</span>
            @endif
        </form>
    </div>
@endsection

@section('scripts')
    <script src="/js/app.js"></script>
@endsection