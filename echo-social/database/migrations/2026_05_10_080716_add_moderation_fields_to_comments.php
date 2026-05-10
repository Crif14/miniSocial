<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Quando il commento è stato flaggato dalla moderazione
            $table->timestamp('flaggedAt')->nullable()->after('isFlagged');
            // Quando l'admin ha revisionato il commento
            $table->timestamp('reviewedAt')->nullable()->after('flaggedAt');
            // Decisione admin: 'approved' o 'rejected'
            $table->string('reviewStatus')->nullable()->after('reviewedAt');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['flaggedAt', 'reviewedAt', 'reviewStatus']);
        });
    }
};