<?php

//require_once 'User.php';
require 'Tweet.php';

$conn = new mysqli("localhost", "root", "root", "twitter_db");


  //test saveToDB
//$user = new User();
//$user->setEmail("ted@makota.com");
//$user->setUsername("ted");
//$user->setPassword("haslo");
//
//
//var_dump($user);
//$user->saveToDB($conn);
//var_dump($user);
//
//$user->delete($conn);
///*
// test function loadUserById()
//$user = User::loadUserById($conn, "1");
//var_dump($user);
//
//
//$users = User::loadAllUsers($conn);
//var_dump($users);
// 
/*
$user = User::loadUserById($conn, "1");
$user->setEmail("ola@makota.com");
$user->setUsername("ola");
$user->setPassword("12345678");
$user->saveToDB($conn);
*/
//$tweet =new Tweet();
//$tweet->setCreationDate("2016-04-02");
//$tweet->setText("Drugi Tweet");
//$tweet->setUserId("1");

//var_dump($tweet);
//$tweet->saveToDB($conn);
//var_dump($tweet);

//$tweet = Tweet::loadTweetById($conn, "4");
//var_dump($tweet);
//$tweet=  Tweet::loadAllTweets($conn);
//var_dump($tweet);

$tweet=  Tweet::loadAllTweetByUserId($conn,'1');
var_dump($tweet);