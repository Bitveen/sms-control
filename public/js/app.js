(function() {
    var request = new XMLHttpRequest();
    request.open('GET', '/api/messages', true);
    request.onload = function(event) {

        console.log(JSON.parse(event.target.responseText));

    };
    request.send();


})();