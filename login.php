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
       
     if (isset($_POST['user']) && isset($_POST['realpwd']) && Functions::checkSimpleText($_POST['user']) && Functions::checkSHA($_POST['realpwd'])) {
     
            if (isset ($_GET['action']) && $_GET['action'] == 'logout') {
                  session_regenerate_id();
                  session_destroy();
                  exit();
            }
     
            $user = new LoginItem();
            $user->setUser($_POST['user']);
            $user->setPass($_POST['realpwd']);
            $users = $db->find($user, new LoginTable());
            if (count($users)!==1) {
                  echo getIntText("login_fail");
                  exit();
            }
            
            $_SESSION['user_id'] = $users[0]->getId();
            $_SESSION['user'] = $users[0]->getUser();
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                    
            header("Location: index.php");
            
     } else {
      ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="it">
    <head>
            <title>bolledisapone</title>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <script type="text/javascript" src="js/sha.js"></script>
            <script type="text/javascript" src="js/validate.js"></script>
            <script type="text/javascript">
                  function cryptPass(pass) {
                  document.getElementById('realpwd').value = SHA1(pass);
                  document.getElementById('pass').value = "";
                  }

                  function validate() {
                  var mail = document.getElementById('user').value;
                  var pass = document.getElementById('pass').value;
                  if (mail != "" && pass != "" && validateUser(mail)) {
                        cryptPass(pass);
                        return true;
                  }
                  return false;
                  }
            </script>
    </head>
    <body>
            <form id="login" action="login.php" method="POST" onsubmit="return validate();">
                  <input name="user" id="user" type="text"></input>
                  <input name="pass" id="pass" type="password"></input>
                  <input name="realpwd" id="realpwd" type="hidden" value=""></input>
                  <input name="loginB" id="loginB" type="submit"></input>
            </form>
      </body>
</html>
      <?php
     }

?>
