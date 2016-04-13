<?php

class Booking_Controller extends Base_Controller {

    public $restful = true;

    // renders index page
    public function get_index(){
        // TODO: retrieve current logged in faculty;
        $current_user = Faculty::find(2);
        $bookings = Booking::where('faculty_id', '=', $current_user->id)->get();
        return View::make('booking.index')
            ->with('bookings', $bookings);
    }

    // renders new booking page
    public function get_new(){
        $all_countries = list_of_countries();
        return View::make('booking.new_details')
            ->with('countries', $all_countries);
    }

    // stores the basic info in a session 
    public function post_pageone(){
        $input = Input::all();
        $validation = Booking::validation_basic($input);

        if ($validation->fails()) {
            return Redirect::to_route('new_booking')
                ->with_errors($validation)
                ->with_input();
        } else {
            storeDataInSessionOne($input);
            return Redirect::to_route('new_pagetwo');
        }
    }

    // returns the booking details page 
    public function get_pagetwo(){
        $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
        return View::make('booking.new_selection')
            ->with('clusters', $clusters);
    }

    // stores the booking details in a session 
    public function post_pagetwo(){
        $input = Input::all();
        $validation = Booking::validation_details($input);

        if ($validation->fails()){
            $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
            return Redirect::to_route('new_pagetwo')
                ->with_errors($validation)
                ->with_input();
        } else {
            storeDataInSessionTwo($input);
            return Redirect::to_route('new_pagethree');
        }
    }

    // get final page
    public function get_pagethree(){
        $session_details = Session::get('pagetwo_details');
        $selected_cluster = $session_details["cluster"];
        $image_path = Cluster::find($selected_cluster)->image_path;
        $seats = ClusterSeats::where('cluster_id', '=',  $selected_cluster)->lists('seat_title','id');
        return View::make('booking.new_final')
            ->with('seats', $seats)
            ->with('path', $image_path);
    }

    // creates an entry in the booking table
    public function post_create(){
        $input = Input::all();
        $validation = Booking::validation_final($input);

        if ($validation->fails()){
            return Redirect::to_route('new_pagethree')
                ->with_errors($validation)
                ->with_input();
        } else {
            createBooking(Input::all());
            $message = "Booking Successful!";
            return Redirect::to_route('bookings')
                ->with('message', $message);
        }
    }

    // creates an edit page for individual booking entry
    public function get_edit($id){
        $booking = Booking::find($id);
        return View::make('booking.edit')
            ->with('booking', $booking);
    }

    // updates individual booking entry
    public function put_update(){
        $input = Input::all();
        $validation = Booking::validation_update($input);

        if ($validation->fails()){
            $id = $input['booking'];
            $booking = Booking::find($id);
            return Redirect::to_route('edit_booking', array($id))
                ->with_errors($validation)
                ->with_input()
                ->with('booking', $booking);
            
        } else {
            updateBooking($input);
            $message = "Booking Updated!";
            return Redirect::to_route('bookings')
                ->with('message', $message);
        }
    }

    // removes a booking entry from the bookings table
    public function delete_remove(){
    }

}

// helper functions

function createBooking($input){
    $page_one_details = Session::get('pageone_details');
    $page_two_details = Session::get('pagetwo_details');
    
    Booking::Create(array(
        'first_name' => $page_one_details['studfirst'],
        'last_name'  => $page_one_details['studlast'],
        'email'      => $page_two_details['studemail'],
        'mobile'     => $page_two_details['studmob'],
        'sex'        => $page_one_details['gender'],
        'gov_identifier' => $page_two_details['studgov'],
        'pillar'       => $page_one_details['pillar'],
        'category'     => $page_one_details['studtyp'],
        'booking_from' => $page_two_details['bookfro'],
        'booking_till' => $page_two_details['booktill'],
        'nationality'  => $page_one_details['nation'],
        // this needs to be updated; currently using a hardcoded id
        'faculty_id'   => '1',
        'cluster_id'   => $page_two_details['cluster'],
        'seat_id'      => $input['seat']
    ));
    updateSeatAvailability($input['seat']);
    checkSession('pageone_details');
    checkSession('pagetwo_details');
    
}

function updateBooking($input){
    $booking_id = $input['booking'];
    Booking::update($booking_id, array(
        'first_name'    =>$input['studfirst'],
        'last_name'     =>$input['studlast'],
        'mobile'        =>$input['studmob'],
        'booking_from'  =>$input['bookfro'],
        'booking_till'  =>$input['booktill']
    ));
}

function checkSession($session_name){
    if(Session::has($session_name)){
        Session::forget($session_name);
    }
}

function storeDataInSessionOne($input){
    checkSession('pageone_details');
    $session_array = storePageOneInfo($input);
    Session::put('pageone_details', $session_array);
}

function storeDataInSessionTwo($input){
    checkSession('pagetwo_details');
    $session_array = storePageTwoInfo($input);
    Session::put('pagetwo_details', $session_array);
}

