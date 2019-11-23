<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dbdata extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'hes3_f6_full';
}
