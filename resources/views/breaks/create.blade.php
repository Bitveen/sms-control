@extends('index')

@section('page_title', 'Добавить новый перерыв')

@section('content')
    <header class="header">
        @include('nav')
    </header>

    <div class="breaks-create">
        <h3 class="breaks-create__header">Добавить перерыв</h3>
        <form action="/breaks" method="post" class="form">
            <div class="form__row">
                <label class="form__label" for="subscriber">Подписчик:</label>
                <select name="subscriber" id="subscriber">
                    @if(count($subscribers) > 0)
                        @foreach($subscribers as $subscriber)
                            <option value="{{ $subscriber->id }}">
                                {{ $subscriber->last_name }}
                                {{ mb_strcut($subscriber->first_name, 0, 2) }}.
                                {{ mb_strcut($subscriber->middle_name, 0, 2) }}.
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>


            <div class="form__row">
                <label class="form__label form__label_block" for="startDate">Дата начала:</label>
                <input type="text" id="startDate" name="startDate" class="form__input form__input_data" placeholder="Дата начала">
                <input type="text" name="startTime" class="form__input form__input_time" placeholder="Время в формате 00:00">
            </div>

            <div class="form__row">
                <label class="form__label form__label_block" for="endDate">Дата окончания:</label>
                <input type="text" id="endDate" name="endDate" class="form__input form__input_data" placeholder="Дата окончания">
                <input type="text" name="endTime" class="form__input form__input_time" placeholder="Время в формате 00:00">
            </div>

            <div class="form__footer">
                <button type="submit" class="form__button">Добавить</button>
                @if(Session::has('breakCreateError'))
                    <span>{{ Session::get('breakCreateError') }}</span>
                @endif
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script src="/js/vendor/jquery-ui-1.9.2.custom.js"></script>
    <script src="/js/vendor/moment-with-locales.js"></script>
    <script src="/js/breaks-create.js"></script>
@endsection