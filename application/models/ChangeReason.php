<?php


class ChangeReason extends Eloquent {

    public static $table = 'reasons_gsc';
    public static $accessible = array('reasons');

    public static $rules_reason = array(
        'areason' => 'required',
        'cluster' => 'required|integer'
    );

    public static $rules_update = array(
        'seat' => 'required|integer',
        'bookfro' => 'required|date_format:Y-m-d',
        'booktill'=> 'required|date_format:Y-m-d',
    );

    public static function validation_reason($data){
        return Validator::make($data, ChangeReason::$rules_reason);
    }

    public static function validation_update($data){
        return Validator::make($data, ChangeReason::$rules_update);
    }

    public function booking(){
        return $this->belongs_to('Booking');
    }

}

?>