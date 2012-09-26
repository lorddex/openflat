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

  class LoginTable implements IDbTable {
  
      private $tableName = "";
    
      public function __construct($TableName="login") {
	if ($TableName != "") {
	  $this->tableName = $TableName;
	} else
	  exit("Table Name not Valid.");
      }
    
      public function getName() {
	return $this->tableName;
      }
    
      public function insert(IDbItem $item){
	return MySQLQuery::loginTableInsert($this->getName(), $item);
      }
      
      public function modify(IDbItem $item){
	return MySQLQuery::loginTableEdit($this->getName(), $item);
      }
      
      public function deleteItem(IDbItem $item){
	return MySQLQuery::TableDeleteItem($this->getName(), $item);
      }
      
      public function find(IDbItem $item){
	if ($item->getId()>0)
	  return MySQLQuery::TableFindID($this->getName(), $item);
	else
	  return MySQLQuery::loginTableFind($this->getName(), $item);
      }
      
      public function listAll($groupBy, $orderBy){
	return MySQLQuery::TableListAll($this->getName(), $groupBy, $orderBy);
      }
      
      public function createTable(){
	return MySQLQuery::loginTableCreate($this->getName());
      }
      
      public function dropTable() {
	return MySQLQuery::loginTableDrop($this->getName());
      }
    
    }
    
    // CLASSE CORSAITEM -------------------------------------------------------------------------------------------------------------------------------
    class LoginItem implements IDbItem {
  
      private $id=-1;
      private $user = "";
      private $pass = "";
      private $mail ="";
      
      private $order="";
      private $group="";


      public function getArray() {

	return array (

	  'id' => $this->id,
	  'user' => $this->user,
	  'pass' => $this->pass,
            'mail' => $this->mail
	);

      }

      public function orderBy($value=""){
	if ($value!=="") {
	  $value = Functions::CheckSimpleText($value);
	  if ($value!==false)
	    $this->order = $value;
	} else 
	  return $this->order;
      }

      public function groupBy($value="") {
	if ($value!=="") {
	  $value = Functions::CheckSimpleText($value);
	  if ($value!==false)
	    $this->group = $value;
	} else 
	  return $this->group;
      }

      public function __construct($user="", $pass="", $mail="") {
    
	  $this->setUser ( $user );
	  $this->setPass ( $pass );
            $this->setMail( $mail );
      }
      
      public function getUser(){
	return $this->user;
      }
      
      public function getPass(){
          return $this->pass;
      }
      
      public function getMail(){
          return $this->mail;
      }
     
      public function setUser($value){
	if (Functions::checkSimpleText($value) !== false)
	  $this->user = $value;
      }
      
      public function setMail($value){
          if (Functions::checkMail($value) !== false)
            $this->mail = $value;
      }
      
      public function setPass($value){
	if (Functions::checkSHA($value))
	  $this->pass = $value;
      }

      public function getId(){
	return $this->id;
      }
      
      public function setId($id){
	$id = Functions::checkInt($id);
	if ( $id !== false && $id >= 1 )
	  $this->id = $id;
      }
      
      public function createNewFromArray($array) {
      
	$item = new LoginItem($array[1], $array[2], $array[3]);
	$item->setId((int)$array[0]);
	return $item;
      
      }
  
  }

?>
