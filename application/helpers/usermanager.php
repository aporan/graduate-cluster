<?php
function getUnassignedSeats($cluster_id) {
    $seats = DB::query('SELECT combined.id, combined.number
                        FROM 
                        (SELECT cluster_seats.id, cluster_seats.cluster_id, cluster_seats.number, seat_managers.user_id 
                        FROM cluster_seats 
                        LEFT JOIN seat_managers 
                        ON cluster_seats.id = seat_managers.seat_id) 
                        AS combined 
                        WHERE combined.user_id IS NULL
                        AND combined.cluster_id ='.$cluster_id
    );
    return $seats;
}

function getAssignedSeats($user_id, $cluster_id) {
    $seats = DB::table('cluster_seats')
        ->join('seat_managers', 'cluster_seats.id', '=', 'seat_managers.seat_id')
        ->where('seat_managers.user_id', '=', $user_id)
        ->where('cluster_seats.cluster_id', '=', $cluster_id)
        ->get();

    return $seats;
}

function assignSeats($input) {
    $user_id = $input['user'];
    
    unset($input['user']);
    unset($input['csrf_token']);
    
    foreach($input as $seat){
        UserManager::create(array(
            'user_id'=>$user_id,
            'seat_id'=>$seat
        ));
    }
}

function unassignSeats($input){
    $user_id = $input['user'];
    
    unset($input['user']);
    unset($input['csrf_token']);
    
    foreach($input as $seat){
        UserManager::where('seat_id','=',$seat)->delete();
    }
}

function checkAssigned($seats) {
    foreach($seats as $k => $v){
        if (!empty($v)) { return True; }
    }
    return False;
}

function getClusterName($id) {
    $name = Cluster::find($id)->name;
    return $name;
}

function getUserName($id) {
    $user = User::find($id);
    $first_name = $user->first_name;
    $last_name = $user->last_name;
    $name = ucwords($first_name).' '.ucwords($last_name);
    return $name;
}

function removeUser($input) {
    User::find($input['id'])->delete();
}

?>