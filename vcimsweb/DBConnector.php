<?php

/**
 * Created by PhpStorm.
 * User: kepler
 * Date: 12/25/2015
 * Time: 8:42 PM
 */
class DBConnector
{
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
   // OLD DATABASE VARIABLE DEFINE 
    // private static $servername = "database-1.c1mggasso0hp.ap-south-1.rds.amazonaws.com";
    // private static $username = "qcsrdsadmin";
    // private static $password = "Pa7du#ah$098";
    // private static $conn = null;



    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $conn = null;

// Create connection

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public
    static function getDBInstance()
    {
        if (!self::$conn) {
            self::$conn = mysqli_connect(self::$servername, self::$username, self::$password);
        }
// Check connection
        if (!self::$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{
            mysqli_select_db(self::$conn,"vcims");
        }

        return self::$conn;

    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    private
    function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private
    function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private
    function __wakeup()
    {
    }
}


?>
