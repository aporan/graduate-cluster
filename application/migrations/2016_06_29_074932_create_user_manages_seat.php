<?php

class Create_User_Manages_Seat {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('seat_managers', function($table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('seat_id')->unsigned();
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->on_delete('cascade');
            $table->foreign('seat_id')
                  ->references('id')
                  ->on('cluster_seats')
                  ->on_delete('cascade');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('seat_managers');
	}

}