<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbCuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cuti', function (Blueprint $table) {
            $table->id();
            $table->string('nmr_induk');
            $table->date('tgl_cuti');
            $table->integer('lama_cuti');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // $table->foreign('nmr_induk')->references('nmr_induk')->on('tb_karyawan')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cuti');
    }
}
