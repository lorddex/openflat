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

  class SpeseTable implements IDbTable {
  
      private $tableName = "";
    
      public function __construct($TableName="spese") {
	if ($TableName != "") {
	  $this->tableName = $TableName;
	} else
	  exit("Table Name not Valid.");
      }
    
      public function getName() {
	return $this->tableName;
      }
    
      public function insert(IDbItem $item){
	return MySQLQuery::speseTableInsert($this->getName(), $item);
      }
      
      public function modify(IDbItem $item){
	return MySQLQuery::speseTableEdit($this->getName(), $item);
      }
      
      public function deleteItem(IDbItem $item){
	return MySQLQuery::TableDeleteItem($this->getName(), $item);
      }
      
      public function find(IDbItem $item){
	if ($item->getId()>0)
	  return MySQLQuery::TableFindID($this->getName(), $item);
	else
	  return MySQLQuery::speseTableFind($this->getName(), $item);
      }
      
      public function listAll($groupBy, $orderBy){
	
	return MySQLQuery::speseListAll($this->getName(), $groupBy, $orderBy);
      }
      
      public function createTable(){
	return MySQLQuery::speseTableCreate($this->getName());
      }
      
      public function dropTable() {
	return MySQLQuery::speseTableDrop($this->getName());
      }
    
      public function totaleSpese(IDbItem $item) {
          return MySQLQuery::speseTableTotale($this->getName(), $item);
      }

      public function totaleSpeseGruppo(IDbItem $item) {
          return MySQLQuery::spesePerGroup($this->getName(), $item);
      }

    }
    
    // CLASSE SpesaITEM -------------------------------------------------------------------------------------------------------------------------------
    class SpesaItem implements IDbItem {
  
      private $id = -1;
      private $id_user = -1;
      private $date = "";
      private $value = -1;
      private $state = 1;
      private $desc = "";
      private $gruppo = -1;
      private $type = "singola";
           
      private $order = "";
      private $group = "";


      public function getArray() {

	return array (

	  'id' => $this->id,
	  'id_user' => $this->id_user,
	  'date' => $this->date,
	  'value' => $this->value,
	  'state' => $this->state,
	  'desc' => $this->desc,
	  'type' => $this->type,
	  'gruppo' => $this->gruppo

	);

      }

      public function orderBy($value=""){
	if ($value!=="") {
	  if (Functions::CheckSimpleText($value))
	    $this->order = $value;
	} else 
	  return $this->order;
      }

      public function groupBy($value="") {
	if ($value!="") {
	  $value = Functions::CheckSimpleText($value);
	  if ($value!==false)
	    $this->group = $value;
	} else  {
	  return $this->group;
	}
      }

      public function __construct($id_user=-1, $date="", $value=-1, $state=1, $desc="", $type="", $gruppo="") {
    
	  $this->setIdUser ( $id_user );
            $this->setDate ( $date ); 
            $this->setValue ( $value );
            $this->setState ( $state );
            $this->setDesc ( $desc );
	    $this->setType ( $type );
	    $this->setGruppo ( $gruppo );

      }
      
      public function getIdUser(){
	return $this->id_user;
      }
      
      public function getDate(){
          return $this->date;
      }
      
      public function getValue(){
          return $this->value;
      }
      
      public function getState() {
            return $this->state;
      }
      
      public function getDesc(){
          return $this->desc;
      }

      public function getType(){
          return $this->type;
      }

      public function getGruppo(){
          return $this->gruppo;
      }

      public function setIdUser($value){
	if (Functions::checkInt($value) !== false)
	  $this->id_user = $value;
      }
      
      public function setDate($value){
          if (Functions::checkData($value))
            $this->date = $value;
      }
      
      public function setValue($value){
          $value = Functions::checkFloat($value);
          if ($value !== false)
            $this->value = $value;
      }
      
      public function setState($value){
          if (Functions::checkInt($value) !== false)
            $this->state = $value;
      }
      
      public function setDesc($value){
          if (Functions::checkText($value))
            $this->desc = Functions::checkText($value);
      }

      public function setType($value){
          if (Functions::checkSimpleText($value))
            $this->type = $value;
      }

      public function setGruppo($value){
          if (Functions::checkInt($value)!==false)
            $this->gruppo = $value;
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
	$item = new SpesaItem( $array[1], $array[2], (float) $array[3], (int) $array[4], $array[5], $array[6], $array[7] );
	$item->setId((int)$array[0]);
	return $item; 
      }
  
  }

?>
