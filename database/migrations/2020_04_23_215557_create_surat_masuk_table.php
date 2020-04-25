<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_surat_masuk', function (Blueprint $table) {


            $table->increments('id');
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('perihal');
            $table->string('asal_surat');
            $table->string('lampiran')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('tb_user');
            $table->string('file_dokumen')->nullable();
            $table->string('catatan')->nullable();
            $table->unsignedBigInteger('id_user_camat');
            $table->foreign('id_user_camat')->references('id')->on('tb_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
