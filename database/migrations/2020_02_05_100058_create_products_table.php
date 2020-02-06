<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique()->nullable();
            $table->string('ean')->unique()->nullable();
            $table->string('name');
            $table->string('description')->default('');
            $table->unsignedBigInteger('product_group_id');
            $table->unsignedBigInteger('image_file_id')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('primary_price_id')->nullable();
            $table->timestamps();

            $table->unique(['name', 'code']);
            $table->unique(['name', 'ean']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
