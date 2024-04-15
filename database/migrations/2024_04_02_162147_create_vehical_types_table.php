<?php
// php artisan migrate --path='./database/migrations/2024_04_02_162147_create_vehical_types_table.php'
// php artisan migrate --path='./database/2024_04_02_162206_create_vehical_models_table.php'

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
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
			$table->string('name');
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
        Schema::dropIfExists('vehicle_types');
    }
};
