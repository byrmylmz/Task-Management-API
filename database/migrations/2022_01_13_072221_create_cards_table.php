<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->uuid('temp_id')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('column_id')->constrained()->onDelete('cascade');
            $table->decimal('order', $precision = 32, $scale = 16);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
