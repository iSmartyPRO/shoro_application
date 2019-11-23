<?php
$APP_COLOR_A = env("APP_COLOR_A");
$APP_COLOR_B = env("APP_COLOR_B");
$APP_COLOR_C = env("APP_COLOR_C");
?>
@extends('layouts.app')
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
@section('content')
        <div class="wrapper">
            <div class="container-fluid">

               <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="mini-stat clearfix bg-white">
                            <span class="mini-stat-icon bg-danger"><i class="mdi mdi-map-marker-multiple text-white"></i></span>
                            <div class="mini-stat-info text-right text-muted">
                                <span class="counter text-danger">{{env('APP_METERNAME')}}</span>
                                Расположение
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="mini-stat clearfix bg-blue">
                            <span class="mini-stat-icon bg-light"><i class="mdi mdi-numeric text-blue"></i></span>
                            <div class="mini-stat-info text-right text-white">
                                <span class="counter text-white">{{env('APP_DSNUM')}}</span>
                                Серийный номер счетчика
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="mini-stat clearfix bg-white">
                            <span class="mini-stat-icon bg-warning"><i class="mdi mdi-calculator text-white"></i></span>
                            <div class="mini-stat-info text-right text-muted">
                                <span class="counter text-warning">{{number_format(end($data_24hours)['eap'],2,',',' ')}}</span>
                                Последние показания счетчика
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="mini-stat clearfix bg-info">
                            <span class="mini-stat-icon bg-light"><i class="mdi mdi-calendar-clock text-info"></i></span>
                            <div class="mini-stat-info text-right text-light">
                                <span class="counter text-white">{{Carbon\Carbon::parse(end($data_24hours)['dtimeOS'])->format('d.m.Y, H:i')}}</span>
                                Последнее обновление
                            </div>
                        </div>
                    </div>
                </div>

<div class="row">
    <div class="col-12">
    <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">График потребления активной энергии - 10 дней (в графике)</h4>
                                <div id="graph" style="height: 510px"></div>
                            </div>
                        </div>
    </div>
