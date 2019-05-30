<?php
session_start();
global $dbConnect;

try {
    $dbConnect = new PDO("mysql:host=194.67.218.12;dbname=task4b;charset=utf8;", $_POST['login_db'], $_POST['pass_db']);
    $_SESSION['login_db'] = $_POST['login_db'];
    $_SESSION['pass_db'] = $_POST['pass_db'];
    if ($_SESSION['login_db'] != null and $_SESSION['pass_db'] != null) { ?>
        <script type="text/javascript">
            window.location.href = "index.php";
        </script>
        <?php
        exit;
    }

} catch (PDOException $exception) {
    echo "<b>Ошибка подключения: </b>" . $exception->getMessage();
    die;
}