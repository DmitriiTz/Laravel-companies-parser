<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisits', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->string('name')->nullable();
            $table->string('inn')->nullable();
            $table->string('kpp')->nullable();
            $table->string('ogrn')->nullable();
            $table->string('grn')->nullable();
            $table->string('ogrnip')->nullable();
            $table->string('ogrnip_date')->nullable();
            $table->string('grnip')->nullable();
            $table->string('bank')->nullable();
            $table->string('ks')->nullable();
            $table->string('bik')->nullable();
            $table->string('ps')->nullable();
            $table->string('personal_account')->nullable();
            $table->string('okonh')->nullable();
            $table->string('okpo')->nullable();
            $table->string('certificate_num')->nullable();
            $table->string('certificate_date')->nullable();
            $table->string('signature_right')->nullable();
            $table->string('in_face')->nullable();
            $table->string('based')->nullable();

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
        Schema::dropIfExists('requisits');
    }
}
