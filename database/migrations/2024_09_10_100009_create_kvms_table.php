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
        Schema::create('kvms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("kvm_id");
            $table->string("kvm_name");
            $table->unsignedBigInteger("valid_until");
            $table->longText("signature");
            $table->string("api_host");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kvms');
    }
};
