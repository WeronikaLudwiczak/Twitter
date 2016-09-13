<?php


class User {

    private $id;
    private $email;
    private $username;
    private $hashedPassword;

    public function __construct() {
        $this->id = -1;
        $this->email = "";
        $this->username = "";
        $this->hashedPassword = "";
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

    public function setPassword($password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->hashedPassword = $hashedPassword;
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
            
            if($result == TRUE)
            {
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

        $ret = [];

        if ($result == TRUE) {
            foreach ($result as $row) {
                $user = new User();
                $user->id = $row['id'];
                $user->email = $row['email'];
                $user->username = $row['username'];
                $user->hashedPassword = $row['hashed_password'];

                $ret[] = $user;
            }
        }

        return $ret;
    }
    public function delete(mysqli $connection){
        if($this->id != -1){
            $sql = "DELETE FROM User WHERE id=$this->id";
            $result = $connection->query($sql);
                if($result == true){
                    $this->id = -1;
                    return true;
                    }
                    return false;

                        }   
                    return true;
        }

}

