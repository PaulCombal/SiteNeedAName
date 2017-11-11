<?php
    class Db {
        // The database connection
        protected static $connection;

        /**
         * Connect to the database
         * 
         * @return bool false on failure / mysqli MySQLi object instance on success
         */
        public function connect() {    
            // Try and connect to the database
            if(!isset(self::$connection)) {
                // Load configuration as an array. Use the actual location of your configuration file
                mysqli_report(MYSQLI_REPORT_STRICT);
                $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/conf/db.conf.ini');
                self::$connection = new mysqli('localhost', $config['user'], $config['password'], $config['database']);
            }

            // If connection was not successful, handle the error
            if(self::$connection === false) {
                // Handle error - notify administrator, log to a file, show an error screen, etc.
                return false;
            }
            return self::$connection;
        }

        /**
         * Query the database
         *
         * @param $query The query string
         * @return mixed The result of the mysqli::query() function
         */
        public function query($query, $mode = MYSQLI_STORE_RESULT) {
            // Connect to the database
            $connection = $this -> connect();

            // Query the database
            $result = $connection -> query($query, $mode);
            if ($connection -> more_results()) {
                $connection -> next_result();
            }

            return $result;
        }

        /**
         * Fetch rows from the database (SELECT query)
         *
         * @param $query The query string
         * @return bool False on failure / array Database rows on success
         */
        public function select($query, $mode = MYSQLI_STORE_RESULT) {
            $rows = array();
            $result = $this -> query($query, $mode);
            if($result === false) {
                return false;
            }
            while ($row = $result -> fetch_assoc()) {
                $rows[] = $row;
            }
            
            $result -> close();

            return $rows;
        }

        /**
         * Fetch the last error from the database
         * 
         * @return string Database error message
         */
        public function error() {
            $connection = $this -> connect();
            return $connection -> error;
        }

        /**
         * Quote and escape value for use in a database query
         *
         * @param string $value The value to be quoted and escaped
         * @return string The quoted and escaped string
         */
        public function quote($value) {
            $connection = $this -> connect();
            return "'" . $connection -> real_escape_string($value) . "'";
        }
    }
?>