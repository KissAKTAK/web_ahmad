
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laws', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('law_number');
            $table->year('year');
            $table->string('category');
            $table->string('pdf_file')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laws');
    }
};
