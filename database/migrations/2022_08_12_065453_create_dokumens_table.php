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
            $table->foreignId('jenisdokumen');
            $table->foreignId('jenispermohonan');
            $table->text('deskripsi')->nullable();
            $table->string('file');
            $table->string('file_name')->nullable();
            $table->foreignId('status');
            $table->string('pemohon');
            $table->string('pic_status')->default(false);
            $table->string('pihakterkait_status')->default(false);
            $table->string('management_status')->default(false);
            $table->string('pengendali_status')->default(false);
            $table->string('management')->nullable();
            $table->string('pengendali')->nullable();
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
