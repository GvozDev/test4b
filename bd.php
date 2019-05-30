<?php
session_start();
if ($_SESSION['login_db'] != null and $_SESSION['pass_db'] != null) { ?>
    <script type="text/javascript">
        window.location.href = "index.php";
    </script>
    <?php
    exit;
}
?>
<html>
<head>
    <link href="CSS/design.css" rel="stylesheet">
    <title>Подключение к БД</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript">

        function sendAuthData() {
            login_db = $("input[name='login']").val();
            pass_db = $("input[name='password']").val();

            if (login_db == "" | pass_db == ""){
                alert("Заполните вводимые данные!");
            } else {
                $.ajax({
                    type: "POST",
                    url: "service_bd.php",
                    data: {login_db: login_db, pass_db: pass_db},
                    success: function (data) {
                        $("#response").html(data);
                    }
                });
            }

            return false;
        }
    </script>
</head>
<body>
<hr>
<div id="authForm_block">
    <table class="authForm">
        <tr>
            <th>Авторизация в БД</th>
        </tr>
        <tr>
            <td>
                <input class="input" type='text' name='login' placeholder='Логин' value="<?=htmlspecialchars($_POST["login_db"])?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <input class="input" type='password' name='password' placeholder='Пароль' value="<?=htmlspecialchars($_POST["pass_db"])?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <button class="button" onClick="sendAuthData()">Авторизоваться</button>
            </td>
        </tr>
    </table>
</div>
<hr>
<div id="response"></div>
</body>
</html>