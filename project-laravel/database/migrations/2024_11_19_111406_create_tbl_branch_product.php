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
        Schema::create('tbl_branch_product', function (Blueprint $table) {
            $table->increments('branch_id');
            $table->string('branch_name');
            $table->text('branch_desc');
            $table->text('branch_product_keywords');
            $table->integer('branch_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_branch_product');
    }
};
