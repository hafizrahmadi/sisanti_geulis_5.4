<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelSuratKeluar extends Model
{
	use SoftDeletes;
    //
    protected $table = 'tb_surat_keluar';
    protected $dates = ['deleted_at'];

}