</div>
<div class="row">

                    <div class="col-xl-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 m-b-15 header-title">За 10 дней</h4>

                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th>Дата и время</th>
                                            <th class="txt_center">Показание <br>(активная энергия +)</th>
                                            <th class="txt_center">Показание <br>(реактивная энергия + )</th>
                                            <th class="txt_center">Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data_10days as $day)
                                        <?php $dt = date("Y-m-d", strtotime($day['dtimeOS_dt'])); ?>
                                        <tr>
                                            <td><strong>{{ Carbon\Carbon::parse($day['dtimeOS'])->format('d.m.Y')}}</strong><br>{{ Carbon\Carbon::parse($day['dtimeOS'])->format('H:i')}}</td>
                                            <td class="text-right">{{ number_format($day['eap'],2,',',' ') }}</td>
                                            <td class="text-right">{{ number_format($day['erp'],2,',',' ') }}</td>
                                            <td><a class="btn btn-info btn-block waves-effect waves-light" href="/date/{{ $dt }}">Подробнее</a></td>
                                        </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">График потребления активной энергии - 10 дней (в цифрах)</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="bg-green text-white text-center">Дата 1<br>(показание)</th>
                                        <th scope="col" class="bg-green text-white text-center">Дата 2<br>(показание)</th>
                                        <th scope="col" class="bg-green text-white text-center">Рассчет</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <tr>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[0]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[0]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[0]['eap'],2,',',' ')}}</td>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[1]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[1]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[1]['eap'],2,',',' ')}}</td>
                                            <td class="text-center">{{number_format($data_10days[0]['eap']-$data_10days[1]['eap'],2,',',' ')}}</td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[1]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[1]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[1]['eap'],2,',',' ')}}</td>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[2]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[2]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[2]['eap'],2,',',' ')}}</td>
                                            <td class="text-center">{{number_format($data_10days[1]['eap']-$data_10days[2]['eap'],2,',',' ')}}</td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[2]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[2]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[2]['eap'],2,',',' ')}}</td>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[3]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[3]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[3]['eap'],2,',',' ')}}</td>
                                            <td class="text-center">{{number_format($data_10days[2]['eap']-$data_10days[3]['eap'],2,',',' ')}}</td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[3]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[3]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[3]['eap'],2,',',' ')}}</td>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[4]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[4]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[4]['eap'],2,',',' ')}}</td>
                                            <td class="text-center">{{number_format($data_10days[3]['eap']-$data_10days[4]['eap'],2,',',' ')}}</td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[4]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[4]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[4]['eap'],2,',',' ')}}</td>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[5]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[5]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[5]['eap'],2,',',' ')}}</td>
                                            <td class="text-center">{{number_format($data_10days[4]['eap']-$data_10days[5]['eap'],2,',',' ')}}</td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[5]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[5]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[5]['eap'],2,',',' ')}}</td>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[6]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[6]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[6]['eap'],2,',',' ')}}</td>
                                            <td class="text-center">{{number_format($data_10days[5]['eap']-$data_10days[6]['eap'],2,',',' ')}}</td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[6]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[6]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[6]['eap'],2,',',' ')}}</td>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[7]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[7]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[7]['eap'],2,',',' ')}}</td>
                                            <td class="text-center">{{number_format($data_10days[6]['eap']-$data_10days[7]['eap'],2,',',' ')}}</td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[7]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[7]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[7]['eap'],2,',',' ')}}</td>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[8]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[8]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[8]['eap'],2,',',' ')}}</td>
                                            <td class="text-center">{{number_format($data_10days[7]['eap']-$data_10days[8]['eap'],2,',',' ')}}</td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[8]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[8]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[8]['eap'],2,',',' ')}}</td>
                                            <td class="text-center"><strong>{{Carbon\Carbon::parse($data_10days[9]['dtimeOS'])->format('d.m.Y, H:i')}}<br><i>({{Date::parse($data_10days[9]['dtimeOS'])->format('l')}})</i></strong><br>{{number_format($data_10days[9]['eap'],2,',',' ')}}</td>
                                            <td class="text-center">{{number_format($data_10days[8]['eap']-$data_10days[9]['eap'],2,',',' ')}}</td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card m-b-30">
                            <div id="iChart"  style="height: 500px; width: 100%;">

                            </div>
                        </div>

                    </div>
                    <div class="col-xl-12">
                        <div class="card m-b-30">
                            <div id="uChart"  style="height: 500px; width: 100%;">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Активная мощность</h4>

                                <ul class="list-inline widget-chart m-t-20 text-center">
                                    <li>
                                        <h4 class=""><b>кВт</b></h4>
                                        <p class="text-muted m-b-0">Единица измерения</p>
                                    </li>
                                </ul>
                                <div id="morris-active-power" style="height: 265px"></div>
                            </div>
                        </div>
                    </div>                    
                    
                    <div class="col-xl-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Реактивная мощность</h4>

                                <ul class="list-inline widget-chart m-t-20 text-center">
                                    <li>
                                        <h4 class=""><b>кВар</b></h4>
                                        <p class="text-muted m-b-0">Единица измерения</p>
                                    </li>
                                </ul>

                                <div id="morris-reactive-power" style="height: 265px"></div>
                            </div>
                        </div>
                    </div>                    
                    
                    <div class="col-xl-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Полная мощность</h4>

                                <ul class="list-inline widget-chart m-t-20 text-center">
                                    <li>
                                        <h4 class=""><b>ВА</b></h4>
                                        <p class="text-muted m-b-0">Единица измерения</p>
                                    </li>
                                </ul>

                                <div id="morris-fullpower" style="height: 265px"></div>
                            </div>
                        </div>
                    </div>                    
                    
                    <div class="col-xl-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Ток фаза</h4>

                                <ul class="list-inline widget-chart m-t-20 text-center">
                                    <li>
                                        <h4 class=""><b>A</b></h4>
                                        <p class="text-muted m-b-0">Единица измерения</p>
                                    </li>
                                </ul>

                                <div id="morris-tok-phase" style="height: 265px"></div>
                            </div>
                        </div>
                    </div>                    

                    <div class="col-xl-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Напряжение</h4>

                                <ul class="list-inline widget-chart m-t-20 text-center">
                                    <li>
                                        <h4 class=""><b>кВ</b></h4>
                                        <p class="text-muted m-b-0">Единица измерения</p>
                                    </li>
                                </ul>
                                <div id="morris-U" style="height: 265px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Коэфициент мощности</h4>

                                <ul class="list-inline widget-chart m-t-20 text-center">
                                    <li>
                                        <h4 class=""><b>Косинус Фи</b></h4>
                                        <p class="text-muted m-b-0">Единица измерения</p>
                                    </li>
                                </ul>
                                <div id="morris-cosfi" style="height: 265px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Линейное напряжение</h4>

                                <ul class="list-inline widget-chart m-t-20 text-center">
                                    <li>
                                        <h4 class=""><b>кВ</b></h4>
                                        <p class="text-muted m-b-0">Единица измерения</p>
                                    </li>
                                </ul>
                                <div id="u-lin" style="height: 265px"></div>
                            </div>
                        </div>
                    </div>

                </div>

