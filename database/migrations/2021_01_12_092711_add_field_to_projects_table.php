<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedTinyInteger('number_of_buildings')->nullable();
            $table->unsignedSmallInteger('number_of_floors')->nullable();
            $table->unsignedMediumInteger('number_of_apartments')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->longText('utilities_desc')->nullable();
            $table->longText('project_progress_desc')->nullable();
        });

        Schema::create('project_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('name');
            $table->string('link');
            $table->string('type')->default('file');

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('number_of_buildings');
            $table->dropColumn('number_of_floors');
            $table->dropColumn('number_of_apartments');
            $table->dropColumn('partner_id');
            $table->dropColumn('utilities_desc');
            $table->dropColumn('project_progress_desc');
        });

        Schema::dropIfExists('project_documents');
    }
}