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
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("tasklabel_id")->unsigned();
            $table->string("title");
            $table->text("description");
            $table->timestamp("dueDate")->nullable();
            $table->timestamp("createdAt")->useCurrent();
            $table->timestamp("updatedAt")->useCurrent()->useCurrentOnUpdate();
            $table->foreign("tasklabel_id")->references("id")->on("task_label")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
