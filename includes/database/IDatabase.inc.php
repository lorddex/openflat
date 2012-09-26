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

    interface IDatabase {
    
    public function add_slashes($text);
  
    // Connect to MySql Server (Connection data are configured with the constructor)
    public function connect();
    // Disconnect from MySql Server
    public function disconnect();
    
    // Create a new $table in the database, if error occurred will be printed an error and the program will be intterrupted.
    public function createTable(IDbTable $table);
    // Drop a $table from the database, if error occurred will be printed an error and the program will be intterrupted.
    public function dropTable(IDbTable $table);
    // Insert a new $item in the $table, return the new item (with Id attribute set) or false.
    public function insert(IDbItem $item, IDbTable $table);
    // Find an $item in $table, return an array with founded elements.
    public function find(IDbItem $item, IDbTable $table);
    // Modify $table with the modified data in the $item object. $item MUST have a valid ID!
    public function modify(IDbItem $item, IDbTable $table);
    // Delete from $table the $item object. $item MUST have a valid ID!
    public function deleteItem(IDbItem $item, IDbTable $table);
    // Return an Array of IDbItem with all elements of the $table. $item is an object of the class that extends IDbTable.
    public function listAll(IDbItem $item, IDbTable $table);

  }

  interface IDbItem {
    // Return the ID of object. -1 if it's not setted.
    public function getId();
    // set the ID.
    public function setId($id);
    // From an array, that it's the row of the table (all the columns of a single row), this function create an Object. It returns an IDbItem.
    public function createNewFromArray($array);

    public function groupBy();

    public function orderBy();

  }
  
  interface IDbTable {
    // return the name of the table.
    public function getName();
    // insert $item in this table.
    public function insert(IDbItem $item);
    // modify $item in this table. $item must have ID setted.
    public function modify(IDbItem $item);
    public function deleteItem(IDbItem $item); 
    //If $item->getId() return a valid ID, this function will use ID for the search operation else 
    // it use any valid data in $item.
    public function find(IDbItem $item);
    public function listAll($groupBy, $orderBy);
    public function createTable();
    public function dropTable();
  }

?>
