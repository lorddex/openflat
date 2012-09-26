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

class MySQLQuery {
    
      //QUERY GENERICHE --------------------------------------------------------------------------------------------------------------------------------
      public static function TableFindID($tableName, $item) { return "SELECT * FROM $tableName WHERE id = ". $item->getId() . " LIMIT 1;"; }
      public static function TableDeleteItem($tableName, $item) { return "DELETE FROM $tableName WHERE id = " . $item->getId() . " LIMIT 1;"; }
      public static function TableListAll($tableName, $groupBy, $orderBy) {
	$toRet = "SELECT * FROM $tableName";
	
	if ($orderBy != "")
	  $toRet .= " GROUP BY $groupBy ";
	if ($groupBy != "")
	  $toRet .= " ORDER BY $orderBy ";
	$toRet .= ";";
	return $toRet;
      }
      
      //QUERY TABELLA LOGIN! --------------------------------------------------------------------------------------------------------------------------------
      public static function loginTableCreate($tableName) { 
          return "CREATE TABLE `$tableName` (
            `id` int(11) NOT NULL auto_increment,
            `user` varchar(50) NOT NULL,
            `pass` char(40) NOT NULL,
            PRIMARY KEY  (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
            "; }
      public static function loginTableDrop($tableName) { return "DROP TABLE $tableName;"; }
      public static function loginTableInsert($tableName, $item) { 
          return "INSERT INTO $tableName (user, pass, mail) VALUES ('".$item->getUser()."', '".$item->getPass()."', '".$item->getMail()."');"; }
      public static function loginTableFind($tableName, $item) {    
          $others=false;
          $toRet = "SELECT * FROM $tableName WHERE ";

            if ($item->getUser()!="") {
              $toRet .= "user = '" . $item->getUser() . "' "; 
              $others = true;
            }
            if ($item->getPass()!="") {
              if ($others == true) { $toRet .= "AND "; }
              $toRet .= "pass = '" . $item->getPass() . "' "; 
              $others = true;
            }
            if ($item->getMail()!="") {
              if ($others == true) { $toRet .= "AND "; }
              $toRet .= "mail = '" . $item->getMail() . "' "; 
              $others = true;
            }
            
            if ($item->groupBy()!="")
              $toRet .= " GROUP BY ". $item->groupBy();
            if ($item->orderBy() != "")
              $toRet .= " ORDER BY ". $item->orderBy();

          $toRet .= ";";
          return $toRet;
      }   
      public static function loginTableEdit($tableName, $item) {    
          if($item->getId()==-1)
            throw new Exception("L'oggetto da modificare deve avere un ID.");

          $toRet = "UPDATE $tableName SET ";
          $others=false;
          if ($item->getUser()!="") {
            $toRet .= "user = '" . $item->getUser() . "' ";
            $others = true;
          }
          if ($item->getPass()!="") {
            if ($others == true) { $toRet .= ", "; }
            $toRet .= "pass = '" . $item->getPass() . "' ";
            $others = true;
          }
          if ($item->getMail()!="") {
            if ($others == true) { $toRet .= ", "; }
            $toRet .= "mail = '" . $item->getMail() . "' ";
            $others = true;
          }
          
          $toRet .= " WHERE id = ".$item->getId().";";
          return $toRet;
      }
      
      
      //QUERY TABELLA SPESE! --------------------------------------------------------------------------------------------------------------------------------
      public static function speseTableCreate($tableName) { 
          return "CREATE TABLE `$tableName` (
            `id` int(11) NOT NULL auto_increment,
            `id_user` int(11) NOT NULL,
            `date` timestamp NOT NULL default CURRENT_TIMESTAMP,
            `value` float NOT NULL,
            `desc` varchar(300) default NULL,
            PRIMARY KEY  (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
            "; 
      }

      public static function speseListAll($tableName, $groupBy, $orderBy) {
          $toRet = "SELECT `id`, `id_user`, DATE_FORMAT(DATE(`date`), \"%d/%m/%Y\") AS date, `value`, `state`, `desc`, `type`, `gruppo` FROM $tableName "; //WHERE `type` = 'singola'
          if ($orderBy != "")
            $toRet .= " GROUP BY $orderBy ";
          if ($groupBy != "")
            $toRet .= " ORDER BY $groupBy ";
          $toRet .= ";";
          return $toRet;
      }

      public static function speseTableDrop($tableName) { return "DROP TABLE $tableName;"; }
      public static function speseTableInsert($tableName, $item) { 
          return "INSERT INTO $tableName (id_user, value, `state`, `desc`, `type`, `gruppo`) VALUES (".$item->getIdUser().", ".$item->getValue().", ".$item->getState().", '".$item->getDesc()."', '".$item->getType()."', 
".$item->getGruppo().");"; }
      public static function speseTableFind($tableName, $item) {    
          $others=false;
          $toRet = "SELECT `id`, `id_user`, DATE_FORMAT(DATE(`date`), \"%d/%m/%Y\"), `value`, `state`, `desc`, `type`, `gruppo` FROM $tableName WHERE ";

            if ($item->getIdUser()!=-1) {
              $toRet .= "id_user = " . $item->getIdUser() . " "; 
              $others = true;
            }
            if ($item->getDate()!="") {
              if ($others == true) { $toRet .= "AND "; }
              $toRet .= "date = '" . $item->getDate() . "' "; 
              $others = true;
            }
            if ($item->getValue()!=-1) {
              if ($others == true) { $toRet .= "AND "; }
              $toRet .= "value = '" . $item->getValue() . "' "; 
              $others = true;
            }
            if ($item->getState()==1) {
              if ($others == true) { $toRet .= "AND "; }
              $toRet .= "state = '" . $item->getState() . "' "; 
              $others = true;
            }
            if ($item->getDesc()!="") {
              if ($others == true) { $toRet .= "AND "; }
              $toRet .= "`desc` = '" . $item->getDesc() . "' "; 
              $others = true;
            }
	    if ($item->getType()!="") {	
	      if ($others == true) { $toRet .= "AND "; }
	      $toRet .= "`type` = '" . $item->getType() . "' ";
              $others = true;
	    }
            if ($item->groupBy()!="")
              $toRet .= " GROUP BY ". $item->groupBy();
            if ($item->orderBy() != "")
              $toRet .= " ORDER BY ". $item->orderBy();

          $toRet .= ";";
          return $toRet;
      }   
      public static function speseTableEdit($tableName, $item) {    
          if($item->getId()==-1)
            throw new Exception("L'oggetto da modificare deve avere un ID.");

          $toRet = "UPDATE $tableName SET ";
          $others=false;
          if ($item->getIdUser()!=-1) {
              $toRet .= "id_user = " . $item->getIdUser() . " "; 
              $others = true;
            }
            if ($item->getValue()!=-1) {
              if ($others == true) { $toRet .= ", "; }
              $toRet .= "value = " . $item->getValue() . " "; 
              $others = true;
            }
             if ($item->getState()==1 || $item->getState() == 0) {
              if ($others == true) { $toRet .= ", "; }
              $toRet .= "state = " . $item->getState() . " "; 
              $others = true;
            }
            if ($item->getDesc()!="") {
              if ($others == true) { $toRet .= ", "; }
              $toRet .= "`desc` = '" . $item->getDesc() . "' "; 
              $others = true;
            }
          $toRet .= " WHERE id = ".$item->getId().";";
          return $toRet;
      }

    public static function spesePerGroup($tableName, $item) {
	   $query = "SELECT SUM(value) AS totale FROM $tableName WHERE state = 1 AND `type` = 'gruppo' AND `gruppo` = " . $item;
	   return $query;
    }
      
    public static function spesePerGroupPerUser($tableName, $item, $id_user) {
        $query = "SELECT SUM(value) AS totale FROM $tableName WHERE state = 1 AND `type` = 'gruppo' AND `gruppo` = " . $item. " AND `id_user` = ". $id_user;
        return $query;
    }

    public static function membersGroup($tableName, $item) {
        $query = "SELECT `id_a`, `id_b` FROM $tableName WHERE `id` = " . $item;
        return $query;
    }

    public static function memberName($tableName, $item) {
        $query = "SELECT `user` FROM $tableName WHERE `id` = " . $item;
        return $query;
    }

      public static function gruppoPerUser($tableName, $item) {
	$query = "SELECT * FROM $tableName WHERE `id_a` = ".$item->getId()." OR `id_b` = " . $item->getId();
	return $query;
      }

      public static function speseTableTotale ($tableName, $item) {
            $toRet = "SELECT SUM(value) AS totale FROM `$tableName` WHERE state = 1 AND `type`='singola'";
            if ($item->getIdUser() != -1)
                  $toRet .= "AND id_user = " . $item->getIdUser();
            $toRet .= ";";
            return $toRet;
      }
      
      public static function speseMese ($tableName, $item) {
          $toRet = "SELECT SUM(value) as totale FROM `spese` WHERE `date` LIKE '$item%' AND `type`='singola'";
          return $toRet;
      }
      
      public static function speseTableSalda ($tableName, $item) { 
            if ($item->getIdUser() != -1)
                  return "UPDATE `$tableName` SET `state` = 0 WHERE id_user = " . $item->getIdUser() . " AND `type`='singola';";
      }
       public static function speseTableSaldaGruppo ($tableName, $item) { 
            if ($item->getIdUser() != -1)
                  return "UPDATE `$tableName` SET `state` = 0 WHERE id_user = " . $item->getIdUser() . " AND `type`='gruppo';";
      }
     
      
      // FINE QUERY ------------------------------------------------------------------------------------------------------------------------------------
    }

?>