</div>
</div>


<script>
    Morris.Donut({
      element: 'morris-active-power',
      data: [
        {label: "Фаза A", value: {{end($data_24hours)["active_power_A"]}}},
        {label: "Фаза B", value: {{end($data_24hours)["active_power_B"]}}},
        {label: "Фаза C", value: {{end($data_24hours)["active_power_C"]}}}
      ],
      colors: ["#FBE3B9", "#6CCDD7", "#F39C99"]
    });
    Morris.Donut({
      element: 'morris-reactive-power',
      data: [
        {label: "Фаза A", value: {{end($data_24hours)['reactive_power_A']}}},
        {label: "Фаза B", value: {{end($data_24hours)['reactive_power_B']}}},
        {label: "Фаза C", value: {{end($data_24hours)['reactive_power_C']}}}
      ],
      colors: ["#FBE3B9", "#6CCDD7", "#F39C99"]
    });
    Morris.Donut({
      element: 'morris-fullpower',
      data: [
        {label: "Фаза A", value: {{end($data_24hours)['full_power_A']}}},
        {label: "Фаза B", value: {{end($data_24hours)['full_power_B']}}},
        {label: "Фаза C", value: {{end($data_24hours)['full_power_C']}}},
      ],
      colors: ["#FBE3B9", "#6CCDD7", "#F39C99"]
    });
    Morris.Donut({
      element: 'morris-tok-phase',
      data: [
        {label: "Фаза A", value: {{end($data_24hours)['If_first_A']}}},
        {label: "Фаза B", value: {{end($data_24hours)['If_first_B']}}},
        {label: "Фаза C", value: {{end($data_24hours)['If_first_C']}}}
      ],
      colors: ["#FBE3B9", "#6CCDD7", "#F39C99"]
    });

    Morris.Donut({
      element: 'morris-U',
      data: [
        {label: "Фаза A", value: {{end($data_24hours)['FU_first_A']}}},
        {label: "Фаза B", value: {{end($data_24hours)['FU_first_B']}}},
        {label: "Фаза C", value: {{end($data_24hours)['FU_first_C']}}}
      ],
      colors: ["#FBE3B9", "#6CCDD7", "#F39C99"]
    });
    Morris.Donut({
      element: 'morris-cosfi',
      data: [
        {label: "Фаза A", value: {{end($data_24hours)['koef_power_A']}}},
        {label: "Фаза B", value: {{end($data_24hours)['koef_power_B']}}},
        {label: "Фаза C", value: {{end($data_24hours)['koef_power_C']}}}
      ],
      colors: ["#FBE3B9", "#6CCDD7", "#F39C99"]
    });
    Morris.Donut({
      element: 'u-lin',
      data: [
        {label: "Фаза AB", value: {{end($data_24hours)['U_lin_AB']}}},
        {label: "Фаза BC", value: {{end($data_24hours)['U_lin_BC']}}},
        {label: "Фаза CA", value: {{end($data_24hours)['U_lin_CA']}}}
      ],
      colors: ["#FBE3B9", "#6CCDD7", "#F39C99"]
    });


