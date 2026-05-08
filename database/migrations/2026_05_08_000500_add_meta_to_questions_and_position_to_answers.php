<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table): void {
            $table->json('meta')->nullable()->after('type');
        });

        Schema::table('answers', function (Blueprint $table): void {
            $table->unsignedTinyInteger('answer_position')->nullable()->after('user_id');
            $table->index(['question_id', 'answer_position']);
        });
    }

    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table): void {
            $table->dropIndex(['question_id', 'answer_position']);
            $table->dropColumn('answer_position');
        });

        Schema::table('questions', function (Blueprint $table): void {
            $table->dropColumn('meta');
        });
    }
};
