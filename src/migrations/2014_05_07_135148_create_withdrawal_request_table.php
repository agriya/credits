<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('withdrawal_request', function($table)
		{
			$table->increments('withdraw_id');
			$table->bigInteger('user_id');
			$table->string('currency', 10);
			$table->decimal('amount', 15, 2);
			$table->dateTime('added_date');
			$table->enum('status', array('Pending', 'Rejected', 'Paid'))->default('Pending');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('withdrawal_request');
	}

}
