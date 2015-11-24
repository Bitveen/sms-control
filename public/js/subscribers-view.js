(function() {
    "use strict";

    // Удалить подписчика
    var dropButton = document.getElementById('dropButton');
    dropButton.addEventListener('click', function(event) {
        event.preventDefault();
        var answer = confirm('Вы действительно хотите удалить подписчика?');
        if (answer) {
            var request = new XMLHttpRequest();
            request.open('POST', '/subscribers/drop', true);
            request.addEventListener('load', function(event) {
                var response = event.target;
                if (response.status == 200) {
                    location.assign('/subscribers');
                }
            }, false);
            var data = new FormData();
            data.append('id', location.pathname.split('/').pop());
            request.send(data);
        }
    }, false);





})();