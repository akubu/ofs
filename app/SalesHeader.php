<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesHeader extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = "BEBB_India\$Sales Header";

}
