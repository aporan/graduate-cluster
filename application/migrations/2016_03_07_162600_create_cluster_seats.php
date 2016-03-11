<?php

class Create_Cluster_Seats {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('cluster_seats', function($table){
            $table->increments('id');
            $table->integer('cluster_id')->unsigned();
            $table->text('seat_title')->unsigned();
            $table->boolean('available')->default(true);
            $table->timestamps();
            $table->foreign('cluster_id')
                  ->references('id')
                  ->on('graduate_cluster')
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
        Schema::drop('cluster_seats');
	}

}