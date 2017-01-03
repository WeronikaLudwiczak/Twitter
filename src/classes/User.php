<?php

namespace src\classes;
use Mysqli;

class User {
    
    private $id;
    private $email;
    private $username;
    private $hashedPassword;

    public function __construct() {
        $this->id = -1;
        $this->email = null;
        $this->username = null;
        $this->hashedPassword = null;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getHashedPassword() {
        return $this->hashedPassword;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password1, $password2) {
        if($password1 != $password2){
            return false;
        }
        $hashedPassword = password_hash($password1,PASSWORD_BCRYPT);
        $this->hashedPassword = $hashedPassword;
        return true;
    }
    
    

    public function saveToDB(mysqli $conn) {
        if ($this->id == -1) {
            $sql = "INSERT INTO User(email, username, hashed_password) VALUES('$this->email', '$this->username', '$this->hashedPassword');";

            $result = $conn->query($sql);
            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE User SET email='$this->email',"
                                 . "username='$this->username',"
                                 . "hashed_password='$this->hashedPassword'"
                 . "WHERE id=$this->id;";
            
            $result = $conn->query($sql);
            
            if($result == TRUE){
            
                return TRUE;
            }
        }

        return FALSE;
    }

    static public function loadUserById(mysqli $conn, $id) {
        $sql = "SELECT * FROM User WHERE id=$id;";
        $result = $conn->query($sql);

        if ($result == TRUE) {
            $row = $result->fetch_assoc();

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->email = $row['email'];
            $loadedUser->username = $row['username'];
            $loadedUser->hashedPassword = $row['hashed_password'];

            return $loadedUser;
        }

        return NULL;
    }
    static public function loadAllUsers(mysqli $conn) {
      
        $sql = "SELECT * FROM User;";

        $result = $conn->query($sql);

        $users = [];

        if ($result == TRUE) {
            foreach ($result as $row) {
                $user = new User();
                $user->id = $row['id'];
                $user->email = $row['email'];
                $user->username = $row['username'];
                $user->hashedPassword = $row['hashed_password'];

                $users[] = $user;
            }
        }

        return $users;
    }
    

    
    static public function LogIn(mysqli $conn, $email, $password)
    {
        $toReturn = null;
        $sql = "SELECT * FROM User WHERE email='{$email}'";
        $result = $conn->query($sql);
        if ($result != false) {
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $loggedUser = new User();
                $loggedUser->id = $row['id'];
                $loggedUser->email = $row['email'];
                $loggedUser->username = $row['username'];
                $loggedUser->hashedPassword = $row['hashed_password'];
           
                
                if ($loggedUser->verifyPassword($password)) {
                    $toReturn = $loggedUser;
                }
            }
        }
        return $toReturn;
    }


    public function delete(mysqli $conn){
        if($this->id != -1){
            $sql = "DELETE FROM User WHERE id=$this->id";
            $result = $conn->query($sql);
                if($result == true){
                    $this->id = -1;
                    return true;
                    }
                    return false;

                        }   
                    return true;
        }
    
        
   public function verifyPassword($password)
    {
        return password_verify($password, $this->hashedPassword);
    }

    
}
        