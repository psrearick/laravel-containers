<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up() : void
    {
        Schema::create('container_item_summaries', static function (Blueprint $table) {
            $table->id();
            $table->float('quantity')->nullable();
            $table->float('value')->nullable();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('container_id');
            $table->timestamps();
        });
    }
};
