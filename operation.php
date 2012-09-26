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

      require("includes/Includes.inc.php");

      $db = new MySqlDatabase();
      $db->connect();

      if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']) || !isset($_SESSION['ip']) || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
            header("Location: login.php");
      }
      
      if(isset($_GET['action']) && $_GET['action'] != "") {
            $action = $_GET['action'];
            if ($action == 'salda') {
                  $table = new SpeseTable();
                  $spesa = new SpesaItem(); $spesa->setIdUser($_SESSION['user_id']);
                  $values = $db->find($spesa, $table);
                  foreach ($values as $value) {
                        $value->setState(0); 
                        $db->modify($value, $table);
                  } 
                  
//                   $users = $db->listAll(new LoginItem(), new LoginTable());
//                   foreach ($users as $user)
//                         Functions::mail($user->getMail(), "Aggiunta nuova spesa", $_SESSION['user'] . " ha aggiunto una nuova spesa di " . $spesa->getValue() . " per " . $spesa->getDesc() . "\n");

                  header("Location: list_spese.php");
            } else if ($action == 'saldaGruppi') {
                  $table = new SpeseTable();
                  $spesa = new SpesaItem(); $spesa->setIdUser($_SESSION['user_id']); $spesa->setType("gruppo");
		  $values = $db->find($spesa, $table);
		  //print_r($values);
		  //echo MySQLQuery::speseTableFind("spese", $spesa);
                  foreach ($values as $value) {
                        $value->setState(0); 
                        $db->modify($value, $table);
                  } 
                  
//                   $users = $db->listAll(new LoginItem(), new LoginTable());
//                   foreach ($users as $user)
//                         Functions::mail($user->getMail(), "Aggiunta nuova spesa", $_SESSION['user'] . " ha aggiunto una nuova spesa di " . $spesa->getValue() . " per " . $spesa->getDesc() . "\n");

                  header("Location: list_spese.php");
            }
           
         
      } else {
            header("Location: index.php");
      }
      
?>
