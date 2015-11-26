@extends('index')

@section('page_title', 'График перерывов')

@section('content')
    <header class="header">
        @include('nav')
    </header>
    <div class="schedule">
        <div class="schedule__header">
            @if(count($subscribers) > 0)
                <form id="scheduleForm" class="form">
                    <div class="form__row form__row_inline">
                        <label class="form__label form__label_inline" for="subscribers">Подписчики:</label>
                        <select name="subscriber" id="subscribers">
                            <option value="all" selected>Все</option>
                            @foreach($subscribers as $subscriber)
                                <option value="{{ $subscriber->id }}">
                                    {{ $subscriber->last_name }}
                                    {{ mb_strcut($subscriber->first_name, 0, 2) }}.
                                    {{ mb_strcut($subscriber->middle_name, 0, 2) }}.
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form__row form__row_inline">
                        <label for="dayToShow" class="form__label form__label_inline">Дата:</label>
                        <input type="text" class="form__input form__input_data" id="dayToShow" name="dayToShow">
                    </div>
                    <button type="submit" class="form__button form__button_inline">Показать</button>
                </form>
            @endif
        </div>
        <div class="schedule__body"></div>
    </div>










@endsection

@section('scripts')
    <script src="/js/vendor/jquery-ui-1.9.2.custom.js"></script>
    <script src="/js/vendor/Chart.js"></script>
    <script src="/js/vendor/moment-with-locales.js"></script>
    <script src="/js/datepicker-settings.js"></script>
    <script src="/js/schedule.js"></script>
@endsection