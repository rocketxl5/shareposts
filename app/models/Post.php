<?php
    class Post {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }



        public function getPosts() {

            $this->db->query("SELECT *,
                              posts.id as postId,
                              users.id as userId,
                              posts.created_at as postCreated,
                              users.created_at as userCreated
                              FROM posts
                              INNER JOIN users 
                              ON posts.user_id = users.id
                              ORDER BY posts.created_at DESC
                              ");
            // $this->db->query("SELECT * FROM posts");

            $results = $this->db->resultSet();

            return $results;
        }

        public function addPost($data) {
            // Query to insert new user in db 
            $this->db->query("INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :user_id)");
            // Bind values to named parameters
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':user_id', $data['user_id']);
            
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function updatePost($data) {
            // Query to insert new user in db 
            $this->db->query("UPDATE posts SET title = :title, body = :body WHERE id = :id");
            // Bind values to named parameters
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function getPostById($id) {
            $this->db->query("SELECT * FROM posts WHERE id = :id");
            // Bind value
            $this->db->bind(':id', $id);

            $row = $this->db->single();
            
            return $row;
        }

        public function deletePost($id) {
            $this->db->query("DELETE FROM posts WHERE id = :id");
            // Bind value
            $this->db->bind(':id', $id);

            // Execute
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }