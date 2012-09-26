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
 
    class MySQLDatabase implements IDatabase {
    
    private function debug($text) {
      Functions::debug($text, "MySQLDatabase", true);
    }

    private $server="";
    private $username="";
    private $password="";
    private $db="";
    private $connection=null;	

    function __construct(/* PARAMETERS MUST BE IN includes/configuration.inc.php file */) { 
   
      global $config_db;
      global $config_server;
      global $config_username;
      global $config_password;
 
      if ($config_db != "" && $config_server != "" && $config_username != ""){
	$this->db=$config_db;
	$this->server=$config_server;
	$this->username=$config_username;
	$this->password=$config_password;
      }

    }
    
       
    public function connect() {
    
      if ($this->server != "" && $this->username != ""&& $this->db != "") {
	$this->connection = mysql_connect($this->server, $this->username, $this->password);
	if (!$this->connection)
	  throw new Exception ("Database error: " . mysql_error($this->connection));
	$res = mysql_select_db($this->db, $this->connection);
	if (!$res)
	  throw new Exception ("Database error: " . mysql_error($this->connection));
      } else 
	throw new Exception ("Database: Parameters not valid.");
	
    }
    
    public function disconnect(){

      if ($this->connection === null)
	  throw new Exception("Not connected!");

	mysql_close($this->connection);
    }
    
    public function createTable(IDbTable $table){

      if ($this->connection === null)
	  throw new Exception("Not connected!");

      $res = mysql_query($table->createTable(), $this->connection);
      
      if (!$res)
	throw new Exception ("Error during table creation: " . mysql_error($this->connection));

    }
    
    public function dropTable(IDbTable $table){

      if ($this->connection === null)
	  throw new Exception("Not connected!");

      $res =mysql_query($table->dropTable(), $this->connection);
      if (!$res)
	throw new Exception ("Error during table drop: " . mysql_error($this->connection));

    }
    
    public function insert(IDbItem $item, IDbTable $table) {

//       Functions::debug($table->insert($item), "MySqlDatabase.ink.php");

      if ($this->connection === null)
	  throw new Exception("Not connected!");

      $res = mysql_query($table->insert($item), $this->connection);
      if (!$res)	
	 throw new Exception ("Error during insert query: " . mysql_error($this->connection));

      $item->setId(mysql_insert_id($this->connection));

      return $item;
    }
    
    public function find(IDbItem $item, IDbTable $table) {

//      Functions::mecho($table->find($item));
      
      if ($this->connection === null)
	  throw new Exception("Not connected!");

      $res = mysql_query($table->find($item), $this->connection);
      if (!$res)
	throw new Exception ("Error during find query: " . mysql_error($this->connection));

      $toRet = array();
      while ($row = mysql_fetch_row($res)) {
	
	$item = $item->createNewFromArray($row);
	$toRet = array_merge( $toRet, array($item) ); 
	
      }
      return $toRet;
    }
    
    public function modify(IDbItem $item, IDbTable $table) {
    
//       Functions::mecho($table->modify($item));
//             echo $table->modify($item);
      if ($this->connection === null)
	  throw new Exception("Not connected!");

      if ($item->getId() >= 1 ) {
	if (count($this->find($item, $table)) == 1) {
	  $res = mysql_query($table->modify($item), $this->connection);
	  if (!$res)
	    throw new Exception ("Error during Item modify: " . mysql_error($this->connection) );
	} else
	  throw new Exception("Item with ID " . $item->getId() . " don't exists!");
      } else
	throw new Exception("Item to modify haven't any ID!");
      
    }
    
    public function deleteItem(IDbItem $item, IDbTable $table) {
      
      if ($this->connection === null)
	  throw new Exception("Not connected!");

      if ($item->getId() > 0  ) {
	if (count($this->find($item, $table)) == 1) {
	  $res = mysql_query($table->deleteItem($item), $this->connection);
	  if (!$res)
	    throw new Exception ("Error deleting Item: " . mysql_error($this->connection) );
	} else
	  throw new Exception("Item with ID " . $item->getId() . " don't exists!");
      } else
	throw new Exception("Item to delete haven't any ID!");
      
    }
    
    public function listAll(IDbItem $item, IDbTable $table) {

      if ($this->connection === null)
	  throw new Exception("Not connected!");

//       echo $table->listAll($item->groupBy(), $item->orderBy());

      $res = mysql_query( $table->listAll($item->groupBy(), $item->orderBy()), $this->connection);
       if (!$res)
	    throw new Exception ("Error during listAll: " . mysql_error($this->connection) );
      $toRet = array();
      while ($row = mysql_fetch_row($res)) {
	$item = $item->createNewFromArray($row);
	$toRet = array_merge( $toRet, array($item) ); 
      }

      return $toRet;
    }

    public function directQuery($query, $item=null, $particular=false, $result_type=MYSQL_BOTH, $single=true, $insert=false) {

//     Functions::mecho($query);

    if ($this->connection === null)
	  throw new Exception("Not connected to database!");

      $res = mysql_query($query, $this->connection);
       if (!$res)
	    throw new Exception ("Error during directQuery: " . mysql_error($this->connection) );
      if ($insert == true)
	return "";

      $toRet = array();

     if ($particular === false && $item!==null) {
	while ($row = mysql_fetch_row($res)) {
	  $item = $item->createNewFromArray($row);
	  $toRet = array_merge( $toRet, array($item) ); 
	}
	return $toRet;
      } else {
	$toRet = array();
	if (mysql_num_rows($res) == 1 && $single){
	    return mysql_fetch_array($res, $result_type);
	} else {
	  while ($row = mysql_fetch_array($res, $result_type)) {
	    $toRet = array_merge( $toRet, array($row) ); 
	  }
	  return $toRet;
	}
      }
    }
    
      public function add_slashes($text) {

	if ($this->connection === null)
	  throw new Exception("Not connected!");

	return mysql_real_escape_string  ( $text,  $this->connection );

      }

  }
  
?>
