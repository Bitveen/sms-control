(function() {
    "use strict";

    // Удалить подписчика
    var dropButton = document.getElementById('dropButton');
    dropButton.addEventListener('click', function(event) {
        event.preventDefault();
        var answer = confirm('Вы действительно хотите удалить подписчика?');
        if (answer) {
            var request = new XMLHttpRequest();
            request.open('POST', '/api/subscribers/drop', true);
            request.addEventListener('load', function(event) {
                var response = event.target;
                if (response.status == 200) {
                    location.assign('/subscribers');
                }
            }, false);

            request.addEventListener('error', function(event) {
                console.log('Error');
            });

            var data = new FormData();
            data.append('id', location.pathname.split('/').pop());
            request.send(data);
        }
    }, false);





})();