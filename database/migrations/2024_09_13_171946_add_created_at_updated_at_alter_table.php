<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedAtUpdatedAtAlterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('before_aq', function (Blueprint $table) {
            $table->string('created_at');
            $table->string('updated_at');
        });

        Schema::table('end_aq', function (Blueprint $table) {
            $table->string('created_at');
            $table->string('updated_at');
        });

        Schema::table('basic_layout_aq', function (Blueprint $table) {
            $table->string('created_at');
            $table->string('updated_at');
        });

        Schema::table('bad_layout_aq', function (Blueprint $table) {
            $table->string('created_at');
            $table->string('updated_at');
        });

        // Schema::table('test_result', function (Blueprint $table) {
        //     $table->string('created_at');
        //     $table->string('updated_at');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('before_aq', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        Schema::table('end_aq', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        Schema::table('basic_layout_aq', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        Schema::table('bad_layout_aq', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        // Schema::table('test_result', function (Blueprint $table) {
        //     $table->dropColumn('created_at');
        //     $table->dropColumn('updated_at');
        // });

    }
}
