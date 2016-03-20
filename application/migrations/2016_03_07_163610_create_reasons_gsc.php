<?php

class Create_Reasons_Gsc {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('reasons_gsc', function($table){
            $table->increments('id');
            $table->text('reasons');
            $table->timestamps();
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('reasons_gsc');
	}

}