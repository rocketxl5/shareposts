<?php
    class Pages extends Controller {

        // Models are instantited in the controllers constructor
        public function __construct() {
            $this->postModel = $this->model('Post');
        }

        public function index() {
            $posts = $this->postModel->getPosts();

            $data = [
                'title' => 'SharePosts',
                'description' => 'Post sharing netword built on MVC framework',
                'posts' => $posts
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