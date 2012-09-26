<?php

//	if (!isset($_SESSION['language']))
//	{
//		session_start();
//	}
     
  //   	if (isset($_GET['lang']) && strlen($_GET['lang']) == 2) 
//	{      
//		$_SESSION['ch_lang']=true;
//	       	$_SESSION['language'] = $_GET['lang'];
  //       	header("Location: " . $_SERVER['HTTP_REFERER']);
    // 	}

	if (!function_exists("existsLangKey")) 
	{
		function existsLangKey($class, $key) 
		{
			try 
			{
				$reflector = new ReflectionClass($class);
				$reflector->getProperty($key);
				return true;
			} 
			catch (Exception $e) 
			{
				return false;
			}
		}
	}
	if (!function_exists("getIntText")) 
	{
		function getIntText($label, $noHTML=FALSE) 
		{
			global $LANGUAGE; 
            
			if ($label == "")
				return "NoLABEL";

//			if (isset ($_SESSION['language']))
//				$LANGUAGE = trim($_SESSION['language']);

//			if (isset($LANGUAGE)) 
//			{
				try 
				{
					if($LANGUAGE == 'it') 
					{
    						if (existsLangKey('MessagesIt', $label)===true)
    				    			return MessagesIt::getText($label);
    						else 
	                    				return $label;
    				
					} 
					else if($LANGUAGE == 'en') 
					{
        					if (existsLangKey('MessagesEn', $label)===true)
        						return MessagesEn::getText($label);
        					else
							return $label;
					} 
					else if($LANGUAGE == 'fr') 
					{
						if (existsLangKey('MessagesFr', $label)) {
							$text = MessagesFr::getText($label);
							if ($noHTML===FALSE) {
								$text = htmlentities($text, ENT_NOQUOTES, "UTF-8");
								$text = str_replace("&lt;", "<", $text);
								$text = str_replace("&gt;", ">", $text);
								$text = str_replace("'", "&#039;", $text);
							}
							return $text;
						} 
						else
							return $label;
					} 
					else 
				/*	{

        					if (existsLangKey('MessagesIt', $label)===true)
        						return MessagesIt::getText($label);
        					else
        					{*/
                               
						//return $label;
	                    			return $LANGUAGE.$label;
                                   
                        	/*		}
               		        	}*/
				} 
				catch (Exception $e) 
				{
					return "NoLABEL";
				}
//			} 
//			else 
//			{

    			/*	try {
        				if (existsLangKey('MessagesIt', $label)===true)
        			     		return MessagesIt::getText($label);
        				else*/
  //      			     		return $label;
        		/*	} catch (Exception $e) {
        				return "NoLABEL";
	        		}*/
//			}

		}
	}

//************************* ITALIANO ************************************

	if (!class_exists("MessagesIt")){
    class MessagesIt {
    
      public static $menu_list = "Tutte le spese";
      public static $menu_user = "Proprie spese";
      public static $menu_month = "Statistiche";
      public static $menu_addspesa = "Aggiungi spesa";
      public static $menu_logout = "Logout";
 
      public static $addspesa_mail_subject = "Aggiunta nuova spesa";
      public static $addspesa_mail_text1 = " ha aggiunto una nuova spesa di ";
      public static $addspesa_mail_text2 = " per ";
      public static $addspesa_confirm = "Vuoi inserire una nuova spesa di ";
      public static $addspesa_value = "Valore: ";
      public static $addspesa_desc = "Descrizione: ";
      public static $addspesa_gruppo = "Spesa di ";
      public static $addspesa_gruppo_all = "tutti";
      public static $addspesa_gruppo_restricted = "gruppo ristretto";
      public static $addspesa_submit = "Inserisci"; 

      public static $login_fail = "Login fallito!";
           
      public static $listspese_confirm = "Vuoi saldare le tue spese?"; 
      public static $listspese_total = "Totale: ";
      public static $listspese_person = "€ (A testa: ";	
      public static $listspese_value = "€)<br />";	
      public static $listspese_group = "Gruppi: ";	
      public static $listspese_expensesfor = "Spese per ";	
      public static $listspese_givehave = "€ (Dare/Avere: ";	
      public static $listspese_settle = "Salda proprie spese";	
      public static $listspese_settlegroup = "Salda proprie spese per i gruppi";	
      public static $listspese_monthtotal = "Totale spese mese di ";	
      public static $listspese_yeartotal = "Totale anno: ";	
      public static $listspese_yeartotalperson = "Totale anno per persona: ";	
      public static $listspese_averagemonth = "Media mese: ";	
      public static $listspese_averagemonthperson = "Media mese per persona: ";	
      public static $listspese_expensesmonthyear = "Spese per mese dell'anno ";	
      public static $listspese_insertmonth = "Inserire il mese nel formato yyyy-mm: ";	
      public static $listspese_insertyear = "Inserire l'anno nel formato yyyy: ";	

      public static function getText($varName) {
	       return self::$$varName;
      }
    }
}
  
//************************* ENGLISH ************************************   
    
    if (!class_exists("MessagesEn")) {
    class MessagesEn {
    
      public static $contatti_invio_fallimento = "Si è verificato un errore nell'invio.";
    
      public static function getText($varName) {
	    return self::$$varName;

      }
    }
}

//************************* FRANCAIS ************************************


 if (!class_exists("MessagesFr")) {   
  class MessagesFr {
  
 
        
      public static function getText($varName) {
	    return self::$$varName;

      }
    }
}
?>
