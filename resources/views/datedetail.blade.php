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
                                <span class="counter text-danger">Фидер 6. Шоро</span>
                                Расположение
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="mini-stat clearfix bg-blue">
                            <span class="mini-stat-icon bg-light"><i class="mdi mdi-numeric text-blue"></i></span>
                            <div class="mini-stat-info text-right text-white">
                                <span class="counter text-white">{{$data['0']->dsnum}}</span>
                                Серийный номер
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="mini-stat clearfix bg-white">
                            <span class="mini-stat-icon bg-warning"><i class="mdi mdi-calculator text-white"></i></span>
                            <div class="mini-stat-info text-right text-muted">
                                <span class="counter text-warning">{{$data['0']->eap}}</span>
                                Показание счетчика
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="mini-stat clearfix bg-info">
                            <span class="mini-stat-icon bg-light"><i class="mdi mdi-calendar-clock text-info"></i></span>
                            <div class="mini-stat-info text-right text-light">
                                <span class="counter text-white">{{Date::parse($data['0']->stime)->format('d.m.Y, H:i')}}</span>
                                Дата и время
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
                                        @foreach ($data as $d)
                                        <tr>
                                            <td><strong>{{ Carbon\Carbon::parse($d->stime)->format('d.m.Y') }}</strong><br>{{ Carbon\Carbon::parse($d->stime)->format('H:i') }}</td>
                                            <td class="txt_center">{{ number_format($d->eap,2) }}</td>
                                            <td class="txt_center">{{ number_format($d->erp,2) }}</td>
                                            <td><a class="btn btn-info btn-block waves-effect waves-light" href="/details/{{$d->id}}">Подробнее</a></td>
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
@endsection
