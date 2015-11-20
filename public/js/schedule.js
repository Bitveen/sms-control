(function() {
    "use strict";


    var schedule = {
        init: function() {
            this.scheduleForm = document.getElementById('scheduleForm');
            this.dayToShow = document.getElementById('dayToShow');
            this.subscribersSelect = document.getElementById('subscribers');
            this.canvasContainer = document.querySelector('.schedule__body');


            this.scheduleForm.addEventListener('submit', this.handleSubmitForm.bind(this), false);


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
            this.selectedOptionValue = this.getOptionValue(this.subscribersSelect.options);

            if (this.selectedOptionValue && this.selectedOptionValue != 'all') {
                url += '&subscriber=' + this.selectedOptionValue;
            }


            var request = new XMLHttpRequest();
            request.open('GET', url, true);
            var self = this;
            request.addEventListener('load', function(event) {
                var response = event.target;
                if (response.status == 200) {
                    var data = JSON.parse(response.responseText);
                    if (self.selectedOptionValue == 'all') {
                        self.drawCircleAll(data);
                    } else {
                        self.drawCircle(data);
                    }
                }
            }, false);

            request.send();
        },

        makeLabel: function(startDate, endDate) {
            var breakLabel = startDate.format("HH") + ':' + startDate.format('mm');
            breakLabel += ' - ' + endDate.format('HH') + ':' + endDate.format('mm');
            return breakLabel;
        },

        drawCircle: function(breaksData) {
            //1440 - всего
            var canvas = document.querySelector('.canvas-element');
            if (!canvas) {
                canvas = document.createElement('canvas');
                canvas.width = 400;
                canvas.height = 400;
                canvas.className = "canvas-element";
                this.canvasContainer.appendChild(canvas);
            }


            var data = [];






            var breakTime = 0;
            var startTime = 0;

            for (var i = 0; i < breaksData.length; i++) {
                var b = breaksData[i]; // объект перерыва
                var startDate = moment(b.start_date);
                var endDate = moment(b.end_date);
                breakTime = Math.floor((endDate - startDate) / (60 * 1000));
                var breakLabel = this.makeLabel(startDate, endDate);

                
                data.push({
                    value: breakTime,
                    color: "#F7464A",
                    highlight: "#FF5A5E",
                    label: "Перерыв: " + breakLabel
                });


                if (!(startDate.minutes() == 0 && startDate.hours() == 0)) {
                    startTime = (60 * startDate.hours()) + startDate.minutes();
                    data.unshift({
                        value: startTime,
                        color: "#46BFBD",
                        highlight: "#5AD3D1",
                        label: "Рабочее время"
                    });
                }




            }



            data.push({
                value: (1440 - breakTime) - startTime,
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Рабочее время"
            });





            var chart = new Chart(canvas.getContext('2d')).Pie(data, {
                tooltipTemplate: "<%= label %>"
            });

        },




        drawCircleAll: function(breaksData) {

        }




    };
    schedule.init();






})();