<?php
class Client
{
    // DB
    private $conn;
    private $table = 'client';

    // client Properties
    public $id;
    public $firstName;
    public $lastName;
    public $age;
    public $profession;
    // rdv properties
    public $sujet;
    public $ladate;
    public $id_creneau;
    public $id_rdv;


    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function random_ref()
    {
        $customAlphabet = '0123456789ABCDEFabcdefghijklmnopqrstuvwxyz@_-';
        $id = md5(uniqid($customAlphabet, true));

        return $id;
    }

    // Creer rdv
    public function creer_client()
    {
        // Creer query
        $query = "INSERT INTO client (id, firstName, lastName, age, profession) values (:id, :firstName, :lastName, :age, :profession)";

        // Preparer statement
        $stmt = $this->conn->prepare($query);



        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindparam(':age', $this->age);
        $stmt->bindParam(':profession', $this->profession);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }

    public function read_client()
    {
        // Create query

        $query = 'SELECT firstName, lastName from client where id = ?';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $nmbr = $stmt->rowCount();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array('count' => $nmbr, 'Infos' => $result);
    }

    public function read_RDV()
    {
        $query = 'SELECT rdv.id_rdv, rdv.sujet, rdv.ladate, creneaux.creneaux from rdv INNER JOIN creneaux ON rdv.id_creneau = creneaux.id AND rdv.id_client = ?';
        //prepare stmt

        $stmt = $this->conn->prepare($query);

        //bind id
        $stmt->bindparam(1, $this->id);

        // execute query
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // die(print_r($row));
        return $row;
    }

    // Update Post
    public function update_RDV()
    {
        // Create query
        $query = 'UPDATE rdv SET ladate = :ladate, sujet= :sujet, id_creneau = :id_creneau
                                WHERE id_client = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':sujet', $this->sujet);
        $stmt->bindParam(':ladate', $this->ladate);
        $stmt->bindParam(':id_creneau', $this->id_creneau);


        // Execute query
        if ($stmt->execute()) {

            return true;
        } else {

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }

    // Delete Post
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM rdv WHERE id_rdv = :id_rdv';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        // $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id_rdv', $this->id_rdv);

        // Execute query
        if ($stmt->execute()) {

            return true;
        } else {

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }

    //creer RDV

    public function creer_RDV()
    {

        //creer query
        $query = 'INSERT into rdv SET sujet = :sujet, ladate = :ladate, id_creneau= :id_creneau, id_client = :id_client';

        // preparer query

        $stmt = $this->conn->prepare($query);

        //Bind data

        $stmt->bindParam(':sujet', $this->sujet);
        $stmt->bindParam(':ladate', $this->ladate);
        $stmt->bindParam(':id_creneau', $this->id_creneau);
        $stmt->bindParam(':id_client', $this->id);

        //Executer query 
        if ($stmt->execute()) {

            return true;
        } else {

            //print error if something goes wrong
            printf("Error:%.\n", $stmt->error);
        }
    }

    public function check_Ref()
    {
        //create query

        $query = 'SELECT * from client where id=?';

        //prepare query
        $stmt = $this->conn->prepare($query);

        //bind data
        $stmt->bindParam(1, $this->id);

        //execute query
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function Check_RDV_if_Exists()
    {
        //create query
        $query = 'SELECT creneaux FROM creneaux WHERE NOT EXISTS (SELECT * FROM rdv WHERE rdv.id_creneau = creneaux.id AND rdv.ladate = ?)';
        //prepare stmt
        $stmt = $this->conn->prepare($query);

        //bind Data

        $stmt->bindParam(1, $this->ladate);

        $stmt->execute();
        return $stmt;
    }
}
