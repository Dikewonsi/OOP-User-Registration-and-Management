<?php
    class User {
        private $conn;
        private $table_name = "users";

        public $username;
        public $email;
        public $password;

        public function __construct($db) {
            $this->conn = $db;
        }

        // Register user
        public function register()
        {
            //Check to see if there is an existing user first.
            $query = "SELECT id FROM " . $this->table_name . " WHERE username=:username OR email=:email";
            $stmt = $this->conn->prepare($query);

            // Bind user data
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return false; // Username or email already exists.
            }
            else
            {
                // Hash password Code
                //$this->password = password_hash($this->password, PASSWORD_DEFAULT);

                // Insert new user
                $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password)";
                $stmt = $this->conn->prepare($query);

                // Bind the parameters
                $stmt->bindParam(":username", $this->username);
                $stmt->bindParam(":email", $this->email);
                $stmt->bindParam(":password", $this->password);

                if ($stmt->execute()) {
                    return true;
                }

                return false; //Registration Failed.
            }
        }

        //Login User
        public function login() {
            // Check if email exists in the database
            $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($query);
            
            // Bind email parameter
            $stmt->bindParam(":username", $this->username);
        
            $stmt->execute();
        
            // If user is found
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $hashed_password = $row['password'];
        
                // Verify password
                if ($this->password == $hashed_password) {
                    // User is authenticated
                    return $row; // Return user data if needed
                } else {
                    return false; // Incorrect password
                }
            } else {
                return false; // No user found
            }
        }

        // Fetch user profile by username
        public function fetchProfile($username) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        //Update User Details
        public function updateUser($email, $password, $username){
            $query = "UPDATE " . $this->table_name . " SET email = :email, password = :password WHERE username = :username";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':username', $username);

            if ($stmt->execute())
            {
                return true; // Update successful
            }

            return false; // Update failed

            
        }

        //Delete User Account
        public function deleteAccount(){
            $query = "DELETE FROM " . $this->table_name . " WHERE username = :username";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":username", $this->username);

            if ($stmt->execute())
            {
                return true; // Update successful
            }

            return false; // Update failed
        }
    }
?>
