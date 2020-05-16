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
use RLib\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity {

    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;

    public function getNickname(): string {
        return $this->nickname;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getIsConfirmed(): int {
        return $this->isConfirmed;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function getPasswordHash(): string {
        return $this->passwordHash;
    }

    public function getAuthToken(): string {
        return $this->authToken;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function setNickname(string $nickname) {
        $this->nickname = $nickname;
        return $this;
    }

    public function setEmail(string $email) {
        $this->email = $email;
        return $this;
    }

    public function setIsConfirmed(int $isConfirmed) {
        $this->isConfirmed = $isConfirmed;
        return $this;
    }

    public function setRole(string $role) {
        $this->role = $role;
        return $this;
    }

    public function setPasswordHash(string $passwordHash) {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function setAuthToken(string $authToken) {
        $this->authToken = $authToken;
        return $this;
    }

    public function setCreatedAt(string $createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    protected static function getTableName(): string {
        return "users";
    }

}

class Article extends ActiveRecordEntity {

    /** @var string */
    protected $name;

    /** @var string */
    protected $text;

    /** @var string */
    protected $authorId;

    public function getName(): string {
        return $this->name;
    }

    public function getText(): string {
        return $this->text;
    }

    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }

    public function setText(string $text) {
        $this->text = $text;
        return $this;
    }

    protected static function getTableName(): string {
        return 'articles';
    }

    /**
     * @return User
     */
    public function getAuthor(): User {
        return User::getById($this->authorId);
    }

}

//Проверяем класс ентити
$userId = 3;

$user = User::getById($userId);
//$user = new User();

if ($user === null) {
    echo 'errors/404.php';
    return;
}

//$user->setName('Новое название статьи');
//$user->setText('Новый текст статьи');
$user->setNickname("ramin2");
$user->setEmail("ramin2");



$user->save();

echo '<pre>';
var_dump($user);
