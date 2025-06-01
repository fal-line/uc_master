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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->enum('category', ['Coffee', 'Non-coffee','Snack']);
            $table->integer('price');
            $table->boolean('most_ordered');
            $table->string('img_url');
        });

        DB::table('menus')->insert(
            array(
            'name' => 'Latte',
            'description'=> 'A creamy blend of espresso and steamed milk.',
            'category'=> 'Coffee',
            'price' => '13500',
            'most_ordered'=> false,
            'img_url' => 'img/coffee_placeholder.png',
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
