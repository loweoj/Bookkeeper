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
			$table->decimal('money_in');
			$table->decimal('money_out');
            $table->integer('transaction_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->timestamps();
			$table->foreign('transaction_id')->references('id')->on('transactions');
			$table->foreign('category_id')->references('id')->on('categories');
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
