<?php


use src\classes\Tweet as Tweet;


class tweetTest extends PHPUnit_Extensions_Database_TestCase
{


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

    public function testRowCount()
    {
        $this->assertEquals(3, $this->getConnection()->getRowCount('Tweets'));
    }

    public function testSavetoDB()
    {


        $conn = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
        $userId = 40;
        $tweetText = "tweet4";
        $creationDate = "2016-11-04 08:56:02";

        $newTweet = new Tweet;
        $newTweet->setUserId($userId);
        $newTweet->setText($tweetText);
        $newTweet->setCreationDate($creationDate);
        $newTweet->saveToDB($conn);

        $this->assertEquals(4, $this->getConnection()->getRowCount('Tweets'));


    }

    public function testLoadTweetById()
    {

        $conn = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);

        $tweetId = 21;
        $tweet = Tweet::loadTweetById($conn, $tweetId);


        $this->assertEquals(41, $tweet->getUserId());

    }

    public function testLoadTweetByUserId()
    {

        $conn = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);

        $userId1 = 41;
        $userId2 = 40;
        $tweets1 = Tweet::loadAllTweetByUserId($conn, $userId1);
        $tweets2 = Tweet::loadAllTweetByUserId($conn, $userId2);
        $NumberOfTweets1 = count($tweets1);
        $NumberOfTweets2 = count($tweets2);


        $this->assertEquals(1, $NumberOfTweets1);
        $this->assertEquals(2, $NumberOfTweets2);

    }

    public function testLoadAllTweets()
    {

        $conn = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);

        $allTweets = Tweet::loadAllTweets($conn);
        $this->assertEquals(3, count($allTweets));


    }


}