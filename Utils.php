<?php
namespace Mpm\Utils;

class Utils {
  
  /**
   * Truncates the string to a given length and pads the string with '...' by default.
   * 
   * @param string $string 
   * @param int $limit 
   * @param string $pad 
   * @return string
   */
  public static function truncate($string, $limit, $pad = "...")
  {
    if(strlen($string) <= $limit){
      return $string;
    } else {
        $string = substr($string,0 ,$limit) . $pad;
      return $string;
    }
  }
  
  /**
   * Quotes string with single quotes '<value>' . 
   * 
   * Generally Used to store data in database because datebase values needs to be quoted 
   * 
   * @param string $value
   * @return string 
   */
  public static function quote($value,$escape_null=true){
    return ($escape_null && is_null($value))?"null":"'".$value."'";
  }
  
  /**
   * Takes Two-Dimensional array and If there is any json value is the array , decodes it and returns modified array .
   * 
   * Eg. in db_read() , Actually we store php array in database as JSON string that needed to decoded again in array .
   * 
   * @param array $data 
   * @return array 
   */
  public static function normalize(array $data){
    foreach($data as &$array){
     $array = self::normalize_one($array);//Normalize One-dimensional Array
    }
    unset($array);
    return $data;
  }
  
  /**
   * Gets array and If there is any json value is the array , decodes it and returns modified array .
   * 
   * @param array $data 
   * @return array 
   */
  public static function normalize_one(array $data){
    foreach($data as &$value){
       $value = self::json_safe($value); 
    }
    unset($value);
    return $data;
  }
  
  /**
   * Check whether password string is a valid json  , If is a json string .
   * 
   * @param $string 
   * @return string
   */
  public static function json_safe($string){
      return self::is_json($string)?json_decode($string):$string;
  }
  
  /**
   * Check whether passed string is a valid json  or or not 
   * Return true if string is a valid json.
   * 
   * @param string $string
   * @return bool 
   */
  public static function is_json($string){
      if(is_null($string)) return false;
      $data = json_decode($string,true);
      return (json_last_error() == JSON_ERROR_NONE) ?TRUE : FALSE;
  }
  
  public static function get_safe($string,$default=''){
    return isset($string)?$string:$default;
  }
}