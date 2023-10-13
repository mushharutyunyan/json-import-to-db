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
        Schema::create('imports', function (Blueprint $table) {
            $table->id('import_id');
            $table->enum('status', ['pending', 'failed', 'finished'])->default('pending');
            $table->enum('type',['users']); // can be filled in future
            $table->string('file_url');
            $table->string('file_pointer')->nullable();
            $table->smallInteger('rows_qty_per_request')->default(1000);
            $table->integer('failed_index')->nullable();
            $table->tinyInteger('done_pct')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imports');
    }
};
