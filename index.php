<?php

// __autoload ( string $class ) : void — Попытка загрузить неопределенный класс - Внимание Данный функционал объявлен УСТАРЕВШИМ, начиная с PHP 7.2.0 и его использование крайне не рекомендовано.   -> https://www.php.net/manual/ru/function.autoload.php
// spl_autoload_register — Регистрирует заданную функцию в качестве реализации метода __autoload() -> https://www.php.net/manual/ru/function.spl-autoload-register.php
//bu ne ucundur her defe yeni object ve model Classlarimizi sisteme include etmemek ucun onlari lazim gelende sistem ozu yukleyir.
spl_autoload_register(function (string $className) {
    //это для демонстрации
    //echo "<br>loader is load class= $className";
    require_once __DIR__ . '/' . $className . '.php';
});

//use в этой стате описано что это и счем едят))) -> https://webshake.ru/oop-v-php-prodvinutyj-kurs/namespace-i-avtozagruzka-klassov-v-php
use RLib\Services\Db;

$db = Db::getInstance();
$query = $db->query("select * from client");

echo "<pre>";
print_r($query);
