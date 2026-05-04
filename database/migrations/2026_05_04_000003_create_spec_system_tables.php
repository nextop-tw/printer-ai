<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 規格維度（Table A）：尺寸、紙張、材質、顏色...
        Schema::create('spec_dimensions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 規格選項（Table B）：A4、銅版紙、霧面...
        Schema::create('spec_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spec_dimension_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->decimal('price_addon', 10, 2)->default(0)->comment('疊加加價，0 為基礎選項');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 產品類型：名片、DM、T恤...
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 產品類型與規格維度的多對多關聯
        Schema::create('product_type_spec_dimensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spec_dimension_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_required')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unique(['product_type_id', 'spec_dimension_id'], 'pt_sd_unique');
        });

        // 主規格組合基本價
        Schema::create('product_base_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_type_id')->constrained()->cascadeOnDelete();
            $table->json('spec_option_ids')->comment('主規格選項 ID 組合，排序後存入');
            $table->decimal('base_price', 10, 2);
            $table->timestamps();
        });

        // 數量折扣
        Schema::create('quantity_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('min_quantity')->comment('最低數量門檻');
            $table->decimal('discount_rate', 4, 2)->comment('折扣率，0.9 = 九折');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quantity_discounts');
        Schema::dropIfExists('product_base_prices');
        Schema::dropIfExists('product_type_spec_dimensions');
        Schema::dropIfExists('product_types');
        Schema::dropIfExists('spec_options');
        Schema::dropIfExists('spec_dimensions');
    }
};
