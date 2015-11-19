@extends('index')

@section('page_title', 'График')

@section('content')
    @include('nav', ['title' => 'График'])

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(count($subscribers) > 0)
                    <form id="scheduleForm" action="/schedule" method="post" class="form-inline">
                        <div class="form-group">
                            <label for="subscribers">Пользователь:</label>
                            <select name="subscriber" id="subscribers" class="form-control" title="Список пользователей">
                                @foreach($subscribers as $subscriber)
                                    <option value="all" selected>Все</option>
                                    <option value="{{ $subscriber->id }}">
                                        {{ $subscriber->last_name }}
                                        {{ mb_strcut($subscriber->first_name, 0, 2) }}.
                                        {{ mb_strcut($subscriber->middle_name, 0, 2) }}.
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dayToShow">Дата:</label>
                            <input type="text" class="form-control" id="dayToShow" name="dayToShow">
                        </div>

                        <button type="submit" class="btn btn-primary">Показать</button>
                    </form>
                @endif
            </div>
            <div class="panel-body"  style="overflow: scroll; text-align: center">
                <canvas style="display: inline-block" id="canvas" width="600" height="600"></canvas>
            </div>
        </div>

    </div>





@endsection

@section('scripts')
    <script src="/js/vendor/bootstrap-datepicker.min.js"></script>
    <script src="/js/vendor/bootstrap-datepicker.ru.min.js"></script>
    <script src="/js/schedule.js"></script>
@endsection