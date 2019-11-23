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
                            <h4 class="page-title">Подробнее за {{ Date::parse($data->stime)->format('d.m.Y, H:i (l)') }}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <tr>
                                            <td>Дата и время</td>
                                            <td class="txt_center">{{Date::parse($data->stime)->format('d.m.Y, H:i (l)')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Активная мощность (Вт)</td>
                                            <td class="txt_center">{{number_format($data_calcf['active_power'], 2,".",' ')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Активная мощность Фаза A</td>
                                            <td class="txt_center">{{number_format($data_calcf['active_power_A'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Активная мощность Фаза B</td>
                                            <td class="txt_center">{{number_format($data_calcf['active_power_B'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Активная мощность Фаза C</td>
                                            <td class="txt_center">{{number_format($data_calcf['active_power_B'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Реактивная мощность (вар)</td>
                                            <td class="txt_center">{{number_format($data_calcf['reactive_power'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Реактивная мощность Фаза A</td>
                                            <td class="txt_center">{{number_format($data_calcf['reactive_power_A'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Реактивная мощность Фаза B</td>
                                            <td class="txt_center">{{number_format($data_calcf['reactive_power_B'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Реактивная мощность Фаза C</td>
                                            <td class="txt_center">{{number_format($data_calcf['reactive_power_C'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Полная мощность (В*А)</td>
                                            <td class="txt_center">{{number_format($data_calcf['full_power'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Полная мощность Фаза A</td>
                                            <td class="txt_center">{{number_format($data_calcf['full_power_A'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Полная мощность Фаза B</td>
                                            <td class="txt_center">{{number_format($data_calcf['full_power_B'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Полная мощность Фаза C</td>
                                            <td class="txt_center">{{number_format($data_calcf['full_power_C'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Фазное напряжение A (первичное)</td>
                                            <td class="txt_center">{{number_format($data_calcf['FU_first_A'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Фазное напряжение B (первичное)</td>
                                            <td class="txt_center">{{number_format($data_calcf['FU_first_B'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Фазное напряжение C (первичное)</td>
                                            <td class="txt_center">{{number_format($data_calcf['FU_first_C'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Линейное напряжение AB</td>
                                            <td class="txt_center">{{number_format($data_calcf['U_lin_AB'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Линейное напряжение BC</td>
                                            <td class="txt_center">{{number_format($data_calcf['U_lin_BC'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Линейное напряжение CA</td>
                                            <td class="txt_center">{{number_format($data_calcf['U_lin_CA'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ток фаза A</td>
                                            <td class="txt_center">{{number_format($data_calcf['If_first_A'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ток фаза B</td>
                                            <td class="txt_center">{{number_format($data_calcf['If_first_B'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ток фаза C</td>
                                            <td class="txt_center">{{number_format($data_calcf['If_first_C'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Коэфициент мощности фазы A</td>
                                            <td class="txt_center">{{number_format($data_calcf['koef_power_A'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Коэфициент мощности фазы B</td>
                                            <td class="txt_center">{{number_format($data_calcf['koef_power_B'],2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Коэфициент мощности фазы C</td>
                                            <td class="txt_center">{{$data_calcf['koef_power_C']}}</td>
                                        </tr>

                                        <tr>
                                            <td>Частота сети (Гц)</td>
                                            <td class="txt_center">{{$data->dhz}}</td>
                                        </tr>
                                        <tr>
                                            <td>Активная энергия +</td>
                                            <td class="txt_center">{{number_format($data->eap,2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Активная энергия -</td>
                                            <td class="txt_center">{{$data->eam}}</td>
                                        </tr>
                                        <tr>
                                            <td>Реактивная энергия +</td>
                                            <td class="txt_center">{{number_format($data->erp,2,"."," ")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Реактивная энергия -</td>
                                            <td class="txt_center">{{$data->erm}}</td>
                                        </tr>
                                        <tr>
                                            <td>Серийный номер</td>
                                            <td class="txt_center">{{$data->dsnum}}</td>
                                        </tr>
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
