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
        Schema::create('vehicle_names', function (Blueprint $table) {
            $table->id();
			$table->string('vname');
			$table->integer('vtype');
			$table->integer('vmodel');
			$table->text('description')->nullable();
			$table->tinyInteger('status')->nullable();                        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_names');
    }
};