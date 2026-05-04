<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_type_id')->constrained();
            $table->foreignId('printer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_no')->unique();
            $table->json('spec_snapshot')->comment('下單時規格快照，避免日後改價影響歷史訂單');
            $table->decimal('unit_price', 10, 2)->comment('單件基本價 + 加工加價');
            $table->unsignedInteger('quantity');
            $table->decimal('discount_rate', 4, 2)->default(1.00);
            $table->decimal('total_price', 10, 2);
            $table->string('file_path');
            $table->json('file_analysis')->nullable()->comment('Imagick 分析結果');
            $table->enum('status', [
                'pending',    // 待付款
                'paid',       // 已付款，待審核
                'reviewing',  // 審核中
                'assigned',   // 已指派印刷廠
                'printing',   // 生產中
                'shipped',    // 已出貨
                'completed',  // 完成
                'cancelled',  // 取消
            ])->default('pending');
            $table->date('estimated_completion_date')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('order_no');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('gateway')->default('newebpay');
            $table->string('transaction_id')->unique()->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->json('raw_response')->nullable();
            $table->timestamps();
        });

        Schema::create('line_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('printer_id')->constrained()->cascadeOnDelete();
            $table->text('message');
            $table->enum('status', ['sent', 'failed'])->default('sent');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('line_notifications');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('orders');
    }
};
