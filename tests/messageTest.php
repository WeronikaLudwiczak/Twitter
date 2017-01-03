<?php

use src\classes\Message as Message;



class commentTest extends PHPUnit_Extensions_Database_TestCase{
    
    
        static private $pdo = null;
	private $conn = null;


	final public function getConnection(){
		if ($this->conn === null) {
			if (self::$pdo == null) {
				self::$pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD']);
			}
			$this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
		}

		return $this->conn;
	}

	protected function getDataSet(){
            return $this->createFlatXMLDataSet('fixture.xml');
	}
        
        public function testRowCount(){
            $this->assertEquals(2, $this->getConnection()->getRowCount('Messages'));
        }
        
        public function testSaveToDb(){
            
            $conn= new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
            $senderId=41;
            $addresserId=40;
            $messageText="message3";
            $creationDate="2016-02-09 12:06:22";
            $ifRead=1;
            
            $newMessage= new Message;
            $newMessage->setSenderId($senderId);
            $newMessage->setAddresserId($addresserId);
            $newMessage->setText($messageText);
            $newMessage->setCreationDate($creationDate);
            $newMessage->setIfRead($ifRead);
            $newMessage->saveToDB($conn); 
            
            $this->assertEquals(3, $this->getConnection()->getRowCount('Messages'));
            $this->assertEquals(41, $newMessage->getSenderId());
            
        }
        
        public function testLoadMessageById(){
            
            $conn= new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
            $messageId1=1;
            $messageId2=2;
             
            $message1= Message::loadMessageById($conn, $messageId1);
            $message2= Message::loadMessageById($conn, $messageId2);
            
             
            $this->assertEquals(40, $message1->getSenderId());
            $this->assertEquals(41, $message2->getSenderId());
        }
        
        public function testLoadAllMessages(){
            
            $conn= new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
            
            $messages= Message::loadAllMessages($conn);
            $this->assertEquals(2, count($messages));
            $this->assertNotEquals(5, $messages);
           
        }
        
        public function testLoadCommentsBySenderId(){
            
            $conn= new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
            $senderId=40;
            
            $messages= Message::loadCommentsBySenderId($conn, $senderId);
            
            $this->assertEquals(1, count($messages));
            $this->assertEquals(41, $messages[0]->getAddresserId());
        }
        
        public function testLoadCommentsByAddresserId(){
            
            $conn= new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
            $addresserId=40;
            
            $messages= Message::loadCommentsByAddresserId($conn, $addresserId);
            
            $this->assertEquals(1, count($messages));
            $this->assertEquals(2, $messages[0]->getId());
        
            
        }
        
        
}
        

