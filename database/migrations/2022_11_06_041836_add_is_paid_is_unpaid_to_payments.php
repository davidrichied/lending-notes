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
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('is_unpaid')->after('late_paid_at')->nullable();
            $table->renameColumn('paid_at', 'repay_at');
            $table->renameColumn('late_paid_at', 'repaid_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('is_unpaid');
            $table->renameColumn('repay_at', 'paid_at');
            $table->renameColumn('repaid_at', 'late_paid_at');
        });
    }
};
