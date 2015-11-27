@extends('index')

@section('page_title', 'Редактирование перерыва')

@section('content')
    <header class="header">
        @include('nav')
    </header>

    <div class="breaks-create">
        <h3 class="breaks-create__header">Редактирование перерыва:
            <a class="subscriber-link" href="/subscribers/{{ $breakItem->subscriber_id }}">
                {{ $breakItem->last_name }}
                {{ mb_strcut($breakItem->first_name, 0, 2) }}.
                {{ mb_strcut($breakItem->middle_name, 0, 2) }}.
            </a>
        </h3>
        <form action="/breaks/{{ $breakItem->id }}" method="post" class="form">
            <div class="form__row">
                <label class="form__label form__label_block" for="startDate">Дата начала:</label>
                <input autocomplete="off" type="text" id="startDate" value="{{ $breakItem->start_date->format('d') }}.{{ $breakItem->start_date->format('m') }}.{{ $breakItem->start_date->format('Y') }}" name="startDate" class="form__input form__input_data" placeholder="Дата начала">
                <input autocomplete="off" type="text" name="startTime" value="{{ $breakItem->start_date->format('H') }}:{{ $breakItem->start_date->format('i') }}" class="form__input form__input_time" placeholder="Время в формате 00:00">
            </div>

            <div class="form__row">
                <label class="form__label form__label_block" for="endDate">Дата окончания:</label>
                <input autocomplete="off" type="text" id="endDate" name="endDate" value="{{ $breakItem->end_date->format('d') }}.{{ $breakItem->end_date->format('m') }}.{{ $breakItem->end_date->format('Y') }}" class="form__input form__input_data" placeholder="Дата окончания">
                <input autocomplete="off" type="text" name="endTime" value="{{ $breakItem->end_date->format('H') }}:{{ $breakItem->end_date->format('i') }}" class="form__input form__input_time" placeholder="Время в формате 00:00">
            </div>

            <div class="form__footer">
                <button type="submit" class="form__button">Сохранить</button>
                @if(Session::has('breakUpdateError'))
                    <span>{{ Session::get('breakUpdateError') }}</span>
                @endif
                @if(Session::has('breakUpdateSuccess'))
                    <span>{{ Session::get('breakUpdateSuccess') }}</span>
                @endif
                <button class="form__button form__button_drop">Удалить перерыв</button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script src="/js/vendor/jquery-ui-1.9.2.custom.js"></script>
    <script src="/js/vendor/moment-with-locales.js"></script>
    <script src="/js/datepicker-settings.js"></script>
    <script src="/js/breaks-create.js"></script>
    <script src="/js/break-view.js"></script>
@endsection