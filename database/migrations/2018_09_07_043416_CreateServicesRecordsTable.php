<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateServicesRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_service_records', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('customer_nic')->default('000000000V');
            $table->foreign('customer_nic')->references('nic')->on('feedback_customers');
            $table->integer('service_id');
            $table->string('description')->nullable();
            $table->timestamp('date_time')->default(Carbon::now());
            $table->boolean('resolved')->default(false);
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_service_records');
    }
}
