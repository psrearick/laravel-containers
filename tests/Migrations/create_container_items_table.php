<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up() : void
    {
        Schema::create('container_items', static function (Blueprint $table) {
            $table->id();
            $table->string('containerable_uuid');
            $table->string('containerable_type');
            $table->string('itemable_uuid');
            $table->string('itemable_type');
            $table->integer('quantity', false, true);
            $table->timestamps();
        });
    }
};
