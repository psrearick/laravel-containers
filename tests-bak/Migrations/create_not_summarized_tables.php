<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up() : void
    {
        Schema::create('container_not_summarizeds', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
        });

        Schema::create('item_not_summarizeds', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('container_item_not_summarizeds', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_not_summarized_id');
            $table->foreignId('item_not_summarized_id');
            $table->float('quantity')->nullable();
            $table->float('value')->nullable();
            $table->timestamps();
        });
    }
};
