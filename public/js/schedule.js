(function() {
    "use strict";
    $('#dayToShow').datepicker();



    /*
    * className - имя класса для каждого канваса(для массового построения)
    * */
    function BreaksChart() {
        this.chart = null; // объект графика
        this.data = []; // данные для построения графика
        this.rawData = [];
    }

    // Обработать загруженные данные
    BreaksChart.prototype.setData = function(data) {
        this.data = [];
        var remainingTime = 1440;
        var countPoint = 0;
        var segmentLength = 0;

        for (var i = 0; i < data.length; i++) {

            /*if (!data.end_date) {
                continue;
            }*/

            var startDate = moment(data[i].start_date);
            var endDate = moment(data[i].end_date);
            var breakTime = Math.floor((endDate - startDate) / (60 * 1000));
            var breakLabel = makeLabel(startDate, endDate);
            countPoint = Math.abs(segmentLength - ((60 * startDate.hours()) + startDate.minutes()));
            segmentLength += countPoint + breakTime;

            if (countPoint != 0) {
                this.data.push({
                    value: countPoint,
                    color: "#46BFBD",
                    highlight: "#5AD3D1",
                    label: "Рабочее время"
                });
            }
            this.data.push({
                value: breakTime,
                color: "#F7464A",
                highlight: "#FF5A5E",
                label: "Перерыв: " + breakLabel,
                id: data[i].id
            });
            remainingTime -= (countPoint + breakTime);

        }

        this.data.push({
            value: remainingTime,
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Рабочее время"
        });

    };

    // Подгрузить данные по графику удаленно
    BreaksChart.prototype.uploadData = function(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        var self = this;
        xhr.addEventListener('load', function(event) {
            var response = event.target;
            if (response.status == 200) {
                self.rawData = JSON.parse(response.responseText);
                callback(JSON.parse(response.responseText));
            }
        }, false);
        xhr.addEventListener('error', function(event) {}, false);
        xhr.send();
    };

    // Построить график
    BreaksChart.prototype.run = function(canvas) {
        this.chart = new Chart(canvas.getContext('2d')).Pie(this.data, {
            tooltipTemplate: "<%= label %>"
        })
    };


    function insertBreaksInputs(data) {
        var fragment = document.createDocumentFragment();
        for (var i = 0; i < data.length; i++) {
            var startTimeInput = document.createElement('input');
            var endTimeInput = document.createElement('input');
            startTimeInput.type = "text";
            endTimeInput.type = "text";
            startTimeInput.className = "form__input form__input_inline";
            endTimeInput.className = "form__input form__input_inline";
            startTimeInput.value = moment(data[i].start_date).format("HH:mm");
            endTimeInput.value = moment(data[i].end_date).format("HH:mm");

            var saveButton = document.createElement('a');
            saveButton.href = "#";
            saveButton.className = "breaks__link";
            saveButton.appendChild(document.createTextNode('Сохранить'));
            var row = document.createElement('div');
            row.className = "info__row";
            row.dataset.id = data[i].id;
            row.appendChild(startTimeInput);
            row.appendChild(endTimeInput);
            row.appendChild(saveButton);
            fragment.appendChild(row);
        }
        var div = document.createElement('div');
        div.className = "schedule__info";
        div.appendChild(fragment);
        canvasContainer.appendChild(div);


        // Сохранить и перерисовать график
        div.addEventListener('click', handleSaveButton, false);
    }



    var chart = null;
    var charts = [];



    // Форма
    var scheduleForm = document.getElementById('scheduleForm');

    // Поле с выбором даты
    var dayToShow = document.getElementById('dayToShow');

    // Поле с выбором подписчика
    var subscribersSelect = document.getElementById('subscribers');

    // Область для вставки графиков
    var canvasContainer = document.querySelector('.schedule__body');


    // Обработка отправки формы
    scheduleForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if (!dayToShow.value) {
            return;
        }
        var url = '/api/breaks?dayToShow=' + dayToShow.value;
        var selectedOptionValue = getOptionValue(subscribersSelect.options);
        if (selectedOptionValue && selectedOptionValue != 'all') {
            url += '&subscriber=' + selectedOptionValue;
        }

        if (selectedOptionValue != 'all') {

            var canvas = document.createElement('canvas');
            canvas.width = 400;
            canvas.height = 400;
            canvas.className = "canvas-element";
            canvasContainer.appendChild(canvas);

            chart = new BreaksChart();
            chart.uploadData(url, function(data) {
                chart.setData(data);
                chart.run(canvas);
                insertBreaksInputs(chart.rawData);
            });



        } else {
            // массив графиков

















        }






    }, false);




    // Получить значение выбранного опшна
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


    // Сделать текст тултипа в графике
    function makeLabel(startDate, endDate) {
        var breakLabel = startDate.format("HH") + ':' + startDate.format('mm');
        breakLabel += ' - ' + endDate.format('HH') + ':' + endDate.format('mm');
        return breakLabel;
    }



    function handleSaveButton(event) {
        event.preventDefault();
        var target = event.target;
        var inputs;
        var id;
        var self = this;
        if (target.className == 'breaks__link') {
            inputs = target.parentNode.querySelectorAll('.form__input');
            id = target.parentNode.dataset.id;
            if (!inputs[0].value || !inputs[1].value) {
                return;
            }
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/breaks/' + id, true);
            xhr.addEventListener('load', function(event) {
                var response = event.target;
                if (response.status == 200) {
                    console.log(JSON.parse(response.responseText));
                    canvasContainer.innerHTML = "";
                    var canvas = document.createElement('canvas');
                    canvas.width = 400;
                    canvas.height = 400;
                    canvas.className = "canvas-element";
                    canvasContainer.appendChild(canvas);



                    for (var i = 0; i < chart.rawData.length; i++) {
                        if (id == chart.rawData[i].id) {
                            chart.rawData[i].start_date = JSON.parse(response.responseText).start_date.date;
                            chart.rawData[i].end_date = JSON.parse(response.responseText).end_date.date;
                            break;
                        }
                    }

                    chart.setData(chart.rawData);
                    chart.run(canvas);
                    insertBreaksInputs(chart.rawData);
                }
            }, false);

            xhr.addEventListener('error', function(event) {}, false);

            var data = new FormData();
            data.append('startDate', dayToShow.value + ' ' + inputs[0].value);
            data.append('endDate', dayToShow.value + ' ' + inputs[1].value);
            xhr.send(data);
        }
    }

})();