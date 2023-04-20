<?php
    class Core {
        private $currentController = 'Pages';
        private $currentMethod = 'index';
        private $params = [];

        public function __construct() {
       
            $url = $this->getUrl();

            if($url != null && file_exists('../app/controllers/' . ucwords($url[0] . '.php'))) {
                $this->currentController = ucwords($url[0]);

                unset($url[0]);
            }

            require_once '../app/controllers/' . $this->currentController . '.php';

            $this->currentController = new $this->currentController;

            if(isset($url[1])) {           
                if(method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            // empty array returns false 
            $this->params = $url ? array_values($url) : [];

            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl() {
            if(isset($_GET['url'])) {
                $url = $_GET['url'];
                $url = rtrim($url, '/');
                $url = explode('/', $url);
                return $url;
            }
        }
    }