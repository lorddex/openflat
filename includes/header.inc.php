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
                
                function conferma(url){
                      if(confirm("<?php echo getIntText("listspese_confirm"); ?>")==true)
                            document.location=url;
                };

		
		function correct() {
			var val = new String(document.getElementById('value').value);
		     	var conf = confirm(<?php echo getIntText("addspesa_confirm"); ?> + val + "?");
              		if (conf==false)
                    		return false;
              		val = val.replace(",", ".");
              		document.getElementById('value').value = val;
              		return true;
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
      <div id="container">
