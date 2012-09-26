<?php

/*                                         
    
    Copyright 2012 - Francesco Apollonio (f.apollonio@ldlabs.org)        
                     
    This file is part of FlatManager. 
                                                                                                   
    FlatManager is free software: you can redistribute it and/or modify 
    it under the terms of the GNU General Public License as published by 
    the Free Software Foundation, either version 3 of the License, or 
    (at your option) any later version.                                                            
                                     
    FlatManager is distributed in the hope that it will be useful,                                 
    but WITHOUT ANY WARRANTY; without even the implied warranty of 
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                  
    GNU General Public License for more details.                                  
              
    You should have received a copy of the GNU General Public License 
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>. 
*/

  class Functions {

    public static $DEBUG = true;

    public static function getLabel($key) {
    
     $keys = array (
       'cod_biglietto' => "n. ticket",
       'data_viaggio' => "data viaggio",
       'data_p' => "data pren.",
       'ora_p' => "ora pren.",
       'tel' => "telefono",
       'ora_partenza' => "orario",
       'ora_destinazione' => "orario",
       'n_posti' => "pax",
       'bagagli_extra' => "bag",
       'costo' => 'prezzo',
       'operazioni' => 'OP',
       'id_sconto' => 'sc',
       'percentuale' => 'perc.',
       'validita' => "val.",
       'max_posti' => "M. PAX",
       'carta' => "Carta di credito"
     );
     
     return array_key_exists($key, $keys)?$keys[$key]:$key;
     
    }
    
    public static function addFieldToText($text, $array) {
	
		foreach (array_keys($array) as $field) {
		
			$text = str_replace("%".$field, $array[$field], $text );
			
		}
	
		return $text;
	
    }

      public static function mail ($to, $subject, $text, $email="from@address.com") {
      
	      $Name = "Mr. Senders"; //senders name
	      $recipient = $to; //recipient
	      $mail_body = $text; //mail body
	      $subject = $subject; //subject
	      $header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields

	      mail($recipient, $subject, $mail_body, $header); //mail command :)
      
      }
	
    public static function debug($text, $script, $enabled="true"){

      if (self::$DEBUG){
	if($nabled)
	  echo "[DEBUG] $script: $text<br>";
          $fp = fopen("debug.txt", "a+");
          fwrite($fp,  "[".date("d-m-Y H:i:s") ."] $script : " . $text . "\n");
          fclose($fp);
      }
      
    }
    
    public static function mecho($text) {
      echo $text . "<br>";
    }

    // Date Permesse 2001-12-23 e 03/05/1986
    public static function checkData($date) {
     if ( preg_match('/^[0-9]{2}[-\/][0-9]{2}[-\/]{1}[0-9]{4}$/', trim($date)) == 1)
	return true;
     else if (preg_match('/^[0-9]{4}[-\/]{1}[0-9]{2}[-\/][0-9]{2}$/', trim($date)) == 1)
	return true;
     else 
	return false;
    }

    public static function checkHour($hour) {
      if (preg_match('/^[0-9]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$/', trim($hour)) == 1 || preg_match('/^[0-2]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}$/', trim($hour)) == 1)
	return true;
      else
	return false;
    }
     
    public static function checkText($text) {
      if (preg_match('/^[a-zA-z0-9\-\.\/:,()" ;?!€=*@\'\\òàèéùì]{0,}$/', trim($text)) == 1) {
//      echo $text;
                  $db = new MySqlDatabase();
                  $db->connect();
                  $toRet = $db->add_slashes($text);      
//                   echo $toRet;
	return $toRet;
      } else
	return false;
    }

    public static function checkFloat($number) {
    if (is_float($number)) {
	return (float) $number;
    } else if ( is_int($number)) {
	return (float) $number;
    } else if (is_string($number) && preg_match('/^[0-9]{1,}\.{0,1}[0-9]{0,}$/', trim($number)) == 1)
	return floatval($number);
    else
	return false;
    }

    public static function checkInt($number) {
      if (is_int($number))
	return $number;
      else if (is_string($number) && preg_match('/^[0-9]{1,}$/', trim($number)) == 1)
	return intval($number);
      else
	return false;
    }

    public static function checkIp($ip) {
      if (preg_match('/^[0-9]{1,3}[\.]{1}[0-9]{1,3}[\.]{1}[0-9]{1,3}[\.]{1}[0-9]{1,3}$/', trim($ip)) == 1)
	return true;
      else
	return false;
    }

    public static function checkCodiceSconto($code) {
      if (preg_match('/^[0-9]{10}$/', trim($code)) == 1)
	return true;
      else
	return false;
    }

    public static function checkTimeStamp($ts) {
      if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', trim($ts)) == 1)
	return true;
      else
	return false;
    }

    public static function checkMail($mail) {
      if (preg_match('/^[a-zA-Z0-9_.-]{1,}@[a-zA-Z0-9.-]{1,}\.[A-Za-z]{2,6}$/', trim($mail)) == 1)
	return true;
      else
	return false;
    }

    public static function checkSHA($sha) {
        if (preg_match('/^[a-zA-Z0-9]{40,41}$/', trim($sha)) == 1)
	return true;
      else
	return false;
    }

    public static function convertDateToDB($value, $separatore='/') {
     if ( preg_match('/^[0-9]{2}[-\/][0-9]{2}[-\/]{1}[0-9]{4}$/', trim($value)) == 1) {
      list($day,$month,$year)=explode($separatore,$value);
      $res_arr=array();
      $res_arr[]=$year;
      $res_arr[]=$month;
      $res_arr[]=$day;
      $result=implode("-",$res_arr);
      return $result;
     } else if (preg_match('/^[0-9]{4}[-\/]{1}[0-9]{2}[-\/][0-9]{2}$/', trim($value)) == 1) {
	return $value;
     } else 
	return false;
     }

     public static function convertHoursFromDB($value, $separatore=":") {
         
            if ( preg_match("/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/", trim($value)) == 1 ) {
                  list($h,$m,$s) = explode($separatore, $value);
                  if ($s != "01")  
                        return $h . ":" . $m;
                  else
                        return "";
            } else {
                  return false;
            }
     }
     
     public static function getSeconds($value, $separatore=":") {
         
            if ( preg_match("/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/", trim($value)) == 1 ) {
                  list($h,$m,$s) = explode($separatore, $value);
                  return $s;
            } else {
                  return false;
            }
     }

    public static function convertDateFromDB($value, $separatore='/') {
     if ( preg_match('/^[0-9]{4}[-\/][0-9]{2}[-\/]{1}[0-9]{2}$/', trim($value)) == 1) {
      list($year,$month,$day)=explode($separatore,$value);
      $res_arr=array();
      $res_arr[]=$day;
      $res_arr[]=$month;
      $res_arr[]=$year;
      $result=implode("/",$res_arr);
      return $result;
     } else if (preg_match('/^[0-9]{2}[-\/]{1}[0-9]{2}[-\/][0-9]{4}$/', trim($value)) == 1) {
		return $value;
     } else 
		return false;
     }
	 
    public static function checkCFiscale ($value) {
      if ( preg_match('/^[a-zA-Z]{6}[0-9]{2}[a-zA-Z]{1}[0-9]{2}[a-zA-Z0-9]{4}[a-zA-Z]{1}$/', $value) == 1 ||
	   preg_match('/^[0-9]{11}$/', $value) == 1)
	return true;
      else
	return false;
    }

    public static function checkPIva ($value) {
      if ( preg_match('/^[0-9]{11}$/', $value) == 1 )
	return true;
      else
	return false;
    }

     public static function checkCodiceBiglietto ($value) {
      if ( preg_match('/^[A-Z]{2}[0-9]{5}$/', $value) == 1 )
	return true;
      else
	return false;
    }

    public static function checkSimpleText ($value) {
      if ( preg_match('/^[a-zA-Z0-9\ ]{1,}$/', $value) == 1 )
	return true;
      else
	return false;
    }

    public static function checkOnlyChars ($value) {
      if ( preg_match('/^[a-zA-Z]{1,}$/', strtolower($value)) == 1 )
	return true;
      else
	return false;
    }

    public static function checkOnlyNumbers ($value) {
      if ( preg_match('/^[0-9]{1,}$/', $value) == 1 )
	return true;
      else
	return false;
    }

    public static function checkCap ($value) {

      if ( preg_match('/^[0-9]{1,}$/', $value) == 1) 
	return true;
      else
	return false;
    }

  

    public static function testDataP($dataP, $offset=2) {
      list($dayP, $monthP, $yearP) = explode('/', $dataP);
      list($dayT, $monthT, $yearT, $hourT, $minT) = explode('/', date("d/m/Y/H/i"));
      if ($yearP > $yearT)
	return true;
      else if ($yearP == $yearT) {
	if ($monthP > $monthT) 
	  return true;
	else if ($monthP == $monthT) {
	    if ($dayP-$dayT >= $offset)
	      return true;
	    else
	      return false;
	} else
	  return false;
      } else
	return false;
    }

	public static function do_post_request($url, $data, $optional_headers = null) {
     $params = array('http' => array(
                  'method' => 'POST',
                  'content' => $data
               ));
     if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
     }
     $ctx = stream_context_create($params);
     $fp = @fopen($url, 'rb', false, $ctx);
     if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
     }
     $response = @stream_get_contents($fp);
     if ($response === false) {
        throw new Exception("Problem reading data from $url, $php_errormsg");
     }
     return $response;
  }
	
  
  
  public static function identifyAndFormat($string) {
  
     if (is_string($string) && preg_match('/^[0-9]{1,}$/', trim($string)) == 1){
      return number_format($string, 2, ',', '.');
     }
     
     
  }
}
?>
