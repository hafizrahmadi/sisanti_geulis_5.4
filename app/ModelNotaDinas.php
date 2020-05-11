<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelNotaDinas extends Model
{
	use SoftDeletes;
    //
    protected $table = 'tb_nota_dinas';
    protected $dates = ['deleted_at'];
}
