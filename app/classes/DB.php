<?php

namespace App;

use PDO;

class DB extends PDO
{
    /**
     * Path to DB source file to seed trips table
     */
    const DB_SOURCE_FILE = './trips.csv';

    /**
     * @var PDO
     */
    private static PDO $instance;

    /**
     * Path to sqlite database
     *
     * @var string
     */
    private static string $engine = './databases/mydb.sq3';

    /**
     * PDO options
     *
     * @var array
     */
    private static $options = [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    /**
     * Function gets an instance of the Database
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (!isset(self::$instance))
        {
            self::$instance = new PDO(
                'sqlite:' . dirname(__DIR__) . self::$engine,
                null,
                null,
                self::$options
            );
        }

        return self::$instance;
    }

    /**
     * Trips table seeder
     *
     * @return bool
     */
    public static function seedDB(): bool
    {
        $handle = fopen(self::DB_SOURCE_FILE, "r");
        try {
            self::getInstance()->query('
                CREATE TABLE IF NOT EXISTS trips (
                    id INTEGER, 
                    driver_id INTEGER, 
                    pickup DATETIME, 
                    dropoff DATETIME);
            ');

            $query = self::getInstance()->prepare('        
                INSERT INTO trips (                                      
                    id, driver_id, pickup, dropoff
                ) VALUES (
                    ?, ?, ?, ?         
                )
            ');

            fgets($handle);

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $query->execute($data);
            }

            fclose($handle);
            echo 'Data successfully imported';

            return true;
        } catch(\PDOException $exception) {
            echo(json_encode(['outcome' => false, 'message' => $exception->getTrace()]));

            return false;
        }
    }
}