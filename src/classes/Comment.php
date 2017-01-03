<?php
namespace src\classes;

use Mysqli;

class Comment {
    
    private $id;
    private $userId;
    private $tweetId;
    private $creationDate;
    private $text;

    public function __construct() {
        $this->id = -1;
        $this->userId = "";
        $this->tweetId = "";
        $this->creationDate = "";
        $this->text = "";
    }
    
    
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getTweetId() {
        return $this->tweetId;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }
    
    public function getText() {
        return $this->text;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }
    public function setText($text) {
        $this->text = $text;
    }
    
    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $sql = "INSERT INTO Comment(user_id, tweet_id, creation_date, text) VALUES('$this->userId', '$this->tweetId', '$this->creationDate', '$this->text');";

            $result = $conn->query($sql);
            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE Comment SET creation_date='$this->creationDate'"
                                 . "text='$this->text"
                                 . "WHERE id=$this->id;";
            
            $result = $conn->query($sql);
            
            if($result == TRUE)
            {
                return TRUE;
            }
        }

        return FALSE;
    }
        
    static public function loadCommentById(mysqli $conn, $id) {
        $sql = "SELECT * FROM Comment WHERE id=$id;";
        $result = $conn->query($sql);

        if ($result == TRUE) {
            $row = $result->fetch_assoc();

            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->userId = $row['user_id'];
            $loadedComment->tweetId = $row['tweet_id'];
            $loadedComment->text = $row['text'];
            $loadedComment->creationDate = $row['creation_date'];

            return $loadedComment;
        }

        return NULL;
    }
    
    static public function getCommentByTweetId($conn, $tweetId) {
        
        $query = "SELECT * FROM Comment WHERE tweet_id='$tweetId' ORDER BY creation_date DESC";
        $result = $conn->query($query);
       
        $comments = array();
        
      if($result !== false){  
        if($result->num_rows > 0){
                foreach($result as $row){
                    $comment = new Comment();
                    $comment->id = $row['id'];
                    $comment->userId = $row['user_id'];
                    $comment->tweetId = $row['tweet_id'];
                    $comment->creationDate = $row['creation_date'];
                    $comment->text = $row['text'];
                    $comments[] = $comment;
                }
                return $comments;
    
       } else {
            return false;
            }
        } else {
            return false;
        }
    
    
}

}