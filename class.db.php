<?php

/**
 * Creates unique database connection using credentials from base.App.php
 * with a singleton pattern
 */
class db
{

    /**
     * DB connection
     *
     * @var MySQL link
     */
    private $_connection = null;

    /**
     * Single instance of db class
     *
     * @var db
     */
    protected static $_instance = null;

    private $ignore_duplicates;

    /**
     * Returns the only of instance of DB class with connection
     *
     * @param $ignore_duplicates bool
     *
     * @staticvar database link $_instance
     * @return database link
     */
    public static function get( $ignore_duplicates = FALSE )
    {
        mysqli_report(MYSQLI_REPORT_STRICT);

        if ( self::$_instance == null )
        {
            try
            {
                self::$_instance = new db( $ignore_duplicates );
            }
            catch ( Exception $e )
            {
                echo '<p>Could not connect to database, please, double check your settings file and database credentials.</p>';
                exit( 'Error message: ' . $e->getMessage() );
            }
        }

        return self::$_instance;
    }

    /**
     * Creates database connection in MySQLi object
     * Forbids to create instance of this from the outside
     *
     * @param $ignore_duplicates bool
     */
    private function __construct( $ignore_duplicates )
    {
        $this->_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->_connection->query("SET NAMES utf8");
        $this->_connection->query("SET CHARACTER SET utf8");
        $this->_connection->set_charset('utf8');

        $this->ignore_duplicates = $ignore_duplicates;
    }

    /**
     * Forbids to create a copy of instance
     */
    private function __clone(){
    }

    /**
     * Returns MySQLi object
     *
     * @return MySQL connection
     */
    public function connection()
    {
        return $this->_connection;
    }

    /**
     * Returns MySQL resource result object
     *
     * @param $sql string
     *
     * @return MySQL resource
     */
    public function query( $sql )
    {
        $result = NULL;

        try
        {
            $result = $this->_connection->query( $sql );

            if( !$result )
                throw new Exception( $this->_connection->error );

        }
        catch ( Exception $e )
        {
            $timestamp = date( 'Y-m-d H:i:s' );

            $fp = fopen(PROJECT_PATH . 'export/sql_error.log', 'a+' );

            fwrite( $fp, "{$timestamp}: {$sql}\r\n" );
            fwrite( $fp, date( 'Y-m-d H:i:s' ) . ": " . $e->getMessage() . "\r\n" );
            fwrite( $fp, date( 'Y-m-d H:i:s' ) . ": {$sql}\r\n" );

            fclose($fp);

            if( stripos( $e->getMessage() , 'Duplicate entry' ) !== FALSE )
            {
                if( !$this->ignore_duplicates )
                {
                    if( DEBUG_MODE )
                        exit( json_encode( [ 'error' => 1 , 'type' => 'sql' , 'error_list' => [ $e->getMessage() ] , 'message' => $e->getMessage() , 'statement' => $sql ] ) );
                    else
                        return FALSE;
                }
            }
            else
            {
                if( DEBUG_MODE )
                    exit( json_encode( [ 'error' => 1 , 'type' => 'sql' , 'error_list' => [ $e->getMessage() ] , 'message' => $e->getMessage() , 'statement' => $sql ] ) );
                else
                    return FALSE;
            }
        }

        return $result;
    }
}
