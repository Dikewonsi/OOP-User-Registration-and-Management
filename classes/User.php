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
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($query);
            
            // Bind email parameter
            $stmt->bindParam(":email", $this->email);
        
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
        
    }
?>