var week_data = [
        {"period": "{{$data_10days[0]['dtimeOS']}}", "used": {{number_format($data_10days[0]['eap']-$data_10days[1]['eap'],2)}}},
        {"period": "{{$data_10days[1]['dtimeOS']}}", "used": {{number_format($data_10days[1]['eap']-$data_10days[2]['eap'],2)}}},
        {"period": "{{$data_10days[2]['dtimeOS']}}", "used": {{number_format($data_10days[2]['eap']-$data_10days[3]['eap'],2)}}},
        {"period": "{{$data_10days[3]['dtimeOS']}}", "used": {{number_format($data_10days[3]['eap']-$data_10days[4]['eap'],2)}}},
        {"period": "{{$data_10days[4]['dtimeOS']}}", "used": {{number_format($data_10days[4]['eap']-$data_10days[5]['eap'],2)}}},
        {"period": "{{$data_10days[5]['dtimeOS']}}", "used": {{number_format($data_10days[5]['eap']-$data_10days[6]['eap'],2)}}},
        {"period": "{{$data_10days[6]['dtimeOS']}}", "used": {{number_format($data_10days[6]['eap']-$data_10days[7]['eap'],2)}}},
        {"period": "{{$data_10days[7]['dtimeOS']}}", "used": {{number_format($data_10days[7]['eap']-$data_10days[8]['eap'],2)}}},
        {"period": "{{$data_10days[8]['dtimeOS']}}", "used": {{number_format($data_10days[8]['eap']-$data_10days[9]['eap'],2)}}},
];
Morris.Line({
  element: 'graph',
  data: week_data,
  xkey: 'period',
  ykeys: ['used'],
  labels: ['Потребление']
});

