<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{

    public function up(): void
    {
        Schema::create('links', static function (Blueprint $table) {
            $table->id();
            $table->string('original_url')->unique();
            $table->string('code')->nullable()->unique();
            $table->integer('requested_count')->default(0);
            $table->integer('used_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
}
