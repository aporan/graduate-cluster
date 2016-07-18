<?php

include(path('app').'/helpers/staticpages.php');

class StaticPages_Controller extends Base_Controller {

    public $restful = true;

    public function get_index() {
        $cluster_bookings = array();
        $clusters = DB::table('bookings')->distinct()->get(array('cluster_id'));
        
        if (isAdmin()) {
            foreach ($clusters as $cluster) {
                $id = $cluster->cluster_id;
                $cluster_bookings[$id] = Booking::where('cluster_id', '=', $id)->get();
            }


        } else {

            $user_id = Auth::user()->id;
            foreach($clusters as $cluster) {
                $id = $cluster->cluster_id;
                $cluster_bookings[$id] = DB::table('seat_managers')
                    ->join('bookings', 'bookings.seat_id', '=', 'seat_managers.seat_id')
                    ->where('seat_managers.user_id', '=', $user_id)
                    ->where('cluster_id', '=', $id)
                    ->get();
            }
        }

        return View::make('static.index')
                ->with('cluster_bookings', $cluster_bookings);
    }

    public function get_admin_index() {  return View::make('static.admin_index');  }

    public function get_email_index() {
        $clusters = Cluster::order_by('id')->lists('name', 'id');
        return View::make('static.email_index')
            ->with('clusters', $clusters);
    }

    public function get_view_report() {
        $clusters = Cluster::order_by('id')->lists('name', 'id');
        return View::make('static.report')
            ->with('clusters', $clusters);
    }

    public function post_generate_report() {
        $input = Input::all();
        
        if (array_key_exists('all', $input)) {
            
            $headers = array(
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename='.date('jS\_F\_Y').'.csv',
                'Expires'             => '0',
                'Pragma'              => 'public'
            );

            $list = Booking::all();

            $columns = (array) $list[0];
            $values = array_keys($columns['attributes']);

            $FH = fopen('php://output', 'w');
            fputcsv($FH, $values);
            foreach ($list as $row) {
                $columns = (array) $row;
                $values = array_values($columns['attributes']);
                fputcsv($FH, $values);
            }
            fclose($FH);
        
            return Response::make($FH, 200, $headers);
            
        } else {

            $cluster_id = $input['cluster'];
            $cluster = Cluster::find($cluster_id);
            $list = Booking::where('cluster_id', '=', $cluster_id)->get();

            $headers = array(
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename='.strtolower($cluster->name).'_'.date('jS\_F\_Y').'.csv',
                'Expires'             => '0',
                'Pragma'              => 'public'
            );

            $columns = (array) $list[0];
            $values = array_keys($columns['attributes']);
            
            $FH = fopen('php://output', 'w');
            fputcsv($FH, $values);
            foreach ($list as $row) {
                $columns = (array) $row;
                $values = array_values($columns['attributes']);
                fputcsv($FH, $values);
            }
            fclose($FH);
        
            return Response::make($FH, 200, $headers);
        }
        
    }

    public function post_email_send() {
        $input = Input::all();
        $sent = sendEmail($input);
        if ($sent) {
            $message = "Your email has been delivered!";
            return Redirect::to('admin')
                ->with('message', $message);
        } else {
            $message = "Your message was not delivered! Please try again or contact adminstrator.";
            return Redirect::to_route('email_index')
                ->with('email_error', $message)
                ->with_input();
        }
    }
}

?>

