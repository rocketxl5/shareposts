<?php
    class Users extends Controller {

        public function __construct() {

        }
        
        // Load register form
        // Handle submit (POST) request 
        public function register() {
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
            } else {
                // Load form
                // Init data (data persistense)
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Load view
                $this->view('users/register', $data);
            }
        }

        public function login() {
                // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
            } else {
            // Load form
            // Init data (data persistense)
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            $this->view('users/login', $data);
            }
        }
    }