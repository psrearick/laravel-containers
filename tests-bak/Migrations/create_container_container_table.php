<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up() : void
    {
        Schema::create('container_containers', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id');
            $table->foreignId('child_id');
            $table->foreignId('container_container_summary_id')->nullable();
            $table->float('value')->nullable();
            $table->timestamps();
        });
    }
};
