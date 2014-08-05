<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAttachmentIdToRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('records', function(Blueprint $table)
		{
			$table->integer('attachment_id')->nullable()->unsigned();
            $table->foreign('attachment_id')->references('id')->on('attachments');
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
			$table->dropForeign('records_attachment_id_foreign');
		});
	}

}
