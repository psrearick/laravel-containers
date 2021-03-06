<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up() : void
    {
        Schema::create('container_items', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_id');
            $table->foreignId('item_id');
            $table->foreignId('container_item_summary_id')->nullable();
            $table->float('quantity')->nullable();
            $table->float('value')->nullable();
            $table->timestamps();
        });
    }
};
