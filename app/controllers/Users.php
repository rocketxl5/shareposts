<?php
    class Users extends Controller {
    public $userModel;
        
        public function __construct() {
            $this->userModel = $this->model('User');
        }
        
        // Load register form
        // Handle submit (POST) request 
        public function register() {
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form

                // Sananitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init date
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Validate Name 
                if(empty($data['name'])) {
                    $data['name_err'] = 'Please enter your name';
                }
                
                // Validate Email
                if(empty($data['email'])) {
                    $data['email_err'] = 'Please enter your email';
                    // Check if Email exist in database
                } elseif($this->userModel->findUserByEmail($data['email'])) {
                        // Email already exist id db
                        $data['email_err'] = 'Email already exist';
                }

                // Validate Password
                if(empty($data['password'])) {
                    $data['password_err'] = 'Please enter a password';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be at least 6 characters';
                }  

                // Validate Password Confimation
                if(empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm password';
                } elseif($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }

                // Make sure errors are empty
                if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                    
                    // Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register User
                    if($this->userModel->register($data)) {
                        // Calling helper function displaying message
                        flash('register_success', 'You are registered and can log in');
                        // Redirect user
                       redirect('users/login');
                    } else {
                        die('Something went wrong @ $this->userModel->register($data)');
                    }
                }

                $this->view('users/register', $data);

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

                // Sanatize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => ''
                ];
                
                // Validate Email
                if(empty($data['email'])) {
                    $data['email_err'] = 'Please enter your email';
                } elseif(!$this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'No user found';
                }
                
                // Validate Password
                if(empty($data['password'])) {
                    $data['password_err'] = 'Please enter your password';
                } 

                // Make sure errors are empty
                if(empty($data['email_err']) && empty($data['password_err'])) {
                    // Validated
                    // Check and set logged in user
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    // All good
                    if($loggedInUser) {
                        // Create Session
                        $this->createUserSession($loggedInUser);

                    // Wrong password
                    } else {
                        // Set message error
                        $data['password_err'] = 'Incorrect password';
                    }
                }

                // Load view
                $this->view('users/login', $data);

                
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

        // Create session variable upon user login
        public function createUserSession($user) {
            // Create session variables
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;

        // Redirect user
        redirect('posts');
         }

        // Destroy session variables on logout
        public function logout() {
            // Delete session variables
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_email']);
            // Destroy session
            session_destroy();
            // Redirect user
            redirect('users/login');
    }   
    }