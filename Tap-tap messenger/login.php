<?php
session_start();

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : null;
    if (empty($nickname)) {
        $errors[] = 'Введите nickname';
    }

    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    if (empty($password)) {
        $errors[] = 'Введите пароль';
    }

    // Если ошибок нет, продолжаем
    if (empty($errors)) {
        // Читаем существующих пользователей
        $users = [];
        if (file_exists('users.txt')) {
            $users = json_decode(file_get_contents('users.txt'), true) ?? []; // Декодируем JSON, обрабатываем пустой файл
        }

        // Флаг для проверки существования пользователя
        $userFound = false;

        foreach ($users as $user) {
            if ($user['nickname'] === $nickname) {
                $userFound = true; // Пользователь найден
                // Проверяем, совпадает ли пароль
                if (password_verify($password, $user['password'])) {
                    // Если пароли совпадают, сохраняем данные пользователя в сессии
                    $_SESSION['user_id'] = $user['id'] ?? null; // Если id не сохранён в JSON, тут будет null, можно не сохранять
                    $_SESSION['nickname'] = $user['nickname'];
                    $_SESSION['email'] = $user['email'];
                    // Перенаправляем на главную страницу
                    header('Location: http://localhost/DEMO/Tap-tap messenger/main.php'); 
                    exit;
                } else {
                    // Если пароли не совпадают, добавляем сообщение об ошибке
                    $errors[] = 'Неправильный пароль';
                }
            }
        }

        // Если пользователь не найден, добавляем сообщение
        if (!$userFound) {
            $errors[] = 'Пользователь не найден';
        }
    } 
}

// Здесь вы можете обработать вывод сообщений об ошибках на главной странице входа 
// Например:
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
<section class="container w-25">

    <form method="post" style="display: grid; margin-top: 200px">
            <h2 style="display: grid;justify-content: center;">Авторизация</h2>
        <div class="form-group">
            <label for="email">Nickname</label>
            <input type="text" name="nickname" class="form-control" id="nickname" placeholder="Enter nickname" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="on">
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</section>
</body>
</html>