<?php

class DB {
    private static $instance = null;

    public static function connect(array $config) {
        $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8';
        self::$instance = new PDO($dsn, $config['db_user'], $config['db_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
    }

    protected static function getInstance() {
        if (!self::$instance) {
            throw new Exception('Database non connesso. Chiama prima DB::connect.');
        }
        return self::$instance;
    }

    public static function query(string $sql, array $data = []) {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($data);
        return $stmt;
    }

    public static function rows(string $sql, array $data = []) {
        return self::query($sql, $data)->fetchAll();
    }

    public static function row(string $sql, array $data = []) {
        return self::query($sql, $data)->fetch();
    }
}
