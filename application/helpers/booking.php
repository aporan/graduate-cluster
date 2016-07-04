<?php

function createBooking($input, $user){
    $page_one_details = Session::get('pageone_details');
    $page_two_details = Session::get('pagetwo_details');

    $nationality = findCountry($page_one_details['nation']);
    $firstname = strtolower(trim($page_one_details['studfirst']));
    $lastname = strtolower(trim($page_one_details['studlast']));
    $mobile = trim($page_two_details['studmob']);
    $email = trim($page_two_details['studemail']);

    Booking::Create(array(
        'first_name' => $firstname,
        'last_name'  => $lastname,
        'email'      => $email,
        'mobile'     => $mobile,
        'sex'        => $page_one_details['gender'],
        'gov_identifier' => $page_two_details['studgov'],
        'pillar'       => $page_one_details['pillar'],
        'category'     => $page_one_details['studtyp'],
        'booking_from' => $page_two_details['bookfro'],
        'booking_till' => $page_two_details['booktill'],
        'nationality'  => $nationality,
        'user_id'   => $user->id,
        'cluster_id'   => $page_two_details['cluster'],
        'seat_id'      => $input['seat']
    ));
    updateSeatAvailability($input['seat']);
    checkSession('pageone_details');
    checkSession('pagetwo_details');
    
}

function updateBooking($input){
    $booking_id = $input['booking'];

    $firstname = strtolower(trim($input['studfirst']));
    $lastname = strtolower(trim($input['studlast']));
    
    Booking::update($booking_id, array(
        'first_name'    =>$firstname,
        'last_name'     =>$lastname,
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
    #TODO: Update Available Seats
    $this_seat = ClusterSeat::find($seat_id);
    $this_seat->available = 0;
    $this_seat->save();
}

function getClusterName($id){
    $this_cluster = Cluster::find($id);
    return $this_cluster->cluster_name;
}

function isAdmin() {
    $current_user = Auth::user();
    $user_type = $current_user->type;
    $is_admin = ($user_type == 'admin') ? True : False;
    return $is_admin;
}

function getUserCluster($user_id) {
    $assigned_clusters = DB::table('cluster_seats')
        ->distinct()
        ->join('seat_managers', 'cluster_seats.id', '=', 'seat_managers.seat_id')
        ->where('seat_managers.user_id', '=', $user_id)
        ->order_by('cluster_id')
        ->get(array('cluster_id'));
    
    $clusters = array();
    
    foreach($assigned_clusters as $cluster) {
        $id = $cluster->cluster_id;
        $clusters[$id] = Cluster::find($id)->name;
    }

    return $clusters;
}

function getUserSeats($user_id, $cluster_id) {
    $assigned_seats = DB::table('cluster_seats')
        ->join('seat_managers', 'cluster_seats.id', '=', 'seat_managers.seat_id')
        ->where('seat_managers.user_id', '=', $user_id)
        ->where('cluster_seats.cluster_id', '=', $cluster_id)
        ->where('cluster_seats.available', '=', 1)
        ->get(array('cluster_seats.number', 'cluster_seats.id'));
        
    $seats = array();

    foreach($assigned_seats as $seat) {
        $id = $seat->id;
        $seats[$id] = $seat->number;
    }

    return $seats;
}

function findCountry($country_code) {
    $countries_array = listOfCountries();
    return $countries_array[$country_code];
}

function listOfCountries(){
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