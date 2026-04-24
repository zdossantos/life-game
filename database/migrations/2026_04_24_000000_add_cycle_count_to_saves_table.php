<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('saves', function (Blueprint $table) {
            $table->integer('cycle_count')->default(0)->after('selected_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saves', function (Blueprint $table) {
            $table->dropColumn('cycle_count');
        });
    }
};
