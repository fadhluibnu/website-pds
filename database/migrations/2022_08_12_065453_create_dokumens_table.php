<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('nomor');
            $table->string('judul');
            $table->string('status');
            $table->string('pemohon');
            $table->string('jenisdokumen');
            $table->string('jenispermohonan');
            $table->text('deskripsi')->nullable();
            $table->string('file');
            $table->string('pic')->nullable();
            $table->string('pihak_terkait')->nullable();
            $table->string('management')->nullable();
            $table->string('pengendali_dokumen')->nullable();
            $table->string('location');
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
        Schema::dropIfExists('dokumens');
    }
}
