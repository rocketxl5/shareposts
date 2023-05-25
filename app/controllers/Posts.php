<?php
    class Posts extends Controller {

        public function __construct() {
            // session_helper function checks if user login status
            if(!isLoggedIn()) {
                // if not logged redirect to login view
                redirect('users/login');
            }
        }

        public function index() {
            $data = [];

            $this->view('posts/index', $data);
        }
    }