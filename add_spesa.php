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

      if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']) || !isset($_SESSION['ip']) || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
            header("Location: login.php");
      }
      
      if(isset($_POST['value']) && isset($_POST['desc']) && Functions::checkFloat($_POST['value']) && Functions::checkText($_POST['desc']) ) {
            $spesa = new SpesaItem();
            $spesa->setIdUser($_SESSION['user_id']); $spesa->setValue($_POST['value']); $spesa->setDesc($_POST['desc']);

            if (isset($_POST['gruppo']) && $_POST['gruppo'] == "yes" && isset($_POST['id_gruppo']) && Functions::checkInt($_POST['id_gruppo'])) {
	    	$spesa->setType("gruppo"); $spesa->setGruppo($_POST['id_gruppo']);
	    } 
	 	
            $db->insert($spesa, new SpeseTable());
            header("Location: list_spese.php");
            
            $users = $db->listAll(new LoginItem(), new LoginTable());
            
            foreach ($users as $user)
                  Functions::mail($user->getMail(), getIntText("addspesa_mail_subject"), $_SESSION['user'] . getIntText("addspesa_mail_text1") . $spesa->getValue() . getIntText("addspesa_mail_text2") . $spesa->getDesc() . "\n");
      } else {
  /*    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="it">
    <head>
    <title>bolledisapone</title>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <link rel="stylesheet" type="text/css" href="css/style.css" >
      <script type="text/javascript" language="javascript">
      </script>
      <!--<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
      <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
            <script type="text/javascript" charset="utf-8">
                              jQuery.fn.dataTableExt.aTypes.unshift(
                                        function ( sData )
                                        {
                                                  var Char;
                                                  var bDecimal = false;
                                                  
                                                  if (!sData.match(/^[0-9]{2}[-\/][0-9]{2}[-\/]{1}[0-9]{4}$/)) {
                                                            return null;
                                                  }
                                                  
                                                  return 'data-sorting';
                                        }
                              );
                              
                              jQuery.fn.dataTableExt.oSort['data-sorting-asc']  = function(a,b) {
                                        var arr1 = a.split('/');
                                        var arr2 = b.split('/');
                                        var x = new String(arr1[2] + arr1[1] + arr1[0]);
                                        x = parseInt(x);
                                        var y = new String(arr2[2] + arr2[1] + arr2[0]);
                                        y = parseInt(y);
                                        return ((x < y) ? -1 : ((x > y) ?  1 : 0));
                              };
                              
                              jQuery.fn.dataTableExt.oSort['data-sorting-desc'] = function(a,b) {
                                        var arr1 = a.split('/');
                                        var arr2 = b.split('/');
                                        var x = new String(arr1[2] + arr1[1] + arr1[0]);
                                        x = parseInt(x);
                                        var y = new String(arr2[2] + arr2[1] + arr2[0]);
                                        y = parseInt(y);
                                        return ((x < y) ?  1 : ((x > y) ? -1 : 0));
                              };
                              
                              $(document).ready(function() {
                    $('#dataTable').dataTable( {
                        "sPaginationType": "full_numbers"
                      } );
                } );
                    </script>-->

  </head>
  <body>
        <div id="menu"> <ul><li><a href="list_spese.php?action=list"><?php echo getIntText("menu_list"); ?></a></li>
                        <li><a href="list_spese.php?action=user"><?php echo getIntText("menu_user"); ?></a></li>
                        <li><a href="list_spese.php?action=month"><?php echo getIntText("menu_month"); ?></a></li>
                        <li><a href="add_spesa.php"><?php echo getIntText("menu_addspesa"); ?></a></li>
                        <li><a href="login.php?action=logout"><?php echo getIntText("menu_logout"); ?></a></li></ul>
      </div>
*/

	include "includes/header.inc.php";
?>
      <form action="add_spesa.php" method="POST" id="form1" onsubmit="return correct();">
            <input type="hidden" id="user" name="user" value="<?php echo $_SESSION['user_id']; ?>"></input>
            <label for="value"><?php echo getIntText("addspesa_value"); ?></label><input type="text" id="value" name="value"></input><br />
            <label for="desc"><?php echo getIntText("addspesa_desc"); ?></label><input type="text" id="desc" name="desc"></input><br />
	    <?php echo getIntText("addspesa_gruppo"); ?><input type="radio" name="gruppo" value="no" checked="checked"><?php echo getIntText("addspesa_gruppo_all"); ?></input>
	    <input type="radio" name="gruppo" value="yes"><?php echo getIntText("addspesa_gruppo_restricted"); ?></input><br />
	    <select name="id_gruppo">
		<option value="1">K-G</option>
		<option value="2">K-P</option>
		<option value="3">P-G</option>
	    </select><br />
            <input type="submit" value="<?php echo getIntText("addspesa_submit"); ?>"></input>
      </form>
<?php
	include("includes/footer.inc.php");
      }
?>
