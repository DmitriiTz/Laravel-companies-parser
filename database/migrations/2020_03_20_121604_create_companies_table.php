<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('create_date')->nullable();
            $table->string('manager')->nullable();
            $table->string('name')->nullable();
            $table->string('company_id')->nullable();
            $table->string('mark')->nullable();
            $table->string('status')->nullable();
            $table->string('change_status')->nullable();
            $table->string('email')->nullable();
            $table->string('email_bill')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->string('pay_type')->nullable();
            $table->string('client_type')->nullable();
            $table->string('company')->nullable();
            $table->string('sender')->nullable();
            $table->string('agent_buisnes')->nullable();
            $table->string('connect_in')->nullable();
            $table->string('statistic')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
