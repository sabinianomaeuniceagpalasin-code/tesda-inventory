<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyInventoryTable extends Migration
{
    public function up(): void
    {
        Schema::create('property_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('property_no')->unique();
            $table->string('tool_name');
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_inventory');
    }
}
