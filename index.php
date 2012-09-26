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
      } else {
	    header("Location: list_spese.php?action=list");
      }
?>
