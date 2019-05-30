<?php
session_start();
try {
    $login = $_SESSION['login_db'];
    $pass = $_SESSION['pass_db'];

    //Основное подкючение к БД
    $dbConnect = new PDO("mysql:host=194.67.218.12;dbname=task4b;charset=utf8;", $login, $pass);

    $dbConnectForAddCountryInfo_result = $dbConnect->prepare("INSERT INTO `countriesName` (`id`, `name`, `country_code`) VALUES (NULL, ?, ?);");
    $dbConnectForAddCountryInfo_result->execute(array($_POST['name_db'], $_POST['code_db']));
} catch (PDOException $exception) {

    echo "<b>Ошибка подключения: </b>" . $exception->getMessage();
    echo "<b>Ошибка подключения: </b>" . $exception->getCode();
    die;
}
?>
