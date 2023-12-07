<?php

class Post{

    //db stuff
    private $conn;
    private $table='posts';

    //post properties..
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $create_at;


    //Constructor..
    public function __construct($db){
        $this->conn=$db;
    }

    //reading post from db...
    public function read(){
        $query='SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
            FROM
            ' .$this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC';

        //prepare stmt
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;

    }

    public function read_single(){

        $query='SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
            FROM
            ' .$this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
                WHERE p.id=? LIMIT 1';


        // prepare stmt
        $stmt=$this->conn->prepare($query);
        
        //bind parameter
        $stmt->bindParam(1,$this->id);

        //execute the query
        $stmt -> execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $this->title=$row['title'];
        $this->body=$row['body'];
        $this->author=$row['author'];
        $this->category_id=$row['category_id'];
        $this->category_name=$row['category_name'];

    }

    public function create(){
        //query
        $query='INSERT INTO '.$this->table. ' SET title = :title, body = :body, author =:author, category_id = :category_id';
        //prepare
        $stmt = $this->conn->prepare($query);

        //bind parameter
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id',$this->category_id);

        //execute
        if($stmt->execute()){
            return true;
        }
        printf("Error %s.\n",$stmt->error);
        return false;


    }

    public function update(){
        //query
        $query='UPDATE '.$this->table . ' 
        SET title = :title, body = :body, author = :author, category_id = :category_id
        WHERE id = :id' ;
        //prepare
        $stmt = $this->conn->prepare($query);

        //bind parameter
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id',$this->category_id);
        $stmt->bindParam(':id',$this->id);

        //execute
        if($stmt->execute()){
            return true;
        }
        printf("Error %s.\n",$stmt->error);
        return false;


    }

    public function delete(){
        //query
        $query = 'DELETE FROM '. $this->table .' WHERE id=:id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$this->id);
        if($stmt->execute()){
            return true;
        }
        printf("Error %s.\n",$stmt->error);
        return false;

    }

}

?>