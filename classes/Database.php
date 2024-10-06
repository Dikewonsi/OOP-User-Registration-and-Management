<?php
    class Database {
        private $host = "localhost";
        private $db_name = "oop_app";
        private $username = "root"; // Adjust credentials as needed
        private $password = "";
        public  $conn;

        // Create connection to the database
        public function getConnection() {
            $this->conn = null;
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }
?>
