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
        Schema::create('trip_place', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('place_id');
            $table->unsignedBigInteger('trip_id');
            $table->double('price');
            $table->json('shares'); // {ivan: x, maria: y}
            $table->date('check_in');
            $table->date('check_out');
            
            $table->foreign('place_id')
                ->references('id')
                ->on('places')
                ->onDelete('cascade');

            $table->foreign('trip_id')
                ->references('id')
                ->on('trips')
                ->onDelete('cascade');     
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_place');
    }
};
