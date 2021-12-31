<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AaLastRequestedAndLastUsedToLinks extends Migration
{

    public function up(): void
    {
        Schema::table('links', static function (Blueprint $table) {
            $table->timestamp('last_requested')->nullable();
            $table->timestamp('last_used')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('links', static function (Blueprint $table) {
            $table->dropColumn('last_requested','last_used');
        });
    }
}
