<?php

class Message {
    private $id;
    private $text;
    private $senderId;
    private $addresserId;
    private $creationDate;
    private $ifRead;
    
    public function __construct() {
        $this->id = -1;
        $this->text = "";
        $this->senderId = "";
        $this->addresserId = "";
        $this->creationDate = "";
        $this->ifRead = 1;
    }
    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

    public function getSenderId() {
        return $this->senderId;
    }

    public function getAddresserId() {
        return $this->addresserId;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getIfRead() {
        return $this->ifRead;

    }

   
    public function setText($text) {
        $this->text = $text;
    }

    public function setSenderId($senderId) {
        $this->senderId = $senderId;
    }

    public function setAddresserId($addresserId) {
        $this->addresserId = $addresserId;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setIfRead($ifRead) {
        $this->ifRead=$ifRead;
                if($ifRead == 1){
            echo 'Wiadomosc przeczytana';
        }else if($ifRead == 0){
            echo'Wiadomosc nieprzeczytana';
        }
        
        
    }
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $sql = "INSERT INTO Messages(content, sender_id, addresser_id, creation_date, if_read) VALUES('$this->text', '$this->senderId', '$this->addresserId','$this->creationDate','$this->ifRead');";

            $result = $conn->query($sql);
            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE Messages SET content='$this->text',"
                                 . "creation_date='$this->creationDate',"
                                 . "if_read ='$this->ifRead'"
                 . "WHERE id=$this->id;";
            
            $result = $conn->query($sql);
            
            if($result == TRUE)
            {
                return TRUE;
            }
        }

        return FALSE;
    }
    static public function loadMessageById(mysqli $conn, $id) {
        $sql = "SELECT * FROM Messages WHERE id=$id;";
        $result = $conn->query($sql);

        if ($result == TRUE) {
            $row = $result->fetch_assoc();

            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->text = $row['content'];
            $loadedMessage->senderId = $row['sender_id'];
            $loadedMessage->addresserId = $row['addresser_id'];
            $loadedMessage->creationDate = $row['creation_date'];
            $loadedMessage->ifRead = $row['if_read'];

            return $loadedMessage;
        }

        return NULL;
    }
    static public function loadAllMessages(mysqli $conn) {
        $sql = "SELECT * FROM Messages;";

        $result = $conn->query($sql);

        $ret = [];

        if ($result == TRUE) {
            foreach ($result as $row) {
            $Message = new Message();
            $Message->id = $row['id'];
            $Message->text = $row['content'];
            $Message->senderId = $row['sender_id'];
            $Message->addresserId = $row['addresser_id'];
            $Message->creationDate = $row['creation_date'];
            $Message->ifRead = $row['if_read'];

                $ret[] = $Message;
            }
        }

        return $ret;
    }
    
    
    static public function loadCommentsBySenderId($conn, $senderId){
        
        $query = "SELECT * FROM Messages WHERE sender_id='$senderId' ORDER BY creation_date DESC";
        $result = $conn->query($query);
       
        $messages = array();
        
        if($result !== false){  
        if($result->num_rows > 0){
            foreach($result as $row){
            $Message = new Message();
            $Message->id = $row['id'];
            $Message->text = $row['content'];
            $Message->senderId = $row['sender_id'];
            $Message->addresserId = $row['addresser_id'];
            $Message->creationDate = $row['creation_date'];
            $Message->ifRead = $row['if_read'];

                $ret[] = $Message;
            }
        }

        return $ret;
    }
        }
    static public function loadCommentsByAddresserId($conn, $addresserId){
        
        $query = "SELECT * FROM Messages WHERE addresser_id='$addresserId' ORDER BY creation_date DESC";
        $result = $conn->query($query);
       
        $messages = array();
        
        if($result !== false){  
        if($result->num_rows > 0){
            foreach($result as $row){
            $Message = new Message();
            $Message->id = $row['id'];
            $Message->text = $row['content'];
            $Message->senderId = $row['sender_id'];
            $Message->addresserId = $row['addresser_id'];
            $Message->creationDate = $row['creation_date'];
            $Message->ifRead = $row['if_read'];

                $ret[] = $Message;
            }
        }

        return $ret;
    }
        }


}



