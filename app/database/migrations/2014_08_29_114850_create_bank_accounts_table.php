<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('description')->nullable();
			$table->integer('account_number');
			$table->string('sort_code');
            $table->enum('default', ['0', '1']);
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
		Schema::drop('bank_accounts');
	}

}
