<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoleClientApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_client_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('client_application_id');
            $table->unsignedInteger('role_id');
            $table->primary(['client_application_id', 'role_id']);
            $table->foreign('client_application_id')
                ->references('id')
                ->on('client_applications')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_client_applications');
    }
}
