<?php

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; // Database handler
    private $stmt; // Statement

    public function __construct()
    {
        // Set the DSN (Data Source Name)
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";

        // Set options for the PDO connection
        $options = [
            PDO::ATTR_PERSISTENT => true, // Use persistent connections
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
        ];

        try {
            // Create a new PDO instance
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            // Log error secara internal, jangan expose ke user
            error_log("Database connection failed: " . $e->getMessage());
            die("Terjadi kesalahan koneksi database. Silakan hubungi administrator.");
        }
    }

    // Prepare a SQL statement
    public function prepare($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    // Bind a value to a parameter in the prepared statement
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            // Determine the type of the value
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute()
    {
        return $this->stmt->execute();
    }

    // Fetch all results as an associative array
    public function fetchAll()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single result as an associative array
    public function fetch()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get last insert id
    public function getLastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    // Alias for getLastInsertId()
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    // Get the row count
    public function rowCount()
    {
        // Pastikan statement sudah dieksekusi sebelum memanggil rowCount
        return $this->stmt->rowCount();
    }
}
