(function() {
    "use strict";
    var dropButton = document.querySelector('.form__button_drop');


    dropButton.addEventListener('click', function(event) {
        event.preventDefault();
        var confirmed = confirm('Вы действительно хотите удалить перерыв?');
        if (confirmed) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/breaks/drop/' + location.pathname.split('/').pop(), true);

            xhr.addEventListener('load', function(event) {
                var response = event.target;
                if (response.status == 200) {
                    var subscriberId = document.querySelector('.subscriber-link').href.split('/').pop();
                    location.assign('/subscribers/' + subscriberId);
                }
            }, false);

            xhr.send();
        }




    }, false);





})();