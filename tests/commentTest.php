<?php

require 'src/Comment.php';

class commentTest extends PHPUnit_Extensions_Database_TestCase{
    
    
        static private $pdo = null;
	private $conn = null;


	final public function getConnection()
	{
		if ($this->conn === null) {
			if (self::$pdo == null) {
				self::$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
			}
			$this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
		}

		return $this->conn;
	}

	protected function getDataSet()
	{
            return $this->createFlatXMLDataSet('fixture.xml');
	}
        
        public function testRowCount(){
            $this->assertEquals(3, $this->getConnection()->getRowCount('Comment'));
        }
        
        public function testSaveToDb(){
            
            $conn= new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
            $userId=41;
            $tweetId=22;
            $commentText="comment4";
            $creationDate="2016-12-04 01:56:02";
            
            $newComment= new Comment;
            $newComment->setUserId($userId);
            $newComment->setTweetId($tweetId);
            $newComment->setText($commentText);
            $newComment->setCreationDate($creationDate);
            $newComment->saveToDB($conn); 
            
            $this->assertEquals(4, $this->getConnection()->getRowCount('Comment'));
            $this->assertEquals(22, $newComment->getTweetId());
            
        }
        
        
        public function testLoadCommentById(){
            
            $conn= new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
            
            $commentId1=12;
            $commentId2=11;
            
            $comment1= Comment::loadCommentById($conn, $commentId1);
            $comment2= Comment::loadCommentById($conn, $commentId2);
            
            $this->assertEquals(41, $comment1->getUserId());
            $this->assertEquals(20, $comment2->getTweetId());
            
            
        }
        
        public function testLoadCommentByTweetId(){
            
             $conn= new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
            
             $tweetId=22;
             $comments= Comment::getCommentByTweetId($conn, $tweetId);
             
             $this->assertEquals(2, count($comments));
            
        }
}