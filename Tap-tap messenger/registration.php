<?php
session_start();

// Если это POST-запрос, то есть мы нажали на кнопку "Регистрация", выполняем процесс регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // В этот массив будем собирать возможные ошибки
    $errors = [];
    
    // Валидируем email
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    if (empty($email)) {
        $errors[] = 'Введите email';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Неверный email';
    }
    $nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : null;
    if (empty($email)) {
        $errors[] = 'Введите nickname';
    }
    if (strlen($nickname) < 3 || strlen($nickname) > 50) {
        $errors[] = 'Никнейм должен содержать не менее 6 и не более 50 символов';
    }
    // Валидируем пароль
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    if (empty($password)) {
        $errors[] = 'Введите пароль';
    }
    if (strlen($password) < 6 || strlen($password) > 50) {
        $errors[] = 'Пароль должен содержать не менее 6 и не более 50 символов';
    }
    
    // Проверяем, правильно ли пользователь подтвердил пароль
    $passwordRepeat = isset($_POST['password_repeat']) ? trim($_POST['password_repeat']) : null;
    if ($password !== $passwordRepeat) {
        $errors[] = 'Пароль подтвержден неверно';
    }

    // Если ошибок нет, продолжаем
    if (empty($errors)) {
        // Инициализируем переменные
        $userData = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT), // Хешируем пароль
            'nickname' => $nickname
        ];

        // Читаем существующих пользователей
        $users = [];
        if (file_exists('users.txt')) {
            $users = json_decode(file_get_contents('users.txt'), true) ?? []; // Декодируем JSON, обрабатываем пустой файл
        }

        // Проверка на существование email
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                $errors[] = 'Пользователь с таким email уже существует';
                break; // Выход из цикла, если email уже существует
            }
        }

        // Если email уникальный, добавляем нового пользователя
        if (empty($errors)) {
            $_SESSION['nickname'] = $nickname; // Сохраняем никнейм в сессию
            $_SESSION['email'] = $email;
            $users[] = $userData; // Добавляем нового пользователя
            // Кодируем и сохраняем обновленных пользователей
            file_put_contents('users.txt', json_encode($users, JSON_PRETTY_PRINT));
        
            // Перенаправляем на страницу авторизации
            header('Location: login.php');
            exit();
        }
    }

    // В случае наличия ошибок выводим их на страницу
    $_SESSION['errors'] = $errors;
}

// Retrieve errors from the session
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']); // Clear errors after retrieving
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Homepage</title>
</head>
<body>
<section class="container w-25">

    <form method="post" action="registration.php" style="display: grid; margin-top: 200px">
            <h2 style="display: grid;justify-content: center;">Регистрация</h2>
            <div class="form-group">
            <label for="nickname">Nickname</label>
            <input type="text" name="nickname" class="form-control" id="nickname" placeholder="Enter nickname" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="on">
        </div>
        <div class="form-group">
            <label for="password-repeat">Повторите пароль</label>
            <input type="password" name="password_repeat" class="form-control" id="password-repeat"
                   placeholder="Repeat password" autocomplete="on">
        </div>
        <button type="submit" class="btn btn-primary">Регистрация</button>
    </form>
</section>
</body>
</html>