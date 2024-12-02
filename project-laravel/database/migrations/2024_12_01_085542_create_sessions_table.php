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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Cột ID sẽ là khóa chính
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Nếu bạn muốn lưu ID người dùng
            $table->text('payload'); // Dữ liệu session
            $table->integer('last_activity'); // Thời gian hoạt động cuối cùng
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
