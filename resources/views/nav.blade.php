<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand navbar-left">
                {{ $title }}
            </span>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                @if($title == 'График')
                    <li class="active"><a href="/schedule">График</a></li>
                @else
                    <li><a href="/schedule">График</a></li>
                @endif

                @if($title == 'Создание нового пользователя')
                    <li class="active"><a href="/subscribers/create">Создать нового пользователя</a></li>
                @else
                    <li><a href="/subscribers/create">Создать нового пользователя</a></li>
                @endif

                @if($title == 'Список пользователей')
                    <li class="active"><a href="/subscribers">Список пользователей</a></li>
                @else
                    <li><a href="/subscribers">Список пользователей</a></li>
                @endif
                <li><a href="/logout">Выход</a></li>
            </ul>
        </div>
    </div>
</nav>