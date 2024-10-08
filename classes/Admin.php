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

        // Fetch all users from the users table
        public function fetchUsers() {
            $query = "SELECT * FROM users";  // Adjust table name if necessary
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all users as an associative array
        }


        //Fetch User By Id
        public function fetchUserById($id)
        {
            $query = "SELECT * FROM users WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if($stmt->rowCount() > 0)
            {
                return $stmt->fetch(PDO::FETCH_ASSOC); // Return user data as an associative array
            }

            return false; // Return false if user not found
        }


        //Update User Details
        public function updateUser($id, $username, $email, $password)
        {
            $query = "UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute())
            {
                return true; // Update successful
            }

            return false; // Update failed
        }
        
    }
?>
