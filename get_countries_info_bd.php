<?php
session_start();
try {
    $login = $_SESSION['login_db'];
    $pass = $_SESSION['pass_db'];

    //Основное подкючение к БД
    $dbConnect = new PDO("mysql:host=194.67.218.12;dbname=task4b;charset=utf8;", $login, $pass);

    $countiresMass = $dbConnect->query('SELECT * FROM countriesName ORDER BY `countriesName`.`name` ASC');

    ?>
        <div class="countiesList_block">
            <table class="countiesList">
                <tr>
                    <th>Название страны</th>
                    <th>Код страны</th>
                </tr>
        <?php foreach ($countiresMass as $countyInfo): ?>
                <tr>
                    <td>
                        <p><?= htmlspecialchars($countyInfo["name"]); ?></p>
                    </td>
                    <td>
                        <p><?= htmlspecialchars($countyInfo["country_code"]); ?></p>
                    </td>
                </tr>
        <?php endforeach; ?>
            </table>
        </div>
    <?php

} catch (PDOException $exception) {

    echo "<b>Ошибка подключения: </b>" . $exception->getMessage();
    echo "<b>Ошибка подключения: </b>" . $exception->getCode();
    die;
}
?>