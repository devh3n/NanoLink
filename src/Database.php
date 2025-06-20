<?php

namespace N3x74;

use Medoo\Medoo;

class Database
{
    private static ?Medoo $db = null;
    private static string $databaseFile = __DIR__ . "/../database/database.sqlite";
    private static string $databaseDir = __DIR__ . "/../database/";

    public static function connect(): Medoo
    {
        if (!self::$db)
        {
            if (!is_dir(self::$databaseDir))
            {
                mkdir(self::$databaseDir);
            }
            
            self::$db = new Medoo([
                'type' => "sqlite",
                'database' => self::$databaseFile,
                'charset' => 'utf8mb4'
            ]);
        }

        if (!file_exists(self::$databaseFile) || filesize(self::$databaseFile) == 0)
        {
            $sql = <<<SQL
                CREATE TABLE IF NOT EXISTS urls (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    url TEXT NOT NULL,
                    code TEXT NOT NULL
                );
            SQL;

            self::$db->pdo->exec($sql);
        }

        return self::$db;
    }
}
