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
        Schema::create('sermons', function (Blueprint $table) {
            $table->id();
              $table->string('title');
    $table->foreignId('pastor_id')->nullable()->constrained()->onDelete('set null');
    $table->foreignId('event_id')->nullable()->constrained()->onDelete('set null');
    $table->string('guest_preacher')->nullable();
    $table->string('bible_text')->nullable();
    $table->text('summary')->nullable();
    $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sermons');
    }
};
