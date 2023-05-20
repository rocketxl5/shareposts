<?php
    class User {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        // Find User by Email
        public function findUserByEmail($email) {
        
            $this->db->query("SELECT * FROM users WHERE email = :email");
            // Bind values
            $this->db->bind(':email', $email);

            $row = $this->db->single();
            
            // Check row
            if($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        // Register New User
        public function register($data) {

            $this->db->query("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            // Bind values
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        // Login User
        public function login($email, $password) {
            
            $this->db->query("SELECT * FROM users WHERE email = :email");
            // Bind values
            $this->db->bind(':email', $email);
            // Get single result as object
            $row = $this->db->single();

            // Get password from object
            $hashed_password = $row->password;

            if(password_verify($password, $hashed_password)) {
                return $row;
            } else {
                return false;
            }
        }
    }