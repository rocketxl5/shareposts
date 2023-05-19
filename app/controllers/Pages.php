<?php
    class Pages extends Controller {

        // Models are instantited in the controllers constructor
        public function __construct() {
           
        }

        public function index() {

            $data = [
                'title' => 'SharePosts',
                'description' => 'Post sharing netword built on MVC framework'
            ];

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