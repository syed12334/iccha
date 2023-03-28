<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function app_url(){
    return str_replace('icchhaadmin/','',base_url());
}

function app_asset_url(){
    return str_replace('icchhaadmin/','',base_url()).'assets/';
}

function card_asset_url(){
    return str_replace('icchhaadmin/','',base_url()).'assets/';
 }

function asset_url(){
   return base_url().'assets/';
}

if (!function_exists('sqftEncrypt')) {   
function icchaEncrypt($string) {        
        $secret_key = 'iccha';
        $secret_iv = 'icchav1';  
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );        
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        return $output;
    }
}

if (!function_exists('sqftDcrypt')) {   
    function icchaDcrypt($string) {     
        $secret_key = 'iccha';
        $secret_iv = 'icchav1';   
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );    
        return $output;
    }
}

function convert_number_to_words($number) {
    
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ' ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}

function encode($str)
{
    
    $ci =& get_instance();
    
    if($ci->config->item('skip_encode_decode')==true)
    {
        return $str;
    }else{
        $ci->load->library('encryption');

        $params['cipher'] = 'aes-256';
        $params['mode']   = 'ctr';
        $params['key']    = $ci->config->item('encryption_key');
        
        $ci->encryption->initialize($params);
        
        $encrypted = $ci->encryption->encrypt($str);    
        return base64_encode($encrypted);
    }
}

function decode($str)
{
    $ci =& get_instance();
    if($ci->config->item('skip_encode_decode')==true)
    {
        return $str;
    }else{
        $ci->load->library('encryption');

        $params['cipher'] = 'aes-256';
        $params['mode']   = 'ctr';
        $params['key']    = $ci->config->item('encryption_key');
        
        $ci->encryption->initialize($params);

        return $ci->encryption->decrypt(base64_decode($str));
    }
}

?>