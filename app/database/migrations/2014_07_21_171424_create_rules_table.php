<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rules', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
            $table->text('conditionJson');
            $table->string('conditionType');
            $table->string('to_payee');
			$table->integer('to_category');
			$table->integer('to_stream');
			$table->string('to_description');
			$table->text('splitJson');
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
		Schema::drop('rules');
	}

}
