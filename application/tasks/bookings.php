<?php

class Bookings_Task {

    public function run($arguments) {

        $date =  new Datetime('today');
        $bookings = Booking::where('booking_till', '<=', $date->format('Y-m-d H:i:s'))->get();

        if(!empty($bookings)) {
            
            $count = 0;
            foreach($bookings as $booking) {
                $seat = $booking->seat()->first();
                $cluster = $booking->cluster()->first();
                
                $seat->available = 1;
                $seat->save();
                
                $temp = $cluster->booked_seats;
                $cluster->booked_seats = $temp - 1;
                $cluster->save();

                $booking->delete();
                $count += 1;
            }
            echo $count.' bookings were deleted!';
        }

    }

    public function notify($arguments) {

        $date = new Datetime('today');
        $date->modify('+7 day');
        $bookings = Booking::where('booking_till', '=', $date->format('Y-m-d H:i:s'))->get();

        if(!empty($bookings)) {

            $count = 0;
            foreach($bookings as $booking) {
                $this->sendEmail($booking, '7');
                $count += 1;
            }
            echo 'A notification email has been sent to '.$count.' people';
        }

    }

    public function urgent($arguments) {

        $date = new Datetime('today');
        $date->modify('+3 day');
        $bookings = Booking::where('booking_till', '=', $date->format('Y-m-d H:i:s'))->get();
        $count = 0;

        if(!empty($bookings)) {

            $count = 0;
            foreach($bookings as $booking) {
                $this->sendEmail($booking, '3', $color='red');
                $count += 1;
            }
            echo 'A notification email has been sent to '.$count.' people';
        }

    }

    public function sendEmail($booking, $days, $color='black') {

        $cluster_name = $this->getClusterName($booking->cluster_id);
        $seat_number = $this->getSeatNumber($booking->seat_id);

        $to = 'ahnaf_siddiqi@mymail.sutd.edu.sg, ahnafsidd@gmail.com';
        $subject = 'Booking Expiring!';
        $headers = "MIME-Version: 1.0" . "\r\n" .
            "Content-type:text/html;charset=UTF-8" . "\r\n" .
            'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/';

        $message =
            'Hi there!'.
            "<br/>".
            "<br/>".
            '<p>Your booking is expiring in <b style="color: '.$color.'">'.$days.' days!</b></p>'.
            '<p>Please extend your booking if you plan continue.</p>'.
            '<p>Ignore this message otherwise.</p>'.
            "<br/>".
            "<br/>".
            'Name: '.ucwords($booking->first_name).' '.ucwords($booking->last_name). "<br/>".
            'Contact: '.$booking->mobile. "<br/>".
            'Email: '.$booking->email. "<br/>".
            "<br/>".
            '<b>Cluster</b>: '.$cluster_name. "<br/>".
            '<b>Seat Number</b>: '.$seat_number. "<br/>".
            "<br/>".
            'Booking Started From: '.substr($booking->booking_from, 0, 11). "<br/>".
            'Current End Date: '.substr($booking->booking_till, 0, 11).
            "<br/>".
            "<br/>".
            'Please contact us at xxxx@xxxx.com if something is missing or you need to change something.'.
            "<br/>".
            "<br/>".
            'Thank You,'.
            "<br/>".
            'Graduate Office.';
        
        return mail($to, $subject, $message, $headers);
    }

    public function getClusterName($id){
        $this_cluster = Cluster::find($id);
        return $this_cluster->name;
    }
    
    public function getSeatNumber($id){
        $this_seat = ClusterSeat::find($id);
        return $this_seat->number;
    }
}

?>