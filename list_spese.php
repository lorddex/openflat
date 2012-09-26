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
      include "includes/libchart/classes/libchart.php";

    
      $db = new MySqlDatabase();
      $db->connect();
      
      if (!isset($_SESSION['user_id']) || !isset($_SESSION['user']) || !isset($_SESSION['ip']) || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
            header("Location: login.php");
      }
      
      $item=new SpesaItem();
      $item->orderBy("date DESC");
      $values = $db->listAll($item, new SpeseTable("spese"));

      if (isset($_GET['action']) && $_GET['action'] != "") {
      
            $action = $_GET['action'];
      
?>
                  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="it">
    <head>
    <title>bolledisapone</title>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <link rel="stylesheet" type="text/css" href="css/style.css" >
      <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
      <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
            <script type="text/javascript" charset="utf-8">
            
            		      $(document).ready(function() {
				  $('#dataTable').dataTable( {
				    "aaSorting": [[ 2, "desc" ]],
				    "bPaginate": false,
				    "aoColumns": [ null, null, null, null, null, null, null ]
				    } );
				  
			       } );
            		
                              /* jQuery.fn.dataTableExt.aTypes.unshift(
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
                              }; */
                              
                             
                
                function conferma(url){
                      if(confirm("<?php echo getIntText("listspese_confirm"); ?>")==true)
                            document.location=url;
                };
                    </script>

  </head>
  <body> 
      <div id="menu"> 
	<ul>
	  <li><a href="list_spese.php?action=list"><?php echo getIntText("menu_list"); ?></a></li>
          <li><a href="list_spese.php?action=user"><?php echo getIntText("menu_user"); ?></a></li>
          <li><a href="list_spese.php?action=month"><?php echo getIntText("menu_month"); ?></a></li>
          <li><a href="add_spesa.php"><?php echo getIntText("menu_addspesa"); ?></a></li>
          <li><a href="login.php?action=logout"><?php echo getIntText("menu_logout"); ?></a></li>
	</ul>
      </div>
      <div id="resoconto">
<?php
    
            
            if ($action == 'list') { //IF ACTION == LIST
     
                  $table = new SpeseTable();
                  $spesa = new SpesaItem();
                  $users = $db->listAll(new LoginItem(), new LoginTable());
                   
                  $result = $db->directQuery($table->totaleSpese($spesa));
                  $media = $result[0]/count($users);
                  
                  echo "<span>".getIntText("listspese_total")."</span> " . number_format($result[0], 1, ",", ".") . getIntText("listspese_person") . number_format($media, 1, ",", ".") . getIntText("listspese_value");
                    
                  foreach ($users as $user) {
                         $spesa->setIdUser($user->getId());
                         $result = $db->directQuery($table->totaleSpese($spesa));
			             $da = round($result[0] - $media,1); 
                         echo "<span>" . $user->getUser().":</span> " . number_format($result[0], 1, ",", ".") . getIntText("listspese_person").number_format($da, 1, ",", ".").getIntText("listspese_value");
		  }

		  echo "<span>".getIntText("listspese_group")."</span><br />";
		  $groups= $db->directQuery(MySQLQuery::TableListAll("gruppi", "", ""));
		  foreach ($groups as $group) {
			  echo "<span>" . getIntText("listspese_expensesfor"). $group['name']. ":</span> ";
			  $spese_gruppo= $db->directQuery(MySQLQuery::spesePerGroup("spese", $group['id']));
              $membri = $db->directQuery(MySQLQuery::membersGroup("gruppi", $group['id']));
              $group_media=$spese_gruppo[0]/2;
			  echo getIntText("listspese_total") . number_format($spese_gruppo[0], 1, ",", ".") .getIntText("listspese_person").number_format($group_media, 1, ",", ".").getIntText("listspese_value");
			  $parz1=$db->directQuery(MySQLQuery::spesePerGroupPerUser("spese", $group['id'], $membri[0]));
              $parz2=$db->directQuery(MySQLQuery::spesePerGroupPerUser("spese", $group['id'], $membri[1]));
              $name1=$db->directQuery(MySQLQuery::memberName("login", $membri[0]));
              $name2=$db->directQuery(MySQLQuery::memberName("login", $membri[1]));
              echo $name1[0] . ": " . number_format($parz1[0], 1, ",", ".") .getIntText("listspese_givehave").number_format(round($parz1[0] - $group_media,1), 1, ",", ".").")<br />";
              echo $name2[0] . ": " . number_format($parz2[0], 1, ",", ".") .getIntText("listspese_givehave").number_format(round($parz2[0] - $group_media,1), 1, ",", ".").")<br />";
		  }
?>
      </div>
      <div id="table">
      <table id="dataTable">
            <thead>
                  <tr>
<?php

            foreach(array_keys($values[0]->getArray()) as $key)
                  echo "\t\t\t\t<th>$key</th>\n";

?>
                  </tr>
            </thead>
            <tbody>
<?php
       
      foreach($values as $value) {
            echo "\t\t\t<tr>\n";
            
            $array = $value->getArray();
            
            foreach (array_keys($array) as $key) {
                  echo "\t\t\t\t<td>".$array[$key]."</td>\n";
            }
            echo "\t\t\t</tr>\n";
      }

?>
            </tbody>
      </table>

      

<?php

            } // IF ACTION == USER
            else if ($action == 'user') {
            
                  $table = new SpeseTable();
                  $spesa = new SpesaItem(); $spesa->setIdUser($_SESSION['user_id']);
                  $values = $db->find($spesa, $table);

                  $result = $db->directQuery($table->totaleSpese($spesa));
                  echo "<span>".getIntText("listspese_total")."</span> " . number_format($result[0], 2, ",", ".") . "<br />";

	 echo "<a href=\"javascript:conferma('operation.php?action=salda');\">".getIntText("listspese_settle")."</a><br />";
	 echo "<a href=\"javascript:conferma('operation.php?action=saldaGruppi');\">".getIntText("listspese_settlegroup")."</a><br />";
     ?>
      </div>
      <div id="table"><table id="dataTable">
            <thead>
                  <tr>
<?php

            foreach(array_keys($values[0]->getArray()) as $key)
                  echo "\t\t\t\t<th>$key</th>\n";

?>
                  </tr>
            </thead>
            <tbody>
<?php
       
      foreach($values as $value) {
            echo "\t\t\t<tr>\n";
            
            $array = $value->getArray();
            
            foreach (array_keys($array) as $key) {
                  echo "\t\t\t\t<td>".$array[$key]."</td>\n";
            }
            echo "\t\t\t</tr>\n";
      }

?>
            </tbody>
      </table>
  </div>
      

<?php
     
            } // IF ACTION == USER
            else if ($action == 'month') {
                  if (isset($_GET['m']) && $_GET['m'] != ""){
		              // FORMATO yyyy-mm
		              
		  	$totale_mese=$db->directQuery(MySQLQuery::speseMese("spese", $_GET['m']));
                  	echo getIntText("listspese_monthtotal") . $_GET['m'] .": " . number_format($totale_mese[0], 1, ",", ".") .getIntText("listspese_person").number_format(round($totale_mese[0]/3,1), 1, ",", ".").getIntText("listspese_value")."<br />";
                      
                  } if (isset($_GET['y']) && $_GET['y'] != "")
                  {
                      $totale_anno=0;
                      $chart = new VerticalBarChart(700, 500);
                      $chart2 = new VerticalBarChart(700, 500);
                      $dataSet = new XYDataSet();
                      $dataSet2 = new XYDataSet();
                      for ($i=1;$i<=12;$i++) 
                      {
                          $month = $i;
                          if (strlen($month)==1)
                            $month = "0".$month;
                          $totale_mese=$db->directQuery(MySQLQuery::speseMese("spese", $_GET['y']."-".$month));
                  	echo getIntText("listspese_monthtotal") . $_GET['y']."-".$month .": " . number_format($totale_mese[0], 1, ",", ".") .getIntText("listspese_person").number_format(round($totale_mese[0]/3,1), 1, ",", ".").getIntText("listspese_value")."<br />";
                          $dataSet->addPoint(new Point($_GET['y']."-".$month, round($totale_mese[0],0)));
                          $dataSet2->addPoint(new Point($_GET['y']."-".$month, round($totale_mese[0]/3,0)));
                          $totale_anno = $totale_anno + $totale_mese[0];
                      }
                      
                      echo getIntText("listspese_yeartotal") . number_format($totale_anno, 1, ",", ".") . "<br/>";
                      echo getIntText("listspese_yeartotalperson") . number_format($totale_anno/3, 1, ",", ".") . "<br/>";
                      echo getIntText("listspese_averagemonth") . number_format($totale_anno/12, 1, ",", ".") . "<br/>";
                      echo getIntText("listspese_averagemonthperson") . number_format($totale_anno/12/3, 1, ",", ".") . "<br/>";
                      
                      $chart->setDataSet($dataSet);
                      $chart->setTitle("Spese per mese dell'anno " . $_GET['y']);
                      $chart->render("imgs/graph.png");
                      $chart2->setDataSet($dataSet2);
                      $chart2->setTitle(getIntText("listspese_expensesmonthyear") . $_GET['y']);
                      $chart2->render("imgs/graph2.png");
                      echo "<img src=\"imgs/graph.png\"><br />";
                      echo "<img src=\"imgs/graph2.png\">";
                  }
                  else {
		    ?>
		    <form action="list_spese.php" method="get">
		      <label><?php echo getIntText("listspese_insertmonth"); ?></label>
		      <input type="hidden" name="action" id="action" value="month"></input>
		      <input type="text" name="m" id="m"></input>
		      <input type="submit" />
		    </form>
		    <form action="list_spese.php" method="get">
              <label><?php echo getIntText("listspese_insertyear"); ?></label>
              <input type="hidden" name="action" id="action" value="month"></input>
              <input type="text" name="y" id="y"></input>
              <input type="submit" />
            </form>
		    <?php
                  }
            } // IF ACTION == MONTH
     
      } // IF ISSET ACTION && ACTION != ""
      else {
       
            header("Location: index.php");
            
      }
      
?>
    </div>
  </body>
</html>
