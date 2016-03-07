<?php

class Create_Graduate_Cluster {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('graduate_cluster', function($table){
            $table->increments('id');
            $table->string('cluster_name', 100);
            $table->string('email')->unique();
            $table->integer('max_seats')->unsigned();
            $table->integer('level')->unsigned();
            $table->integer('building')->unsigned();
            $table->string('image_path');
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
        Schema::drop('graduate_cluster');
	}

}