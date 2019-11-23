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
                            <h4 class="page-title">Подробнее за {{Date::parse($date)->format('d.m.Y, (l)')}}</h4>
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
                                Серийный номер
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="mini-stat clearfix bg-white">
                            <span class="mini-stat-icon bg-warning"><i class="mdi mdi-calculator text-white"></i></span>
                            <div class="mini-stat-info text-right text-muted">
                                <span class="counter text-warning">{{end($dataView)['eap']}}</span>
                                Показание счетчика
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="mini-stat clearfix bg-info">
                            <span class="mini-stat-icon bg-light"><i class="mdi mdi-calendar-clock text-info"></i></span>
                            <div class="mini-stat-info text-right text-light">
                                <span class="counter text-white">{{Date::parse(end($dataView)['dtimeOS'])->format('d.m.Y, H:i')}}</span>
                                Дата и время
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
                    <div class="col-xl-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 m-b-15 header-title">Данные на {{Date::parse($date)->format('d.m.Y, (l)')}}</h4>

                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th>Дата и время</th>
                                            <th class="txt_center">Показание (активная энергия +)</th>
                                            <th class="txt_center">Показание (реактивная энергия + )</th>
                                            <th class="txt_center">Действия</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($dataView as $key=>$d)
                                        <tr>
                                            <td><strong>{{ Carbon\Carbon::parse($d['dtimeOS'])->format('d.m.Y') }}</strong><br>{{ Carbon\Carbon::parse($d['dtimeOS'])->format('H:i') }}</td>
                                            <td class="txt_center">{{ number_format($d['eap'],2) }}</td>
                                            <td class="txt_center">{{ number_format($d['erp'],2) }}</td>
                                            <td><a class="btn btn-info btn-block waves-effect waves-light" href="/details/{{$key}}">Подробнее</a></td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
</div>
</div>

<script>
window.onload = function () {
    var iChart = new CanvasJS.Chart("iChart", {
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	animationEnabled: true,
	title:{
		text: "Ток фаза (диаграмма)"   
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
            @foreach($dataView as $item)
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
            @foreach($dataView as $item)
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
        color: "{{env('APP_COLOR_B')}}",
		yValueFormatString: "###.#",
        showInLegend: true,
		dataPoints: [        
            @foreach($dataView as $item)
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
		text: "Линейное напряжение (диаграмма)"   
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
            @foreach($dataView as $item)
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
            @foreach($dataView as $item)
                @if($item['U_lin_BC'])
                <?php 
                        if($item['U_lin_BC'] > env('APP_uMAX') || $item['U_lin_BC'] < env('APP_uMIN')){
                            $marker_type = "cross";
                            $marker_color = "#ff0000";
                        }
                        else {
                            $marker_type = "circle";
                            $marker_color = env('APP_COLOR_B');
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
            @foreach($dataView as $item)
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
			        { x: new Date({{date('Y, m, d, H, i',strtotime($item['dtimeOS']))}}), y: {{$item['U_lin_CA']}},markerType: "{{$marker_type}}",  markerColor: "{{ $marker_color }}" },
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
