<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('line_user_id')->nullable()->comment('LINE 通知目標 ID');
            $table->unsignedInteger('working_days')->default(3);
            $table->enum('status', ['active', 'suspended'])->default('active')->comment('廠商自設');
            $table->boolean('admin_suspended')->default(false)->comment('管理員強制暫停，優先於 status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
