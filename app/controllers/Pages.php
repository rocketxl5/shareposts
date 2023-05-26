<?php
    class Pages extends Controller {

        // Models are instantited in the controllers constructor
        public function __construct() {
            
        }

        public function index() {
            // If user is logged in
            if(isLoggedIn()) {
                // Redirect user to posts page
                redirect('posts');
            }

            $data = [
                'title' => 'SharePosts',
                'description' => 'Post sharing netword built on MVC framework'
            ];
            
            // No user is logged in, send home page view
            $this->view('pages/index', $data);
        }

        public function about() {

            $data = [
                'title' => 'About Us',
                'description' => 'App to share posts with other users'
            ];

            $this->view('pages/about', $data);
        }
    }