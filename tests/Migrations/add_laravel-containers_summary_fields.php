<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::table('container_summaries', static function (Blueprint $table) {
            $table->float('value')->after('quantity')->nullable();
        });

        Schema::table('container_items', static function (Blueprint $table) {
            $table->float('value')->after('quantity')->nullable();
        });
    }
};
