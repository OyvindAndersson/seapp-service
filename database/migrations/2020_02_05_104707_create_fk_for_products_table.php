<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFkForProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('product_group_id')
            ->references('id')
            ->on('product_groups');

            $table->foreign('image_file_id')
            ->references('id')
            ->on('files')
            ->onDelete('cascade');

            $table->foreign('supplier_id')
            ->references('id')
            ->on('suppliers')
            ->onDelete('cascade');

            $table->foreign('primary_price_id')
            ->references('id')
            ->on('price_descriptions')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_image_file_id_foreign');
            $table->dropForeign('products_product_group_id_foreign');
            $table->dropForeign('products_supplier_id_foreign');
        });
    }
}
