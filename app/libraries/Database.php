<?php
    /*
     * PDO Database Class
     * Connect to db
     * Created prepared statements
     * Bind values
     * Return rows as results
     */

    class Database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;
        // database source name
        private $dsn;
        // db handler
        private $dbh;
        // statement
        private $stmt;
        // error
        private $error;

        public function __construct() {
            // DSN
            $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try {
                $this->dbh = new PDO($this->dsn, $this->user, $this->pass);

            } catch(PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        // Prepare statement with query
        public function query($sql) {
            $this->stmt = $this->dbh->prepare($sql);
        }

        // Bind values
        public function bind($param, $value, $type = null) {
            // if type undefined 
            if(is_null($type)) {
                // set type according to the value
                switch(true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_string($value):
                        $type = PDO::PARAM_STR;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    default:
                        $type = PDO::PARAM_NUL;
                }
            }

            $this->stmt->bindValue($param, $value, $type);
        }
        
        // Execute the prepared statement
        public function execute() {
            return $this->stmt->execute();
        }

        // Get result set as array of objects
        public function resultSet() {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        } 

        // Get single record as object
        public function single() {
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // Get row count
        public function rowCount() {
            return $this->stmt->rowCount();
        }
    }