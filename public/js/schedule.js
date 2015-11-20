(function() {
    "use strict";


    var schedule = {
        init: function() {
            this.scheduleForm = document.getElementById('scheduleForm');
            this.dayToShow = document.getElementById('dayToShow');
            this.subscribersSelect = document.getElementById('subscribers');


            this.canvas = document.getElementById('canvas');
            this.context = this.canvas.getContext('2d');



            //this.scheduleForm.addEventListener('submit', this.handleSubmitForm.bind(this), false);
            this.scheduleForm.addEventListener('submit', function(event) {
                event.preventDefault();

                this.draw([]);

            }.bind(this), false);

        },
        getOptionValue: function(options) {
            var selectedOptionValue = null;
            for (var i = 0; i < options.length; i++) {
                if (options[i].selected) {
                    selectedOptionValue = options[i].value;
                    break;
                }
            }
            return selectedOptionValue;
        },
        handleSubmitForm: function(event) {
            event.preventDefault();
            if (!this.dayToShow.value) {
                return;
            }
            var url = '/api/breaks?dayToShow=' + this.dayToShow.value;
            var selectedOptionValue = this.getOptionValue(this.subscribersSelect.options);

            if (selectedOptionValue && selectedOptionValue != 'all') {
                url += '&subscriber=' + selectedOptionValue;
            }


            var request = new XMLHttpRequest();
            request.open('GET', url, true);
            var self = this;
            request.addEventListener('load', function(event) {
                var response = event.target;
                if (response.status == 200) {
                    var data = JSON.parse(response.responseText);
                    if (selectedOptionValue == 'all') {
                        self.drawAll(data);
                    } else {
                        self.draw(data);
                    }
                }
            }, false);

            request.send();
        },
        draw: function(breaksData) {

            this.context.font = "normal 12px Helvetica";
            this.context.lineWidth = 2;
            this.context.lineCap = "round";


            var width = this.canvas.width;
            var height = this.canvas.height;

            var blockSize = height / 24;

            // Временная шкала
            var leftPadding = this.context.measureText('00:00').width + 3;
            this.context.fillRect(leftPadding, 0, 5, height);

            this.context.beginPath();
            var textToWrite;
            for (var i = 0; i < 24; i++) {
                this.context.moveTo(leftPadding - 5, height - (i * blockSize));
                this.context.lineTo(leftPadding, height - (i * blockSize));
                if (i < 10) {
                    textToWrite = '0';
                }
                textToWrite += i + ':00';
                this.context.fillText(textToWrite, 0, height - (i * blockSize) - 3);
                textToWrite = '';
            }
            this.context.stroke();
            this.context.closePath();




            this.context.fillStyle = "#4EC247";

            this.context.fillRect(0, 0, 100, 50);


        },

        drawAll: function(breaksData) {




        }




    };
    schedule.init();



    function drawMultipleSchedule(data) {

    }





})();