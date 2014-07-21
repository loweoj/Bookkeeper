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
			$table->decimal('money_in')->nullable();
			$table->decimal('money_out')->nullable();
            $table->integer('transaction_id')->nullable()->unsigned();
            $table->integer('category_id')->unsigned();
            $table->softDeletes();
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
