<?php

namespace RLib\Models;

use RLib\Services\Db;

abstract class ActiveRecordEntity {
    //добавили protected-свойство ->id и public-геттер для него – у всех наших сущностей будет id, и нет необходимости писать это каждый раз в каждой сущности – можно просто унаследовать;

    /**
     * id ключ. PRİMARY_KEY
     * 
     * @var int */
    protected $id;

    /**
     * Метод Возврашает id ключ. PRİMARY_KEY
     * 
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    public function __set(string $name, $value) {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    /**
     * Метод забирает Название таблицы с метода getTableName() и название класса с static::class и составляет SQL запрос
     * Метод Возврашает все записи в базе по имени таблицы с Метода(getTableName()) Наследника
     * 
     * @return static[]
     */
    public static function findAll(): array {
        $db = new Db();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    /**
     * Метод Возврашает название таблицы в базе данных.
     * Этот метод должен реализовать каждый класс наследник.
     * 
     * @return string
     */
    abstract protected static function getTableName(): string;
}
