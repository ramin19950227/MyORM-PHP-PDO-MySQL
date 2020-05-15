<?php

namespace Services;

/**
 * Паттерн Singleton в PHP
 * Класс для подключения к базе данных MySQL и выполнения запросов с помошью PDO. 
 * Класс берет данные с файла настроек который возврашает массив данных
 * 
 */
class Db {

    private static $instance;

    /** @var \PDO */
    private $pdo;

    private function __construct() {
        $dbOptions = (require __DIR__ . '/../settings.php')['db'];

        $this->pdo = new \PDO(
                'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
                $dbOptions['user'],
                $dbOptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): array {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    /**
     * Метод Возврашает Обьект этого же класса исли он создан заранее 
     * в обратном случае создает и возврашает новый обьект 
     * тем самым предотврашает повторное создание обьекта
     * 
     * @return \self
     */
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

}
