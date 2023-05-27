<?php
    class Posts extends Controller {

        public function __construct() {
            // session_helper function checks if user login status
            if(!isLoggedIn()) {
                // if not logged redirect to login view
                redirect('users/login');
            }

            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
        }

        public function index() {
            // Get posts
            $posts = $this->postModel->getPosts();

            $data = ['posts' => $posts];

            $this->view('posts/index', $data);
        }

        // Handles Post request received from add.php view
        public function add() {
            // If post form is sent
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

                // Check no errors
                if(empty($data['title_err']) && empty($data['body_err'])) {
                    // Validated
                    if($this->postModel->addPost($data)) {
                        flash('post_message', 'Post Added');
                        redirect('posts');
                    } else {
                        die('Something went wrong from Posts Controller');
                    }
                } else {
                    // Load view with errors
                    $this->view('posts/add', $data);
                }
            // Send generic view with empty fields
            } else {
                $data = [
                    'title' => '',
                    'body' => ''
                ];
    
                $this->view('posts/add', $data);
            }
        }

        // Edits existing post 
        public function edit($id) {
            // If post form is sent
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Create data array with values
                $data = [
                    'id' => $id,
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

                // Check no errors
                if(empty($data['title_err']) && empty($data['body_err'])) {
                    // Validated
                    if($this->postModel->updatePost($data)) {
                        flash('post_message', 'Post Updated');
                        redirect('posts');
                    } else {
                        die('Something went wrong from Posts Controller');
                    }
                } else {
                    // Load view with errors
                    $this->view('posts/edit', $data);
                }
            // Send generic view with empty fields
            } else {
                // Get post with id
                $post = $this->postModel->getPostById($id);
                // Check if user id is different than session's user id
                if($post->user_id != $_SESSION['user_id']) {
                    // If so, redirect user to posts view
                    redirect('posts');
                }

                $data = [
                    'id' => $id,
                    'title' => $post->title,
                    'body' => $post->body
                ];
    
                $this->view('posts/edit', $data);
            }
        }

        // Handles the display details of a single post
        // Called on click of achor button (More) on posts/index.php view
        public function show($id) {
            // Fetch single post from db
            $post = $this->postModel->getPostById($id);
            $user = $this->userModel->getUserById($post->user_id);
            $data = [
                'post' => $post,
                'user' => $user
            ];

            $this->view('posts/show', $data);
        }

        public function delete($id) {
            // Get post with id
            $post = $this->postModel->getPostById($id);
            // Check if user id is different than session's user id
            if($post->user_id != $_SESSION['user_id']) {
                // if not, redirect user to posts view
                redirect('posts');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if($this->postModel->deletePost($id)) {
                    flash('post_message', 'Post Removed');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                redirect('posts');
            }
        }
    }