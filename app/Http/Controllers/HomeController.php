<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\dbdata;
use App\dbdata_10days;
use App\dbdata_details;
//use App\dbdatasimple;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    private function calcf($Uf1,$Uf2,$Uf3,$If1,$If2,$If3,$dtimeOS,$eap=0,$erp=0){
        // КОНСТАНТЫ
        $Uf1                = $Uf1 * 0.01;
        $Uf2                = $Uf2 * 0.01;
        $Uf3                = $Uf3 * 0.01;
        $If1                = ($If1-1000) * 0.001;
        $If2                = ($If2-1000) * 0.001;
        $If3                = ($If3-1000) * 0.001;
        $cosfi              = 0.8;
        $sinfi              = 0.6;
        $sqrt3              = 1.73;

        $I_full             = (($If1 + $If2 + $If3)/3) * 60;
        $I_A                = $If1 * 60;
        $I_B                = $If2 * 60;
        $I_C                = $If3 * 60;
        $U_full             = (($Uf1 + $Uf2 + $Uf3)/3) * 60;
        $U_A                = $Uf1 * 60;
        $U_B                = $Uf2 * 60;
        $U_C                = $Uf3 * 60;
        // Активная мощность
        $active_power       = round(($I_full * $U_full * $cosfi * $sqrt3), 2);
        $active_power_A     = round(($I_A * $U_A * $cosfi), 2);
        $active_power_B     = round(($I_B * $U_B * $cosfi), 2);
        $active_power_C     = round(($I_C * $U_C * $cosfi), 2);
        // Реактивная мощность
        $reactive_power     = round(($I_full * $U_full * $sinfi * $sqrt3), 2);
        $reactive_power_A   = round(($I_A * $U_A * $sinfi), 2);
        $reactive_power_B   = round(($I_B * $U_B * $sinfi), 2);
        $reactive_power_C   = round(($I_C * $U_C * $sinfi), 2);
        // Полная мощность
        $full_power         = round((sqrt(($active_power * $active_power) + ($reactive_power * $reactive_power))), 2);
        $full_power_A       = round((sqrt(($active_power_A * $active_power_A) + ($reactive_power_A * $reactive_power_A))), 2);
        $full_power_B       = round((sqrt(($active_power_B * $active_power_B) + ($reactive_power_B * $reactive_power_B))), 2);
        $full_power_C       = round((sqrt(($active_power_C * $active_power_C) + ($reactive_power_C * $reactive_power_C))), 2);
        // Коэфициент мощности
        $koef_power_A         = round(($active_power_A / $full_power_A), 2);
        $koef_power_B         = round(($active_power_A / $full_power_B), 2);
        $koef_power_C         = round(($active_power_A / $full_power_C), 2);
        // Фазное напряжение - первичное
        $FU_first_A         = round(($Uf1 * 60), 2);
        $FU_first_B         = round(($Uf2 * 60), 2);
        $FU_first_C         = round(($Uf3 * 60), 2);
        // Линейное напряжение
        $U_lin_AB           = round($FU_first_A * 1.73,2);
        $U_lin_BC           = round($FU_first_B * 1.73,2);
        $U_lin_CA           = round($FU_first_C * 1.73,2);
        // Ток фаза - первичное
        $If_first_A         = round(($If1 * 60), 2);
        $If_first_B         = round(($If2 * 60), 2);
        $If_first_C         = round(($If3 * 60), 2);
        // =======================================================================
        $result = [
            'Uf1'               => $Uf1,
            'Uf2'               => $Uf2,
            'Uf3'               => $Uf3,
            'If1'               => $If1,
            'If2'               => $If2,
            'If3'               => $If3,
            'I_full'            => $I_full,
            'I_A'               => $I_A,
            'I_B'               => $I_B,
            'I_C'               => $I_C,
            'U_full'            => $U_full,
            'U_A'               => $U_A,
            'U_B'               => $U_B,
            'U_C'               => $U_C,
            'U_lin_AB'          => $U_lin_AB,
            'U_lin_BC'          => $U_lin_BC,
            'U_lin_CA'          => $U_lin_CA,
            'active_power'      => $active_power,
            'active_power_A'    => $active_power_A,
            'active_power_B'    => $active_power_B,
            'active_power_C'    => $active_power_C,
            'reactive_power'    => $reactive_power,
            'reactive_power_A'  => $reactive_power_A,
            'reactive_power_B'  => $reactive_power_B,
            'reactive_power_C'  => $reactive_power_C,
            'full_power'        => $full_power,
            'full_power_A'      => $full_power_A,
            'full_power_B'      => $full_power_B,
            'full_power_C'      => $full_power_C,
            'FU_first_A'        => $FU_first_A,
            'FU_first_B'        => $FU_first_B,
            'FU_first_C'        => $FU_first_C,
            'If_first_A'        => $If_first_A,
            'If_first_B'        => $If_first_B,
            'If_first_C'        => $If_first_C,
            'koef_power_A'      => $koef_power_A,
            'koef_power_B'      => $koef_power_B,
            'koef_power_C'      => $koef_power_C,
            'eap'               => round($eap,2),
            'erp'               => round($erp,2),
            'dtimeOS'           => $dtimeOS,

        ];
        return $result;
    }

    public function index()
    {
        $data_10days = dbdata_details::whereNotNull('eam')->orderBy('id','desc')->groupBy('dtimeOS_dt')->take(10)->get();
        $data_24hours = $this->get_last24hours();
        //$data_last = $data_24hours->last();
        //$data_calcf = $this->calcf($data_last->Uf1, $data_last->Uf2, $data_last->Uf3, $data_last->If1,$data_last->If2,$data_last->If3,$data_last->dtimeOS);
        return view('home',[
            'data_10days' => $data_10days,
            'data_24hours'=>$data_24hours
        ]);
    }
    private function get_date_arr($start_date,$end_date){
        $expected_days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        $start_timestamp = strtotime($start_date);
        $end_timestamp   = strtotime($end_date);
        $dates = array();
        while ($start_timestamp <= $end_timestamp) {
            if (in_array(date('l', $start_timestamp), $expected_days)) {
               $dates[] = date('Y-m-d', $start_timestamp);
            }
            $start_timestamp = strtotime('+1 day', $start_timestamp);
        }
        return $dates;
    }
    public function datedetail($date){
        $data = dbdata_details::where('dt_only',$date)->whereNotNull('eap')->orderby('dtimeOS','desc')->get();
        $dataView = [];
        foreach ($data as $row) {
            $dataView[$row['id']] = $this->calcf($row['Uf1'],$row['Uf2'],$row['Uf3'],$row['If1'],$row['If2'],$row['If3'],$row['dtimeOS'],$row['eap'],$row['erp']);
        }
        //dd($dataView);
        return view('detailByDate',['dataView' => $dataView,'date'=>$date]);
    }
    public function detailById($id){
        $data = dbdata_details::where('id',$id)->first();
        //d($data);
        $data_calcf = $this->calcf($data->Uf1,$data->Uf2,$data->Uf3,$data->If1,$data->If2,$data->If3,$data->stime);
        return view('detailById',['data' => $data, 'data_calcf'=>$data_calcf]);
    }


    public function help(){
        return view('help');
    }

    public function report(){
        $data = array();
        if(isset($_GET['date1']) AND isset($_GET['date2'])){
            $date1 = $_GET['date1'];
            $date2 = $_GET['date2'];
            if (strtotime($date2) >= strtotime($date2)){
                $date1_sql = date('Y-m-d',strtotime($date1));
                $date2_sql = date('Y-m-d',strtotime($date2));
           //     $data['db'] = dbdatasimple::whereBetween('stime',[$date1_sql.' 00:00:00',$date2_sql.' 23:59:59'])->orderby('stime','desc')->get();
                $dates_arr = $this->get_date_arr($date1_sql,$date2_sql);
                if(count($dates_arr) <= 10){
                    $data['status'] = 'ok';
                    foreach ($dates_arr as $row) {
                        $data_10days = dbdata_details::
                            where('dt_only','>=',$date1_sql)
                            ->where('dt_only','<=',$date2_sql)
                            ->groupBy('dt_only')
                            ->take(10)
                            ->get();
                        if($data_10days){
                        $data['db'] = $data_10days;

                        }
                    }                   
                }
                else {
                    $data['status'] = 'bad';
                    $data['msg'] = 'Диапазон даты превышает 10 дней. Выберите диапазон 10 дней или менее.';
                }
            }
            else {
                $data['status'] = 'bad';
                $data['msg'] = 'Ошибка. Неправильно указана дата. Правильно укажите начальную дату и конечную дату';
            }
        }

        return view('report',['data' => $data]);
    }
    private function get_last24hours(){
        $max_id = dbdata_details::max('id');
        $date1 = dbdata_details::where('id',$max_id)->first()->dtimeOS;
        $date2 = Carbon::parse($date1)->subDays(1);
        $data_24hours = dbdata_details::whereBetween('dtimeOS', [$date2,$date1])->get();
        $result = [];
        foreach ($data_24hours as $row) {
            $result[$row['id']] = $this->calcf($row['Uf1'],$row['Uf2'],$row['Uf3'],$row['If1'],$row['If2'],$row['If3'],$row['dtimeOS'],$row['eap'],$row['erp']);
        }
        return $result;
    }
    public function test(){
        return 'testo tiesto';



        
    }
}
