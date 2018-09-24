<?php
  class Category{
  	//DB stuff
  	private $conn;
  	private $table = 'categories';

  	// Post properties
  	public $id;
  	public $name;
  	public $created_at;

  	// Constructor with DB
  	public function __construct($db){
  		$this->conn = $db;
  	}

    //Get categories
    public function read(){
      // create query
      $query = 'SELECT
        id,
        name,
        created_at
      FROM
        ' . $this->table . '
      ORDER BY
        created_at DESC';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Execute query
      $stmt->execute();
      return $stmt;     

    }

    //Get single posts
    public function read_single(){
      $query = 'SELECT
        id,
        name,
        created_at
      FROM
        ' . $this->table . '
      WHERE
        id = ?
      LIMIT 0,1';

    
      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      //Execute query
      $stmt->execute();
      
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      //set properties
      $this->name = $row['name'];  
    }

    //Create category
    public function create(){
      // create query
      $query = 'INSERT INTO ' . $this->table . '
        SET
          name = :name'; 

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));

      //bind data
      $stmt->bindParam(':name', $this->name);

      //Execute query
      if($stmt->execute()){
        return true;
      }

      //print error if something goes wrong
      printf("Error: %s. \n", $stmt->error);
      return false;

    }

    //Update category
    public function update(){
      // update query
      $query = 'UPDATE ' . $this->table . '
        SET
          name = :name
        WHERE
          id = :id'; 

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->id = htmlspecialchars(strip_tags($this->id));

      //bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':id', $this->id);

      //Execute query
      if($stmt->execute()){
        return true;
      }

      //print error if something goes wrong
      printf("Error: %s. \n", $stmt->error);
      return false;

    }

    //Delete category
    public function delete(){
      //Create query
      $query = 'DELETE FROM ' . $this->table. ' WHERE id = :id';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // clean data 
      $this->id = htmlspecialchars(strip_tags($this->id));

      //bind data
      $stmt->bindParam(':id',$this->id);

      //Execute query
      if($stmt->execute()){
        return true;
      }

      //print error if something goes wrong
      printf("Error: %s. \n", $stmt->error);
      return false;
    }

  }  