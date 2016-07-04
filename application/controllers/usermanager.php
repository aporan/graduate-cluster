<?php

include(path('app').'/helpers/usermanager.php');

class UserManager_Controller extends Base_Controller {

    public $restful = true;

    public function get_index() {
        $admins = User::where('type', '=', 'admin')->get();
        $generals = User::where('type', '=', 'general')->get();

        return View::make('manager.index')
            ->with('admins', $admins)
            ->with('generals', $generals);
    }

    public function get_view_assign($id) {
        $assigned_seats = array(); 
        $unassigned_seats = array();
        $clusters = DB::table('bookings')->distinct()->get(array('cluster_id'));
        foreach ($clusters as $cluster) {
            $cluster_id = $cluster->cluster_id;
            $unassigned_seats[$cluster_id] = getUnassignedSeats($cluster_id);
            $assigned_seats[$cluster_id] = getAssignedSeats($id, $cluster_id);
        }

        return View::make('manager.assign')
            ->with('unassigned_seats', $unassigned_seats)
            ->with('user', $id)
            ->with('assigned_seats', $assigned_seats);
    }

    public function post_assign() {
        $input = Input::all();
        assignSeats($input);
        return Redirect::to_route('manager_index');
    }

    public function post_unassign() {
        $input = Input::all();
        unassignSeats($input);
        return Redirect::to_route('manager_index');
    }


}

?>
