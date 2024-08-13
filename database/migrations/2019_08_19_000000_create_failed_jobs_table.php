<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('uuid')->charset('utf8')->unique();
            $table->text('connection')->charset('utf8');
            $table->text('queue')->charset('utf8');
            $table->longText('payload')->charset('utf8');
            $table->longText('exception')->charset('utf8');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}
