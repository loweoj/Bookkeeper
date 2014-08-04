<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('records', function(Blueprint $table)
		{
			$table->increments('id');
			$table->datetime('date');
			$table->string('payee');
			$table->string('description');
            $table->enum('type', ['income','expense']);
			$table->decimal('amount');
            $table->integer('transaction_id')->nullable()->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('stream_id')->unsigned();
            $table->enum('status', ['draft','accepted']);
            $table->softDeletes();
            $table->timestamps();
			$table->foreign('transaction_id')->references('id')->on('transactions');
			$table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('stream_id')->references('id')->on('streams');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('records');
	}

}
