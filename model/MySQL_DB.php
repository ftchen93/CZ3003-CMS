<?php

if (getenv('OPENSHIFT_APP_NAME') === false) {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'cz3003_web');
} else {
    define('DB_HOST', '127.4.122.130');
    define('DB_NAME', 'cz3003_web');
}
define('DB_USER', 'cz3003user');
define('DB_PWD', 'cz3003pwd');
define('DB_PORT', '3306');

class MySQL_DB {
    private static $connection;
    private static $current_query;

    private static function open_connection() {
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT);

        if (!$link) {
            echo "Error: Unable to connect to MySQL.<br/>";
            echo "Debugging errno: " . mysqli_connect_errno() . "<br/>";
            echo "Debugging error: " . mysqli_connect_error() . "<br/>";
            return;
        }

        self::$connection = $link;
    }

    private static function close_connection() {
        mysqli_close(self::$connection);
    }

    public static function check_connection() {
        if (!self::$connection) {
            echo "No open connection!";
        } else {
            echo "Connection open!";
            echo self::$connection;
        }
    }

    public static function get_error() {
        return mysqli_error(self::$connection);
    }

    public static function escape_str($input_str) {
        if (!self::$connection)
            self::open_connection();
        return mysqli_real_escape_string(self::$connection, $input_str);
    }

    // Need to call this when using SELECT Query
    public static function close_result($result) {
        if ($result !== FALSE)
            mysqli_free_result($result);
    }

    // Need to call this when using SELECT Query
    public static function fetch_row($result) {
        return mysqli_fetch_assoc($result);
    }

    public static function fetch_all_row($result){
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public static function affected_rows() {
        return mysqli_affected_rows(self::$connection);
    }

//    public static function num_rows($result) {
//        return $result->num_rows;
//    }

    public static function query($sql) {
        if (!self::$connection)
            self::open_connection();
        self::$current_query = $sql;
        $result = mysqli_query(self::$connection, $sql);
        /*
        Failure results in FALSE being returned.
        SELECT, SHOW, DESCRIBE or EXPLAIN queries will return mysqli_result object.
        Other successful queries will return TRUE.
        */
        if ($result === TRUE)
            $result = array(
                "success" => TRUE,
                "affected" => self::affected_rows()
            );

        return $result;
    }

    public static function getLastInsertID() {
        return mysqli_insert_id(self::$connection);
    }
}

?>
