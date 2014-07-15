<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->datetime('date');
			$table->string('payee');
			$table->string('description');
			$table->decimal('amount');
            $table->string('type');
            $table->enum('reconciled', [0,1]);
            $table->integer('statement_id')->unsigned();
            $table->foreign('statement_id')->references('id')->on('statements');
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
		Schema::drop('transactions');
	}

}
