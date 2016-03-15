<?php

class Create_Student_Booking {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('student_booking', function($table){
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
            $table->integer('faculty_id')->unsigned();
            $table->integer('cluster_id')->unsigned();
            $table->integer('seat_id')->unsigned();
            $table->integer('reasons_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('faculty_id')
                  ->references('id')
                  ->on('faculty');
            $table->foreign('seat_id')
                  ->references('id')
                  ->on('cluster_seats')
                  ->onDelete('cascade');
            $table->foreign('cluster_id')
                  ->references('id')
                  ->on('graduate_cluster')
                  ->onDelete('cascade');
            $table->foreign('reasons_id')
                  ->references('id')
                  ->on('reasons_gsc')
                  ->onDelete('cascade');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('student_booking');
	}

}