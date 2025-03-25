<?php
// Инициализируем сессию
session_start();

// Функция проверки, авторизован ли пользователь
function isLoggedIn() {
    return isset($_SESSION['user_id']) && $_SESSION['user_id'];
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
          <link rel="stylesheet" type="text/css" href="style1.css">
    <title>Homepage</title>
</head>
<body>
    <article class="container">
        <h1>Homepage</h1>

        <!-- Отображаем различные кнопки, в зависимости от того, авторизован ли пользователь -->
         <div class="button">
                    <?php if (isLoggedIn()) { ?>
            <a href="logout.php" class="btn btn-secondary">Выйти</a>
        <?php } else { ?>
            <a href="registration.php" class="btnbtn-primary">Регистрация</a>
            <a href="login.php" class="btnbtn-primary">Авторизация</a>
        <?php }  ?>
         </div>

    </article>
</body>
</html>