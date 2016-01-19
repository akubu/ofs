<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesLine extends Model
{
    protected $connection = 'sqlsrv';


    protected $table = "BEBB_India\$Sales Line";
}
