<?php

if (!function_exists('get_user')) {

    function get_user($id = '') {
        $CI = & get_instance();
        $user = new stdClass();
        $user->id = 0;
        if ($CI->session->userdata('user'))
            $user = $CI->session->userdata('user');
        return $user;
    }

}

function pre($data, $exit = false)
{
    echo "<br />";
    print_r($data);
    if(!$exit)
        die();
}if(!function_exists('get_country_flag')){			function get_country_flag($country_code=''){		$flag=getField("code2","country","Code",$country_code);		$flag =  strtolower($flag).".svg";		$flag_file = ASSETS.'images/flags/'.$flag;		return $flag_file;			}	}if(!function_exists('get_user_rate')){			function get_user_rate($user_id=''){		$u_row = get_row(array('select' => 'rate_type,rate_currency,hourly_rate', 'from' => 'user', 'where' => array('user_id' => $user_id)));		$rate = $currency = $rate_type = '';		if($u_row['rate_currency']){			$currency = get_currency_icon($u_row['rate_currency']);		}		if($u_row['rate_type']){			$rate_type = get_short_rate_type($u_row['rate_type']);		}		$hourly_rate = round($u_row['hourly_rate'], 2);		$rate = $currency.$hourly_rate.$rate_type;				return $rate;	}	}