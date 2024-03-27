<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained();
            $table->string('name');
            $table->string('nip')->unique();
            $table->string('departemen')->nullable();
            $table->string('tgl_lahir')->nullable();
            $table->string('thn_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('tlp')->nullable();
            $table->tinyInteger('agama')->default(0);
            $table->tinyInteger('status')->default(0); // 0 aktif // 1 tidak aktif
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
        Schema::dropIfExists('employees');
    }
}
