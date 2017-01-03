<?php
namespace src\classes;
use Mysqli;

class Tweet {
    private $id;
    private $userId;
    private $text;
    private $creationDate;
    
    
    public function __construct() {
        $this->id = -1;
        $this->userId = "";
        $this->text = "";
        $this->creationDate = "";
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getText() {
        return $this->text;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }
    
    public function setText($text) {
        $this->text=$text;
  
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $sql = "INSERT INTO Tweets(creation_date, content, user_id) VALUES('$this->creationDate', '$this->text', '$this->userId');";

            $result = $conn->query($sql);
            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE Tweets SET creation_date='$this->creationDate',"
                                 . "content='$this->text',"
                                 . "user_id='$this->userId'"
                 . "WHERE id=$this->id;";
            
            $result = $conn->query($sql);
            
            if($result == TRUE)
            {
                return TRUE;
            }
        }

        return FALSE;
    }
    
    static public function loadTweetById(mysqli $conn, $id) {
        $sql = "SELECT * FROM Tweets WHERE id=$id;";
        $result = $conn->query($sql);

        if ($result == TRUE) {
            $row = $result->fetch_assoc();

            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['user_id'];
            $loadedTweet->text = $row['content'];
            $loadedTweet->creationDate = $row['creation_date'];

            return $loadedTweet;
        }

        return NULL;
    }
    static public function loadAllTweets(mysqli $conn) {
        $sql = "SELECT * FROM Tweets ORDER BY creation_date DESC;";

        $result = $conn->query($sql);

        $ret = [];

        if ($result == TRUE) {
            foreach ($result as $row) {
                $tweet = new Tweet();
                $tweet->id = $row['id'];
                $tweet->userId = $row['user_id'];
                $tweet->text = $row['content'];
                $tweet->creationDate = $row['creation_date'];

                $ret[] = $tweet;
            }
        }

        return $ret;
    }
    static public function loadAllTweetByUserId($conn, $userId){
        
           $query = "SELECT * FROM Tweets WHERE user_id='$userId' ORDER BY creation_date DESC";
        $result = $conn->query($query);
       
        $tweets = array();
        
      if($result !== false){  
        if($result->num_rows > 0){
                foreach($result as $row){
                    $tweet = new Tweet();
                    $tweet->id = $row['id'];
                    $tweet->userId = $row['user_id'];
                    $tweet->creationDate = $row['creation_date'];
                    $tweet->text = $row['content'];
                    $tweets[] = $tweet;
                }
                return $tweets;
    
       } else {
            return false;
            }
        } else {
            return false;
        }
    
    
}
  
        
    
    }

