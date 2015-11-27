function BreaksChart() {
    this.chart = null; // объект графика
    this.data = []; // данные для построения графика
    this.rawData = []; // данные с сервера
}


BreaksChart.prototype.setData = function(data) {
    this.data = [];
    var remainingTime = 1440;
    var countPoint = 0;
    var segmentLength = 0;
    for (var i = 0; i < data.length; i++) {

        if (!data[i].end_date) {
            continue;
        }


        var startDate = moment(data[i].start_date);
        var endDate = moment(data[i].end_date);
        var breakTime = Math.floor((endDate - startDate) / (60 * 1000));
        var breakLabel = this.makeLabel(startDate, endDate);
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


BreaksChart.prototype.run = function(canvas) {
    this.chart = new Chart(canvas.getContext('2d')).Pie(this.data, {
        tooltipTemplate: "<%= label %>"
    })
};


BreaksChart.prototype.makeLabel = function(startDate, endDate) {
    var breakLabel = startDate.format("HH") + ':' + startDate.format('mm');
    breakLabel += ' - ' + endDate.format('HH') + ':' + endDate.format('mm');
    return breakLabel;
};

BreaksChart.prototype.hasRawData = function() {
    return this.rawData.length != 0;
};

BreaksChart.prototype.hasData = function() {
    return this.data.length != 0;
};

BreaksChart.prototype.getRawData = function() {
    return this.rawData;
};

BreaksChart.prototype.getChartInstance = function() {
    return this.chart;
};