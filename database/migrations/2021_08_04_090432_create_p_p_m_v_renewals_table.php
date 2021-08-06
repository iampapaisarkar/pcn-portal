<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePPMVRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_p_m_v_renewals', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->integer('meptp_application_id');
            $table->integer('ppmv_application_id');
            $table->integer('renewal_year');
            $table->string('licence')->nullable();
            $table->string('status');
            $table->boolean('payment')->default(false);
            $table->longtext('query')->nullable();
            $table->string('token')->nullable();
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
        Schema::dropIfExists('p_p_m_v_renewals');
    }
}
