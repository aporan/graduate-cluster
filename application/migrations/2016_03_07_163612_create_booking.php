<?php

class Create_Booking {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('bookings', function($table){
            $table->increments('id');
            $table->string('first_name', 35);
            $table->string('last_name', 35);
            $table->string('email')->unique();
            $table->integer('mobile')->unsigned();
            $table->string('sex', 8);
            $table->string('gov_identifier')->unique();
            $table->string('pillar', 10);
            $table->string('category', 10);
            $table->date('booking_from');
            $table->date('booking_till');
            $table->string('nationality')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('cluster_id')->unsigned();
            $table->integer('seat_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
            $table->foreign('seat_id')
                  ->references('id')
                  ->on('cluster_seats')
                  ->on_delete('cascade');
            $table->foreign('cluster_id')
                  ->references('id')
                  ->on('clusters')
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
        Schema::drop('bookings');
	}

}