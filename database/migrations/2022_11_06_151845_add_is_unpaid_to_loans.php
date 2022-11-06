<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->renameColumn('total_repayment_amount', 'repayment_amount');
            $table->boolean('is_unpaid')->after('is_late')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->renameColumn('repayment_amount', 'total_repayment_amount');
            $table->dropColumn('is_unpaid');
        });
    }
};