window.onload = function () {
    var iChart = new CanvasJS.Chart("iChart", {
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	animationEnabled: true,
	title:{
		text: "Ток фаза (последние 24 часа)"   
	},
	axisX: {
		interval: 1,
		intervalType: "hour",
		valueFormatString: "HH:mm",
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	axisY:{
		title: "Ток фаза (A)",
		valueFormatString: "#0",
		crosshair: {
			enabled: true
		},
        stripLines: [
        {
            value: {{env('APP_iMAX')}},
            label: "Max",
            labelFontColor: "#FF0800",
            color: "#FF0800",
            showOnTop: true,
            thickness:3,
        },
        ],
        minimum: 0,
        maximum: {{env('APP_iMAX')+50}},
	},
	toolTip:{
		shared: true
	},

	data: [
    {   
        name: "Фаза A",
		type: "line",
		markerSize: 14,
        xValueFormatString: "HH:mm",
        color: "{{env('APP_COLOR_A')}}",
		yValueFormatString: "###.#",
        showInLegend: true,
		dataPoints: [        
            @foreach($data_24hours as $item)
                @if($item['I_A'])
                    <?php 
                        if($item['I_A'] > env("APP_iMAX")){
                            $marker_type = "cross";
                            $marker_color = "#ff0000";
                        }
                        else {
                            $marker_type = "circle";
                            $marker_color = env('APP_COLOR_A');
                        }
                    ?>
			        { x: new Date({{date('Y, m, d, H, i',strtotime($item['dtimeOS']))}}), y: {{$item['I_A']}},markerType: "{{$marker_type}}",  markerColor: "{{ $marker_color }}" },
                @endif

            @endforeach

		]
	},
    {   
        name: "Фаза B",
		type: "line",
		markerSize: 14,
        xValueFormatString: "HH:mm",
        color: "{{env('APP_COLOR_B')}}",
		yValueFormatString: "###.#",
        showInLegend: true,
		dataPoints: [        
            @foreach($data_24hours as $item)
                @if($item['I_B'])
                <?php 
                        if($item['I_B'] > env('APP_iMAX')){
                            $marker_type = "cross";
                            $marker_color = "#ff0000";
                        }
                        else {
                            $marker_type = "circle";
                            $marker_color = env('APP_COLOR_B');
                        }
                    ?>
			        { x: new Date({{date('Y, m, d, H, i',strtotime($item['dtimeOS']))}}), y: {{$item['I_B']}},markerType: "{{$marker_type}}",  markerColor: "{{ $marker_color }}" },
                @endif
            @endforeach

		]
	},
    {   
        name: "Фаза C",
		type: "line",
		markerSize: 14,
        xValueFormatString: "HH:mm",
        color: "{{env('APP_COLOR_C')}}",
		yValueFormatString: "###.#",
        showInLegend: true,
		dataPoints: [        
            @foreach($data_24hours as $item)
                @if($item['I_C'])
                <?php 
                        if($item['I_C'] > env('APP_iMAX')){
                            $marker_type = "cross";
                            $marker_color = "#ff0000";
                        }
                        else {
                            $marker_type = "circle";
                            $marker_color = env('APP_COLOR_C');
                        }
                    ?>
			        { x: new Date({{date('Y, m, d, H, i',strtotime($item['dtimeOS']))}}), y: {{$item['I_C']}},markerType: "{{$marker_type}}",  markerColor: "{{$marker_color}}" },
                @endif

            @endforeach

		]
	}

]
});
iChart.render();
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	ichart.render();
}


var uChart = new CanvasJS.Chart("uChart", {
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	animationEnabled: true,
	title:{
		text: "Линейное напряжение (последние 24 часа)"   
	},
	axisX: {
		interval: 1,
		intervalType: "hour",
		valueFormatString: "HH:mm",
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	axisY:{
		title: "Напряжение (кВ)",
		valueFormatString: "#0",
		crosshair: {
			enabled: true
		},
        stripLines: [
        {
            value: {{env('APP_uMAX')}},
            label: "Max",
            labelFontColor: "#FF0800",
            color: "#FF0800",
            showOnTop: true,
            thickness:3,
        },
        {
            value: {{env('APP_uMIN')}},
            label: "Min",
            labelFontColor: "#080FF0",
            color: "#0800FF",
            showOnTop: true,
            thickness:3,
        },
        ],
        includeZero: false,
        minimum: {{env('APP_uMIN')-100}},
        maximum: {{env('APP_uMAX')+100}},
	},
	toolTip:{
		shared: true
	},

	data: [
    {   
        name: "Фаза A",
		type: "line",
		markerSize: 14,
        xValueFormatString: "HH:mm",
        color: "{{env('APP_COLOR_A')}}",
		yValueFormatString: "###.#",
        showInLegend: true,
		dataPoints: [        
            @foreach($data_24hours as $item)
                @if($item['U_lin_AB'])
                    <?php 
                        if($item['U_lin_AB'] > env('APP_uMAX') || $item['U_lin_AB'] < env('APP_uMIN')){
                            $marker_type = "cross";
                            $marker_color = "#ff0000";
                        }
                        else {
                            $marker_type = "circle";
                            $marker_color = env('APP_COLOR_A');
                        }
                    ?>
			        { x: new Date({{date('Y, m, d, H, i',strtotime($item['dtimeOS']))}}), y: {{$item['U_lin_AB']}},markerType: "{{$marker_type}}",  markerColor: "{{ $marker_color }}" },
                @endif

            @endforeach

		]
	},
    {   
        name: "Фаза B",
		type: "line",
		markerSize: 14,
        xValueFormatString: "HH:mm",
        color: "{{env('APP_COLOR_B')}}",
		yValueFormatString: "###.#",
        showInLegend: true,
		dataPoints: [        
            @foreach($data_24hours as $item)
                @if($item['U_lin_BC'])
                <?php 
                        if($item['U_lin_BC'] > env('APP_uMAX') || $item['U_lin_BC'] < env('APP_uMIN')){
                            $marker_type = "cross";
                            $marker_color = "#ff0000";
                        }
                        else {
                            $marker_type = "circle";
                            $marker_color = $APP_COLOR_B;
                        }
                    ?>
			        { x: new Date({{date('Y, m, d, H, i',strtotime($item['dtimeOS']))}}), y: {{$item['U_lin_BC']}},markerType: "{{$marker_type}}",  markerColor: "{{ $marker_color }}" },
                @endif
            @endforeach

		]
	},
    {   
        name: "Фаза C",
		type: "line",
		markerSize: 14,
        xValueFormatString: "HH:mm",
        color: "{{env('APP_COLOR_C')}}",
		yValueFormatString: "###.#",
        showInLegend: true,
		dataPoints: [        
            @foreach($data_24hours as $item)
                @if($item['U_lin_CA'] )
                <?php 
                        if($item['U_lin_CA'] > env('APP_uMAX') || $item['U_lin_CA'] < env('APP_uMIN')){
                            $marker_type = "cross";
                            $marker_color = "#ff0000";
                        }
                        else {
                            $marker_type = "circle";
                            $marker_color = env('APP_COLOR_C');
                        }
                    ?>
			        { x: new Date({{date('Y, m, d, H, i',strtotime($item['dtimeOS']))}}), y: {{$item['U_lin_CA']}},markerType: "{{$marker_type}}",  markerColor: "{{$marker_color}}" },
                @endif

            @endforeach

		]
	}

]
});
uChart.render();
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	uChart.render();
}



}


</script>


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endsection
