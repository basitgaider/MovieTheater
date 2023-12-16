<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Livewire\on;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seat_id')->nullable();
            $table->foreign('seat_id')->references('id')->on('seats');
            $table->unsignedBigInteger('show_id')->nullable();
            $table->foreign('show_id')->references('id')->on('shows');
            $table->string('price');
            $table->boolean('is_booked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
