<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelSuratMasuk extends Model
{
	use SoftDeletes;
    //
    protected $table = 'tb_surat_masuk';
    protected $dates = ['deleted_at'];
}