function storePageOneInfo($input){
    $temp_array = array();
    foreach($input as $key => $value){
        if ($key == 'studfirst' || $key == 'studlast' || $key == 'gender' || $key == 'nation'  || $key == 'pillar' || $key == 'studtyp'){
            $temp_array[$key] = $value;
        }
    }
    return $temp_array;
}

function storePageTwoInfo($input){
    $temp_array = array();
    foreach($input as $key => $value){
        if ($key == 'studemail' || $key == 'studmob' || $key == 'studgov' || $key == 'bookfro' || $key == 'booktill' || $key == 'cluster'){
            $temp_array[$key] = $value;
        }
    }
    return $temp_array;
}

function updateSeatAvailability($seat_id){
    $this_seat = ClusterSeats::find($seat_id);
    $this_seat->available = False;
    $this_seat->save();
}

function getClusterName($id){
    $this_cluster = Cluster::find($id);
    return $this_cluster->cluster_name;
}

function list_of_countries(){
    $list_of_countries =  array(
    'AF' => 'Afghanistan',
    'AX' => 'Aland Islands',
    'AL' => 'Albania',
    'DZ' => 'Algeria',
    'AS' => 'American Samoa',
    'AD' => 'Andorra',
    'AO' => 'Angola',
    'AI' => 'Anguilla',
    'AQ' => 'Antarctica',
    'AG' => 'Antigua and Barbuda',
    'AR' => 'Argentina',
    'AM' => 'Armenia',
    'AW' => 'Aruba',
    'AU' => 'Australia',
    'AT' => 'Austria',
    'AZ' => 'Azerbaijan',
    'BS' => 'Bahamas',
    'BH' => 'Bahrain',
    'BD' => 'Bangladesh',
    'BB' => 'Barbados',
    'BY' => 'Belarus',
    'BE' => 'Belgium',
    'BZ' => 'Belize',
    'BJ' => 'Benin',
    'BM' => 'Bermuda',
    'BT' => 'Bhutan',
    'BO' => 'Bolivia',
    'BQ' => 'Bonaire, Saint Eustatius and Saba',
    'BA' => 'Bosnia and Herzegovina',
    'BW' => 'Botswana',
    'BV' => 'Bouvet Island',
    'BR' => 'Brazil',
    'IO' => 'British Indian Ocean Territory',
    'VG' => 'British Virgin Islands',
    'BN' => 'Brunei',
    'BG' => 'Bulgaria',
    'BF' => 'Burkina Faso',
    'BI' => 'Burundi',
    'KH' => 'Cambodia',
    'CM' => 'Cameroon',
    'CA' => 'Canada',
    'CV' => 'Cape Verde',
    'KY' => 'Cayman Islands',
    'CF' => 'Central African Republic',
    'TD' => 'Chad',
    'CL' => 'Chile',
    'CN' => 'China',
    'CX' => 'Christmas Island',
    'CC' => 'Cocos Islands',
    'CO' => 'Colombia',
    'KM' => 'Comoros',
    'CK' => 'Cook Islands',
    'CR' => 'Costa Rica',
    'HR' => 'Croatia',
    'CU' => 'Cuba',
    'CW' => 'Curacao',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'CD' => 'Democratic Republic of the Congo',
    'DK' => 'Denmark',
    'DJ' => 'Djibouti',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'TL' => 'East Timor',
    'EC' => 'Ecuador',
    'EG' => 'Egypt',
    'SV' => 'El Salvador',
    'GQ' => 'Equatorial Guinea',
    'ER' => 'Eritrea',
    'EE' => 'Estonia',
    'ET' => 'Ethiopia',
    'FK' => 'Falkland Islands',
    'FO' => 'Faroe Islands',
    'FJ' => 'Fiji',
    'FI' => 'Finland',
    'FR' => 'France',
    'GF' => 'French Guiana',
    'PF' => 'French Polynesia',
    'TF' => 'French Southern Territories',
    'GA' => 'Gabon',
    'GM' => 'Gambia',
    'GE' => 'Georgia',
    'DE' => 'Germany',
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GR' => 'Greece',
    'GL' => 'Greenland',
    'GD' => 'Grenada',
    'GP' => 'Guadeloupe',
    'GU' => 'Guam',
    'GT' => 'Guatemala',
    'GG' => 'Guernsey',
    'GN' => 'Guinea',
    'GW' => 'Guinea-Bissau',
    'GY' => 'Guyana',
    'HT' => 'Haiti',
    'HM' => 'Heard Island and McDonald Islands',
    'HN' => 'Honduras',
    'HK' => 'Hong Kong',
    'HU' => 'Hungary',
    'IS' => 'Iceland',
    'IN' => 'India',
    'ID' => 'Indonesia',
    'IR' => 'Iran',
    'IQ' => 'Iraq',
    'IE' => 'Ireland',
    'IM' => 'Isle of Man',
    'IL' => 'Israel',
    'IT' => 'Italy',
    'CI' => 'Ivory Coast',
    'JM' => 'Jamaica',
    'JP' => 'Japan',
    'JE' => 'Jersey',
    'JO' => 'Jordan',
    'KZ' => 'Kazakhstan',
    'KE' => 'Kenya',
    'KI' => 'Kiribati',
    'XK' => 'Kosovo',
    'KW' => 'Kuwait',
    'KG' => 'Kyrgyzstan',
    'LA' => 'Laos',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LS' => 'Lesotho',
    'LR' => 'Liberia',
    'LY' => 'Libya',
    'LI' => 'Liechtenstein',
    'LT' => 'Lithuania',
    'LU' => 'Luxembourg',
    'MO' => 'Macao',
    'MK' => 'Macedonia',
    'MG' => 'Madagascar',
    'MW' => 'Malawi',
    'MY' => 'Malaysia',
    'MV' => 'Maldives',
    'ML' => 'Mali',
    'MT' => 'Malta',
    'MH' => 'Marshall Islands',
    'MQ' => 'Martinique',
    'MR' => 'Mauritania',
    'MU' => 'Mauritius',
    'YT' => 'Mayotte',
    'MX' => 'Mexico',
    'FM' => 'Micronesia',
    'MD' => 'Moldova',
    'MC' => 'Monaco',
    'MN' => 'Mongolia',
    'ME' => 'Montenegro',
    'MS' => 'Montserrat',
    'MA' => 'Morocco',
    'MZ' => 'Mozambique',
    'MM' => 'Myanmar',
    'NA' => 'Namibia',
    'NR' => 'Nauru',
    'NP' => 'Nepal',
    'NL' => 'Netherlands',
    'NC' => 'New Caledonia',
    'NZ' => 'New Zealand',
    'NI' => 'Nicaragua',
    'NE' => 'Niger',
    'NG' => 'Nigeria',
    'NU' => 'Niue',
    'NF' => 'Norfolk Island',
    'KP' => 'North Korea',
    'MP' => 'Northern Mariana Islands',
    'NO' => 'Norway',
    'OM' => 'Oman',
    'PK' => 'Pakistan',
    'PW' => 'Palau',
    'PS' => 'Palestinian Territory',
    'PA' => 'Panama',
    'PG' => 'Papua New Guinea',
    'PY' => 'Paraguay',
    'PE' => 'Peru',
    'PH' => 'Philippines',
    'PN' => 'Pitcairn',
    'PL' => 'Poland',
    'PT' => 'Portugal',
    'PR' => 'Puerto Rico',
    'QA' => 'Qatar',
    'CG' => 'Republic of the Congo',
    'RE' => 'Reunion',
    'RO' => 'Romania',
    'RU' => 'Russia',
    'RW' => 'Rwanda',
    'BL' => 'Saint Barthelemy',
    'SH' => 'Saint Helena',
    'KN' => 'Saint Kitts and Nevis',
    'LC' => 'Saint Lucia',
    'MF' => 'Saint Martin',
    'PM' => 'Saint Pierre and Miquelon',
    'VC' => 'Saint Vincent and the Grenadines',
    'WS' => 'Samoa',
    'SM' => 'San Marino',
    'ST' => 'Sao Tome and Principe',
    'SA' => 'Saudi Arabia',
    'SN' => 'Senegal',
    'RS' => 'Serbia',
    'SC' => 'Seychelles',
    'SL' => 'Sierra Leone',
    'SG' => 'Singapore',
    'SX' => 'Sint Maarten',
    'SK' => 'Slovakia',
    'SI' => 'Slovenia',
    'SB' => 'Solomon Islands',
    'SO' => 'Somalia',
    'ZA' => 'South Africa',
    'GS' => 'South Georgia and the South Sandwich Islands',
    'KR' => 'South Korea',
    'SS' => 'South Sudan',
    'ES' => 'Spain',
    'LK' => 'Sri Lanka',
    'SD' => 'Sudan',
    'SR' => 'Suriname',
    'SJ' => 'Svalbard and Jan Mayen',
    'SZ' => 'Swaziland',
    'SE' => 'Sweden',
    'CH' => 'Switzerland',
    'SY' => 'Syria',
    'TW' => 'Taiwan',
    'TJ' => 'Tajikistan',
    'TZ' => 'Tanzania',
    'TH' => 'Thailand',
    'TG' => 'Togo',
    'TK' => 'Tokelau',
    'TO' => 'Tonga',
    'TT' => 'Trinidad and Tobago',
    'TN' => 'Tunisia',
    'TR' => 'Turkey',
    'TM' => 'Turkmenistan',
    'TC' => 'Turks and Caicos Islands',
    'TV' => 'Tuvalu',
    'VI' => 'U.S. Virgin Islands',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'AE' => 'United Arab Emirates',
    'GB' => 'United Kingdom',
    'US' => 'United States',
    'UM' => 'United States Minor Outlying Islands',
    'UY' => 'Uruguay',
    'UZ' => 'Uzbekistan',
    'VU' => 'Vanuatu',
    'VA' => 'Vatican',
    'VE' => 'Venezuela',
    'VN' => 'Vietnam',
    'WF' => 'Wallis and Futuna',
    'EH' => 'Western Sahara',
    'YE' => 'Yemen',
    'ZM' => 'Zambia',
    'ZW' => 'Zimbabwe',
    );
    return $list_of_countries;
}

?>