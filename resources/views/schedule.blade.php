@extends('index')

@section('page_title', 'График перерывов')

@section('content')

    <script id="chart-view" type="text/x-handlebars-template">
        <div class="row">
            <div class="chart">
                <canvas id="chart-element" width="400" height="400"></canvas>
            </div>
            <div class="breaks-inputs">
                @{{#each data}}
                    <div class="break" data-id="@{{this.id}}">
                        <label class="break__label">Перерыв: </label>
                        <input autocomplete="off" type="text" value="@{{formatTime this.start_date}}" class="break__input"> - <input autocomplete="off" value="@{{formatTime this.end_date}}" type="text" class="break__input">
                        <a href="" class="break__save">Сохранить</a>
                    </div>
                @{{/each}}
            </div>
        </div>
    </script>





    <script id="multiple-chart-view" type="text/x-handlebars-template">
        <div class="multiple-charts">
            @{{#each subscribers}}
                <div class="subscriber-chart" data-id="@{{this.id}}">
                    <canvas width="200" height="200"></canvas>
                    <h4 class="subscriber-chart__title">@{{this.last_name}} @{{this.first_name}} @{{this.middle_name}}</h4>
                </div>
            @{{/each}}
        </div>
    </script>




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
    <script src="/js/vendor/handlebars.js"></script>
    <script src="/js/breaks-chart.js"></script>
    <script src="/js/schedule.js"></script>
@endsection