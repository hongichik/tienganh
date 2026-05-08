<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('user_question_hints', 'answer_position')) {
            Schema::table('user_question_hints', function (Blueprint $table): void {
                $table->unsignedTinyInteger('answer_position')->default(0)->after('question_id');
            });
        }

        DB::table('user_question_hints')
            ->whereNull('answer_position')
            ->update(['answer_position' => 0]);

        if (! $this->indexExists('user_question_hints', 'idx_uqh_user_id')) {
            DB::statement('ALTER TABLE user_question_hints ADD INDEX idx_uqh_user_id (user_id)');
        }

        if (! $this->indexExists('user_question_hints', 'idx_uqh_question_id')) {
            DB::statement('ALTER TABLE user_question_hints ADD INDEX idx_uqh_question_id (question_id)');
        }

        if ($this->indexExists('user_question_hints', 'user_question_hints_user_id_question_id_unique')) {
            DB::statement('ALTER TABLE user_question_hints DROP INDEX user_question_hints_user_id_question_id_unique');
        }

        if (! $this->indexExists('user_question_hints', 'uq_user_question_position')) {
            DB::statement('ALTER TABLE user_question_hints ADD UNIQUE INDEX uq_user_question_position (user_id, question_id, answer_position)');
        }
    }

    public function down(): void
    {
        if ($this->indexExists('user_question_hints', 'uq_user_question_position')) {
            DB::statement('ALTER TABLE user_question_hints DROP INDEX uq_user_question_position');
        }

        if (Schema::hasColumn('user_question_hints', 'answer_position')) {
            Schema::table('user_question_hints', function (Blueprint $table): void {
                $table->dropColumn('answer_position');
            });
        }

        if (! $this->indexExists('user_question_hints', 'user_question_hints_user_id_question_id_unique')) {
            DB::statement('ALTER TABLE user_question_hints ADD UNIQUE INDEX user_question_hints_user_id_question_id_unique (user_id, question_id)');
        }

        if ($this->indexExists('user_question_hints', 'idx_uqh_user_id')) {
            DB::statement('ALTER TABLE user_question_hints DROP INDEX idx_uqh_user_id');
        }

        if ($this->indexExists('user_question_hints', 'idx_uqh_question_id')) {
            DB::statement('ALTER TABLE user_question_hints DROP INDEX idx_uqh_question_id');
        }
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $result = DB::selectOne(
            'SELECT COUNT(1) AS aggregate FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = ? AND index_name = ?',
            [$table, $indexName]
        );

        return (int) ($result->aggregate ?? 0) > 0;
    }
};
