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
                    self.draw(data, self.selectedOptionValue);
                }
            }, false);

            request.send();
        },

        /* Для создания текста тултипа */
        makeLabel: function(startDate, endDate) {
            var breakLabel = startDate.format("HH") + ':' + startDate.format('mm');
            breakLabel += ' - ' + endDate.format('HH') + ':' + endDate.format('mm');
            return breakLabel;
        },

        makeData: function(breaks) {
            var data = [];
            var remainingTime = 1440;
            var countPoint = 0;
            var segmentLength = 0;

            for (var i = 0; i < breaks.length; i++) {
                var startDate = moment(breaks[i].start_date);
                var endDate = moment(breaks[i].end_date);
                var breakTime = Math.floor((endDate - startDate) / (60 * 1000));
                var breakLabel = this.makeLabel(startDate, endDate);
                countPoint = Math.abs(segmentLength - ((60 * startDate.hours()) + startDate.minutes()));
                segmentLength += countPoint + breakTime;

                if (countPoint != 0) {
                    data.push({
                        value: countPoint,
                        color: "#46BFBD",
                        highlight: "#5AD3D1",
                        label: "Рабочее время"
                    });
                }
                data.push({
                    value: breakTime,
                    color: "#F7464A",
                    highlight: "#FF5A5E",
                    label: "Перерыв: " + breakLabel
                });
                remainingTime -= (countPoint + breakTime);

            }

            data.push({
                value: remainingTime,
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Рабочее время"
            });

            return data;
        },

        draw: function(breaksData, type) {

            if (type != 'all') {

                var canvas = document.querySelector('.canvas-element');
                if (!canvas) {
                    canvas = document.createElement('canvas');
                    canvas.width = 400;
                    canvas.height = 400;
                    canvas.className = "canvas-element";
                    this.canvasContainer.appendChild(canvas);
                }

                var data = this.makeData(breaksData);

                this.singleChart = new Chart(canvas.getContext('2d')).Pie(data, {
                    tooltipTemplate: "<%= label %>"
                });

            } else {
                // нарисовать список графиков







            }



        },
        makeBreaksList: function() {

        }



    };
    schedule.init();






})();