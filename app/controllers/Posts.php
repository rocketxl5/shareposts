<?php
    class Posts extends Controller {

        public function __construct() {
            // session_helper function checks if user login status
            if(!isLoggedIn()) {
                // if not logged redirect to login view
                redirect('users/login');
            }

            $this->postModel = $this->model('Post');
        }

        public function index() {
            // Get posts
            $posts = $this->postModel->getPosts();

            $data = ['posts' => $posts];

            $this->view('posts/index', $data);
        }

        
        public function add() {
            // If add post form is sent
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Create data array with values
                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate title
                if(empty($data['title'])) {
                    $data['title_err'] = 'Please enter a title';
                }
                // Validate body
                if(empty($data['body'])) {
                    $data['body_err'] = 'Please enter a body text';
                }

                // $this->view('posts/add', $data);

                // Check no errors
                if(empty($data['title_err']) && empty($data['body_err'])) {
                 
                } else {
                    // Load view with errors
                    $this->view('posts/add', $data);
                }
            } else {
                $data = [
                    'title' => '',
                    'body' => ''
                ];
    
                $this->view('posts/add', $data);
            }
        }
    }