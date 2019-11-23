/*
 Template Name: Upcube - Bootstrap 4 Admin Dashboard
 Author: Themesdesign
 Website: www.themesdesign.in
 File: Dashboard js
 */

!function ($) {
    "use strict";

    var Dashboard = function () {
    };


    //creates area chart
    Dashboard.prototype.createAreaChart = function (element, pointSize, lineWidth, data, xkey, ykeys, labels, lineColors) {
        Morris.Area({
            element: element,
            pointSize: 0,
            lineWidth: 0,
            data: data,
            xkey: xkey,
            ykeys: ykeys,
            labels: labels,
            resize: true,
            gridLineColor: '#eee',
            hideHover: 'auto',
            lineColors: lineColors,
            fillOpacity: .6,
            behaveLikeLine: true
        });
    },
        //creates Bar chart
        Dashboard.prototype.createBarChart = function (element, data, xkey, ykeys, labels, lineColors) {
            Morris.Bar({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                gridLineColor: '#eee',
                barSizeRatio: 0.4,
                resize: true,
                hideHover: 'auto',
                barColors: lineColors
            });
        },

        //creates Donut chart
        Dashboard.prototype.createDonutChart = function (element, data, colors) {
            Morris.Donut({
                element: element,
                data: data,
                resize: true,
                colors: colors,
            });
        },

        Dashboard.prototype.init = function () {
            //creating donut chart
            var $donutData = [
                {label: "Фаза 1", value: 108.073},
                {label: "Фаза 2", value: 109.65},
                {label: "Фаза 3", value: 107.2},
            ];
            this.createDonutChart('morris-full-power', $donutData, ['#6CCDD7', "#F39C99", '#FBE3B9']);
            var $donutData = [
                {label: "Фаза 1", value: 108.073},
                {label: "Фаза 2", value: 109.65},
                {label: "Фаза 3", value: 107.2},
            ];
            this.createDonutChart('morris-active-power', $donutData, ['#6CCDD7', "#F39C99", '#FBE3B9']);
            var $donutData = [
                {label: "Фаза 1", value: 108.073},
                {label: "Фаза 2", value: 109.65},
                {label: "Фаза 3", value: 107.2},
            ];
            this.createDonutChart('morris-reactive-power', $donutData, ['#6CCDD7', "#F39C99", '#FBE3B9']);
            var $donutData = [
                {label: "Фаза 1", value: 108.073},
                {label: "Фаза 2", value: 109.65},
                {label: "Фаза 3", value: 107.2},
            ];
            this.createDonutChart('morris-phase-voltage', $donutData, ['#6CCDD7', "#F39C99", '#FBE3B9']);
            var $donutData = [
                {label: "Фаза 1", value: 108.073},
                {label: "Фаза 2", value: 109.65},
                {label: "Фаза 3", value: 107.2},
            ];
            this.createDonutChart('morris-tok-phase', $donutData, ['#6CCDD7', "#F39C99", '#FBE3B9']);

        },
        //init
        $.Dashboard = new Dashboard, $.Dashboard.Constructor = Dashboard
}(window.jQuery),

//initializing
    function ($) {
        "use strict";
        $.Dashboard.init();
    }(window.jQuery);