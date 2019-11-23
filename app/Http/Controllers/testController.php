<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class testController extends Controller
{
    public function index(){
    	$Products = DB::connection('mysql2')->
    		table('hes3_f6')->
    		orderby('stime','desc')->
    		first();
    	//var_dump($Products);
    	echo 'Показание счетчика: '.$Products->erp.' на '.$Products->stime;
    }
}
