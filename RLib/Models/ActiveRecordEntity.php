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
     * Метод, который будет преобразовывать строки типа authorId в author_id.
     * Это можно сделать с помощью регулярного выражения: перед каждой заглавной буквой мы добавляем символ подчеркушки «_», а затем приводим все буквы к нижнему регистру:
     * 
     * @param string $source
     * @return strings
     */
    private function camelCaseToUnderscore(string $source): string {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    /**
     * Метод прочитает все свойства объекта и создаст массив вида:
     * 
     * [
     * 'название_свойства1' => значение свойства1,
     * 'название_свойства2' => значение свойства2
     * ]
     * 
     * Metod Obyektin butun Propertilerini oxuyur ve ashagida gosterilen massiv formasinda qaytarir
     * 
     * [
     * '1_ci_properti_adi' => 1_ci_properti_dəyəri,
     * '2_ci_properti_adi' => 1_ci_properti_dəyəri
     * ]
     * 
     * @return array
     */
    public function mapPropertiesToDbFormat(): array {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    /**
     * Метод забирает Название таблицы с метода getTableName() и название класса с static::class и составляет SQL запрос
     * Метод Возврашает все записи в базе по имени таблицы с Метода(getTableName()) Наследника
     * 
     * @return static[]
     */
    public static function findAll(): array {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    /**
     * Метод Возврашает название таблицы в базе данных.
     * Этот метод должен реализовать каждый класс наследник.
     * 
     * @return string
     */
    abstract protected static function getTableName(): string;

    /**
     * Этот метод вернёт либо один объект, если он найдётся в базе, либо null – что будет говорить об его отсутствии.
     * ->> https://webshake.ru/oop-v-php-prodvinutyj-kurs/pattern-singleton-v-php
     * 
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self {
        $db = Db::getInstance();
        $entities = $db->query(
                'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
                [':id' => $id],
                static::class
        );
        return $entities ? $entities[0] : null;
    }

}
