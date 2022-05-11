<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up() : void
    {
        Schema::create('container_outer', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_id');
            $table->foreignId('outer_id');
            $table->integer('quantity', false, true);
            $table->timestamps();
        });
    }
};
