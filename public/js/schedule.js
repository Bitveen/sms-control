(function() {
    "use strict";
    $('#dayToShow').datepicker({
        language: 'ru',
        orientation: 'top left'
    });



    // Форма для передачи данных о графике
    var scheduleForm = document.getElementById('scheduleForm');
    var dayToShow = document.getElementById('dayToShow');
    var subscribersSelect = document.getElementById('subscribers');


    function getOptionValue(options) {
        var selectedOptionValue = null;
        for (var i = 0; i < options.length; i++) {
            if (options[i].selected) {
                selectedOptionValue = options[i].value;
                break;
            }
        }
        return selectedOptionValue;
    }


    scheduleForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if (!dayToShow.value) {
            return;
        }
        var url = '/api/breaks?dayToShow=' + dayToShow.value;
        var selectedOptionValue = getOptionValue(subscribersSelect.options);

        if (selectedOptionValue != 'all') {
            url += '&subscriber=' + selectedOptionValue;
        }


        var request = new XMLHttpRequest();
        request.open('GET', url, true);
        request.addEventListener('load', function(event) {
            var response = event.target;
            if (response.status == 200) {
                var data = JSON.parse(response.responseText);
                if (selectedOptionValue == 'all') {
                    drawMultipleSchedule(data);
                } else {
                    drawSingleSchedule(data);
                }
            }
        }, false);
        request.send();

    } , false);


    function drawSingleSchedule(data) {
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');

        context.font = "normal 12px Helvetica";

        context.lineWidth = 2;
        context.lineCap = "round";
        var width = canvas.width;
        var height = canvas.height;
        var blockSize = height / 24;




        // Временная шкала
        var leftPadding = context.measureText('00:00').width + 3;
        context.fillRect(leftPadding, 0, 5, height);

        context.beginPath();
        var textToWrite;
        for (var i = 0; i < 24; i++) {
            context.moveTo(leftPadding - 5, height - (i * blockSize));
            context.lineTo(leftPadding, height - (i * blockSize));
            if (i < 10) {
                textToWrite = '0';
            }
            textToWrite += i + ':00';
            context.fillText(textToWrite, 0, height - (i * blockSize) - 3);
            textToWrite = '';
        }
        context.stroke();
        context.closePath();




        context.fillStyle = "#4EC247";

        context.fillRect(0, 0, 100, 50);


    }



    function drawMultipleSchedule(data) {

    }





})();