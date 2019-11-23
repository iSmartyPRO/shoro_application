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
                    <div class="col-xl-12">
                        <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="page-title-box">
                                        <h4 class="page-title">Выберите диапозон дат</h4>
                                    </div>
                                    <form action="/report/" method="get">
                                        @csrf
                                        <input type="text" class="form-control" data-toggle="date1" placeholder="Начальная дата" name="date1">
                                        <input type="text" class="form-control" data-toggle="date2" placeholder="Конечная дата" name="date2">
                                        <button type="submit" class="btn btn-info btn-block waves-effect waves-light" >Сгенерировать</button>
                                    </form>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <?php if(@$data['db']){ ?>
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
                                            @foreach ($data['db'] as $row)
                                            <tr>
                                                <td>{{$row->stime}}</td>
                                                <td class="txt_center">{{$row['eap']}}</td>
                                                <td class="txt_center">{{$row['erp']}}</td>
                                                <td><a class="btn btn-info btn-block waves-effect waves-light" href="/date/{{Carbon\Carbon::parse($row['stime'])->toDateString()}}">Подробнее</a></td>
                                            </tr>
                                            @endforeach
                                                                                                                            <t
                                            
                                            </tbody>
                                        </table>
                                </div>



                                    <?php } else { ?>
                                    <div style="height:50px"></div>
                                    <?php if(@$data['status']=='bad'){ ?>
                                        <div class="alert-danger">
                                            <div class="card-body">
                                                {{$data['msg']}}</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert-success">
                                            <div class="card-body">
                                                Выберите диапазон дат для генерации отчета</div>
                                            </div>
                                        </div>
                                        <?php } } ?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->
            </div>
        </div>

  <script>
    $(function() {
      $('[data-toggle="date1"]').datepicker({
        autoHide: true,
        zIndex: 2048,
        format: 'dd.mm.yyyy',
      });
      $('[data-toggle="date2"]').datepicker({
        autoHide: true,
        zIndex: 2048,
        format: 'dd.mm.yyyy',
      });
    });
  </script>
@endsection
