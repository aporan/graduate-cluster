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
            $table->integer('booking_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('booking_id')
                  ->references('id')
                  ->on('student_booking');
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