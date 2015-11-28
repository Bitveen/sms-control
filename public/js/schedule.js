(function(BreaksChart) {
    "use strict";
    $('#dayToShow').datepicker();


    var chartView = document.getElementById('chart-view').innerHTML,
        multipleChartView = document.getElementById('multiple-chart-view').innerHTML;

    // шаблоны для парсинга и вставки в документ
    var chartViewTemplate = Handlebars.compile(chartView),
        multipleChartViewTemplate = Handlebars.compile(multipleChartView);


    Handlebars.registerHelper('formatTime', function(date) {
        if (!date) {
            return '-';
        }
        return moment(date).format('HH:mm');
    });


    // Форма
    var scheduleForm = document.getElementById('scheduleForm');

    // Поле с выбором даты
    var dayToShow = document.getElementById('dayToShow');

    // Поле с выбором подписчика
    var subscribersSelect = document.getElementById('subscribers');

    // Область для вставки графиков
    var container = document.querySelector('.schedule__body');

    // Созданный график
    var chart = null;

    // Если графиков несколько
    var charts = [];



    // Обработка отправки формы
    scheduleForm.addEventListener('submit', handleFormSubmit, false);




    function handleFormSubmit(event) {
        event.preventDefault();
        var date = dayToShow.value.trim();

        if (!(/^\d{2}\.\d{2}\.\d{4}$/.test(date))) {
            return;
        }


        var url = '/api/breaks?dayToShow=' + date;
        var selectedOptionValue = getOptionValue(subscribersSelect.options);
        if (selectedOptionValue && selectedOptionValue != 'all') {
            url += '&subscriber=' + selectedOptionValue;

            chart = new BreaksChart();
            chart.uploadData(url, function(data) {
                chart.setData(data);
                container.innerHTML = chartViewTemplate({
                    data: chart.getRawData()
                });

                var canvas = document.getElementById('chart-element');
                if (canvas) {
                    chart.run(canvas);
                }

                var breaksInputs = document.querySelector('.breaks-inputs');
                breaksInputs.addEventListener('click', handleSaveButton, false);



            });


        } else {
            chart = null;
            uploadSubscribers('/api/breaks?dayToShow=' + date, function(data) {
                var subscribers = [];
                var hasCurrentElement;
                for (var i = 0; i < data.length; i++) {
                    hasCurrentElement = false;
                    for (var j = 0; j < subscribers.length; j++) {
                        if (data[i].id == subscribers[j].id) {
                            hasCurrentElement = true;
                            break;
                        }
                    }
                    if (!hasCurrentElement) {
                        subscribers.push({
                            id: data[i].id,
                            first_name: data[i].first_name,
                            last_name: data[i].last_name,
                            middle_name: data[i].middle_name
                        });
                        hasCurrentElement = false;
                    }
                }
                container.innerHTML = multipleChartViewTemplate({
                    subscribers: subscribers
                });


                var chartElements = document.querySelectorAll('.subscriber-chart');
                var dataForChart = [];
                for (i = 0; i < chartElements.length; i++) {
                    var chartId = chartElements[i].dataset.id;
                    for (j = 0; j < data.length; j++) {
                        if (data[j].id == chartId) {
                            dataForChart.push(data[j]);
                        }
                    }
                    // сформировал и можно создавать объекты
                    charts[i] = new BreaksChart();
                    charts[i].setData(dataForChart);
                    charts[i].run(chartElements[i].querySelector('canvas'));
                    dataForChart = [];
                }









            });




        }




    }



    function uploadSubscribers(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.addEventListener('load', function(event) {
            if (event.target.status === 200) {
                callback(JSON.parse(event.target.responseText));
            }
        }, false);
        xhr.send();
    }




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


    // Для проверки полей времени на соответствие 00:00 формату
    function validateTimeInput(time) {
        if (typeof time !== 'string') {
            return false;
        }
        time = time.trim();
        return /^\d{2}:\d{2}$/i.test(time);
    }


    // Изменение значения времени
    function handleSaveButton(event) {
        event.preventDefault();
        var target = event.target;
        if (target.className == 'break__save') {
            var inputs = target.parentNode.querySelectorAll('.break__input');
            var id = target.parentNode.dataset.id;
            var data = new FormData();

            // валидация полей времени
            if (!validateTimeInput(inputs[0].value)) {
                return;
            } else {
                data.append('startDate', dayToShow.value + ' ' + inputs[0].value);
            }


            if (!validateTimeInput(inputs[1].value)) {
                if (inputs[1].value.trim() !== '-') {
                    return;
                } else {
                    data.append('endDate', inputs[1].value);
                }
            } else {
                data.append('endDate', dayToShow.value + ' ' + inputs[1].value);
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/breaks/' + id, true);
            xhr.addEventListener('load', function(event) {
                var response = event.target;
                if (response.status == 200) {
                    var responseData = JSON.parse(response.responseText);
                    for (var i = 0; i < chart.rawData.length; i++) {
                        if (id == chart.rawData[i].id) {
                            chart.rawData[i].start_date = responseData.start_date.date;
                            chart.rawData[i].end_date = responseData.end_date.date;
                            break;
                        }
                    }
                    chart.getChartInstance().destroy();
                    chart.setData(chart.getRawData());
                    var canvas = document.getElementById('chart-element');
                    if (canvas) {
                        chart.run(canvas);
                    }
                }
            }, false);

            xhr.addEventListener('error', function(event) {}, false);
            xhr.send(data);
        }
    }

})(BreaksChart);