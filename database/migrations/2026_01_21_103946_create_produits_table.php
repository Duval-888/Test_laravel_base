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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string(column: 'nom', length:20);
            $table->string(column:'description')->nullable();
            $table->integer(column:'qte');
            $table->double('prix');
            $table->string(column:'code', length:20)->unique();
            $table->foreignId(column:'user_id')->constrained(table:'users');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table:'produits');
    }
};