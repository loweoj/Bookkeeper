<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAccountIdToRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('records', function(Blueprint $table)
		{
            $table->integer('account_id')->nullable()->unsigned()->after('stream_id');
            $table->foreign('account_id')->references('id')->on('bank_accounts');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('records', function(Blueprint $table)
		{
			$table->dropForeign('records_account_id_foreign');
		});
	}

}
