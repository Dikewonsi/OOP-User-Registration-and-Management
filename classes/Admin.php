<?php
    class Admin {
        private $conn;
        private $table_name = "admins";

        public $username;
        public $email;
        public $password;

        public function __construct($db) {
            $this->conn = $db;
        }

        // Register Admin
        public function register()
        {
            //Check to see if there is an existing Admin first.
            $query = "SELECT id FROM " . $this->table_name . " WHERE username=:username";
            $stmt = $this->conn->prepare($query);

            // Bind Admin data
            $stmt->bindParam(":username", $this->username);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return false; // Username  already exists.
            }
            else
            {
                // Hash password Code
                //$this->password = password_hash($this->password, PASSWORD_DEFAULT);

                // Insert new Admin
                $query = "INSERT INTO " . $this->table_name . " (username, password) VALUES (:username, :password)";
                $stmt = $this->conn->prepare($query);

                // Bind the parameters
                $stmt->bindParam(":username", $this->username);
                $stmt->bindParam(":password", $this->password);

                if ($stmt->execute()) {
                    return true;
                }

                return false; //Registration Failed.
            }
        }

        //Login Admin
        public function login() {
            // Check if email exists in the database
            $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
            $stmt = $this->conn->prepare($query);
            
            // Bind email parameter
            $stmt->bindParam(":username", $this->username);
        
            $stmt->execute();
        
            // If Admin is found
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $hashed_password = $row['password'];
        
                // Verify password
                if ($this->password == $hashed_password) {
                    // Admin is authenticated
                    return $row; // Return Admin data if needed
                } else {
                    return false; // Incorrect password
                }
            } else {
                return false; // No Admin found
            }
        }
        
    }
?>
