<?php
session_start();
if ($_SESSION['login_db'] == null or $_SESSION['pass_db'] == null) { ?>
    <script type="text/javascript">
        window.location.href = "bd.php";
    </script>
    <?php
    exit;
}

try {
    $login = $_SESSION['login_db'];
    $pass = $_SESSION['pass_db'];

    //Основное подкючение к БД
    $dbConnect = new PDO("mysql:host=194.67.218.12;dbname=task4b;charset=utf8;", $login, $pass);
    $countiresMass = $dbConnect->query('SELECT * FROM countriesName');

} catch (PDOException $exception) {

    $codePDO = $exception->getCode();

    //Если код ошибки - это неправильное название БД, то пытаемся создать БД
    if ($codePDO == 1049) {

        echo "База данных создаётся, ожидайте...";

        //Создание подключения для создания БД
        $dbConnectForCreateDB = new PDO("mysql:host=194.67.218.12;charset=utf8;", $login, $pass);
        $dbConnectForCreateDB_result = $dbConnectForCreateDB->query('CREATE DATABASE IF NOT EXISTS `task4b` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;');

        //Создание подключения для создания таблицы
        $dbConnectForTable = new PDO("mysql:host=194.67.218.12;dbname=task4b;charset=utf8;", $login, $pass);
        $dbConnectForTable_resutl = $dbConnectForTable->query('CREATE TABLE `countriesName` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `country_code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

        //Определение первичного ключа
        $dbConnectForPrimaryKeyID = new PDO("mysql:host=194.67.218.12;dbname=task4b;charset=utf8;", $login, $pass);
        $dbConnectForPrimaryKeyID_result = $dbConnectForPrimaryKeyID->query('ALTER TABLE `countriesName` ADD PRIMARY KEY( `id`);');

        //Определение первичного ключа
        $dbConnectForAutoIncrementID = new PDO("mysql:host=194.67.218.12;dbname=task4b;charset=utf8;", $login, $pass);
        $dbConnectForAutoIncrementID_result = $dbConnectForAutoIncrementID->query('ALTER TABLE `countriesName` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;');

        echo "<script>location.reload()</script>"; //Перезагрузка страницы после создания БД и таблицы

    }

    echo "<b>Ошибка подключения: </b>" . $exception->getMessage();
    echo "<b>Ошибка подключения: </b>" . $exception->getCode();

    die;
}
?>
<html>
<head>
    <link href="CSS/design.css" rel="stylesheet">
    <title>Страны</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        function addCountryInfo() {
            name_db = $("input[name='nameCountry']").val();
            code_db = $("input[name='codeCountry']").val();

            if (name_db == "" | code_db == ""){
                alert("Заполните вводимые данные!");
            } else {
                $.ajax({
                    type: "POST",
                    url: "add_country_bd.php",
                    data: {name_db: name_db, code_db: code_db},
                    success: function (data) {
                        $("#response").html(data);
                        alert("Страна добавлена!");
                        document.getElementsByName("nameCountry")[0].value = "";
                        document.getElementsByName("codeCountry")[0].value = "";
                        //$dbConnectForAddCountryInfo_result = $dbConnect->query('INSERT INTO countriesName (id, name, country_code) VALUES (NULL, '.$_POST['name'].', '. $_POST['country_code'].');');
                    }
                });
            }

            return false;
        }

        function getCountryList() {
            $.ajax({
                type: "POST",
                url: "get_countries_info_bd.php",
                success: function (data) {
                    $("#response_test").html(data);
                }
            });
            return false;
        }
    </script>
</head>
<hr>
<div id="addCountry_block">
    <table>
        <tr>
            <td>
                <input class="input" type='text' name='nameCountry' placeholder='Название страны'/>
            </td>
            <td>
                <input class="input" type='text' name='codeCountry' placeholder='Код страны'/>
            </td>
            <td>
                <button class="button" onClick="addCountryInfo()">Добавить</button>
            </td>
            <td>
                <button class="button" onClick="getCountryList()">Получить список</button>
            </td>
        </tr>
    </table>
</div>
<hr>
<div id="response_test"></div>
<div id="response"></div>
</body>
</html>