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
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('col')->default(12);
            $table->integer('row')->default(10);
            $table->integer('count_vip')->default(1000);
            $table->integer('count_normal')->default(500);
            $table->json('seats_type')->default(json_encode(["1,1"=>"NORM","1,2"=>"NORM","1,3"=> "NORM", "1,4"=>"NORM","1,5"=>"NORM","1,6"=> "NORM", "1,7"=>"NORM","1,8"=>"NORM","1,9"=> "NORM","1,10"=>"NORM","1,11"=>"NORM","1,12"=> "NORM", "2,1"=>"NORM","2,2"=>"NORM","2,3"=> "NORM", "2,4"=>"NORM","2,5"=>"NORM","2,6"=> "NORM", "2,7"=>"NORM","2,8"=>"NORM","2,9"=> "NORM","2,10"=>"NORM","2,11"=>"NORM","2,12"=> "NORM", "3,1"=>"NORM","3,2"=>"NORM","3,3"=> "NORM", "3,4"=>"NORM","3,5"=>"NORM","3,6"=> "NORM", "3,7"=>"NORM","3,8"=>"FAIL","3,9"=> "NORM","3,10"=>"NORM","3,11"=>"NORM","3,12"=> "NORM","4,1"=>"NORM","4,2"=>"NORM","4,3"=> "NORM", "4,4"=>"NORM","4,5"=>"NORM","4,6"=> "NORM", "4,7"=>"NORM","4,8"=>"NORM","4,9"=> "NORM","4,10"=>"NORM","4,11"=>"NORM","4,12"=> "NORM","5,1"=>"NORM","5,2"=>"NORM","5,3"=> "NORM", "5,4"=>"NORM","5,5"=>"NORM","5,6"=> "NORM", "5,7"=>"NORM","5,8"=>"NORM","5,9"=> "NORM","5,10"=>"NORM","5,11"=>"FAIL","5,12"=> "NORM","6,1"=>"NORM","6,2"=>"NORM","6,3"=> "NORM", "6,4"=>"NORM","6,5"=>"NORM","6,6"=> "NORM", "6,7"=>"NORM","6,8"=>"NORM","6,9"=> "NORM","6,10"=>"NORM","6,11"=>"NORM","6,12"=> "NORM", "7,1"=>"NORM","7,2"=>"NORM","7,3"=> "NORM", "7,4"=>"NORM","7,5"=>"NORM","7,6"=> "NORM", "7,7"=>"NORM","7,8"=>"NORM","7,9"=> "NORM","7,10"=>"NORM","7,11"=>"FAIL","7,12"=> "NORM", "8,1"=>"NORM","8,2"=>"NORM","8,3"=> "NORM", "8,4"=>"NORM","8,5"=>"NORM","8,6"=> "NORM", "8,7"=>"NORM","8,8"=>"FAIL","8,9"=> "NORM","8,10"=>"NORM","8,11"=>"FAIL","8,12"=> "NORM", "9,1"=>"NORM","9,2"=>"NORM","9,3"=> "NORM", "9,4"=>"NORM","9,5"=>"NORM","9,6"=> "NORM", "9,7"=>"NORM","9,8"=>"NORM","9,9"=> "NORM","9,10"=>"NORM","9,11"=>"NORM","9,12"=> "NORM", "10,1"=>"NORM","10,2"=>"FAIL","10,3"=> "NORM", "10,4"=>"NORM","10,5"=>"NORM","10,6"=> "NORM", "10,7"=>"NORM","10,8"=>"NORM","10,9"=> "NORM","10,10"=>"NORM","10,11"=>"NORM","10,12"=> "NORM"]));
            $table->boolean('open')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
