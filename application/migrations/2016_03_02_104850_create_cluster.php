<?php

class Create_Cluster {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('clusters', function($table){
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('allocated_seats')->unsigned();
            $table->integer('available_seats')->unsigned();
            $table->integer('level')->unsigned();
            $table->integer('building')->unsigned();
            $table->string('image_path');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('clusters');
	}

}