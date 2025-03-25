<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css tap/style.css">
    <title>Tap-tap</title>
</head>
<body>
    <section class="profile">
        <div class="border">
        <div class="header">
        <button id="button-profile" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/main.php'";>Профиль</button>
            <button id="friends" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/friends.php'";>Друзья</button>                
            <button id="settings" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/settings.php'";>Настройки</button>
        </div>
        <div class="avatar-css">
        <div class="avatar">
        <?php
        // Display the avatar
    $target_dir = "uploads/"; // Define your target directory for uploads
    $picture_name = ''; // Initialize picture_name

    // Check if the file already exists
    if (file_exists('avatarka.txt')) {
        $posts = json_decode(file_get_contents('avatarka.txt'), true) ?? []; // Decode JSON, handle empty file
        if (!empty($posts)) {
            $lastPost = end($posts); // Get the last post
            $picture_name = $lastPost['picture']; // Get the picture name
        }
    }

    // Display the avatar image if it exists
    if (!empty($picture_name)) {
        echo "<div class='avatar'>";
        echo "<img src='" . htmlspecialchars($target_dir . $picture_name) . "' alt='Avatar' style='width: 200px; height: 200px; border: 1px solid #ccc; border-radius:300px;'/>";
        echo "</div>";
    } else {
        echo "<p>Аватарка не загружена.</p>";
    }
?>
        </div>
    </div>

        <div class="information">
        <div class="nick">
        <?php
session_start();

// Проверяем, есть ли никнейм в сессии
if (isset($_SESSION['nickname'])) {
    // Получаем никнейм из сессии
    $nickname = $_SESSION['nickname'];

    // Проверяем, существует ли файл users.txt
    if (file_exists('users.txt')) {
        // Декодируем JSON, обрабатываем пустой файл
        $users = json_decode(file_get_contents('users.txt'), true) ?? [];

        // Проверяем, существует ли пользователь с указанным никнеймом
        $userFound = false;
        foreach ($users as $user) {
            // Проверяем, существует ли ключ 'nickname'
            if (isset($user['nickname']) && $user['nickname'] === $nickname) {
                $userFound = true;
                break; // Прекращаем цикл, если нашли пользователя
            }
        }

        // Если пользователь найден, выводим его никнейм, иначе выводим сообщение об ошибке
        if ($userFound) {
            echo "<p id='nickname'>" . htmlspecialchars($nickname) . "</p>";
        } else {
            echo "<p id='error'>Ошибка: пользователь с никнеймом '$nickname' не найден.</p>";
        }
    } else {
        // Если файл не существует, выводим сообщение об ошибке
        echo "<p id='error'>Ошибка: файл пользователей не найден.</p>";
    }
} else {
    // Если никнейм не установлен, выводим сообщение об ошибке
    echo "<p id='error'>Ошибка: пользователь не вошёл в систему.</p>";
}
?>

        </div>
            <div class="inform-head">
            </div>

            <div class="mail">
            <?php

// Проверяем, есть ли email в сессии
if (isset($_SESSION['email'])) {
    // Получаем email из сессии
    $email = $_SESSION['email'];

    // Проверяем, существует ли файл users.txt
    if (file_exists('users.txt')) {
        // Декодируем JSON, обрабатываем случай пустого файла
        $users = json_decode(file_get_contents('users.txt'), true) ?? [];

        // Проверяем, существует ли пользователь с указанным email
        $userFound = false;
        foreach ($users as $user) {
            // Проверяем, существует ли ключ 'email'
            if (isset($user['email']) && $user['email'] === $email) {
                $userFound = true;
                break; // Прекращаем цикл, если нашли пользователя
            }
        }

        // Если пользователь найден, выводим его email, иначе выводим сообщение об ошибке
        if ($userFound) {
            echo "<p id='email'>Ваша почта: " . htmlspecialchars($user['email']) . "</p>";
        }else {
            echo "<p id='email'>Ваша почта: </p>";
        } 
        
    }else {
            echo "<p id='email'>Ваша почта: </p>";
        } 
}
?>
            </div>
            <div class="inf">
                <p id="aboutme">Информация о себе: </p>
            </div>
        </div> 
        </div>

    </section>
    <section class="main">
        <div class="main-border">
             <div class="main-header">
             <button id="button-chat" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/main.php'";>Чаты</button>
             <button id="group1" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/communities.php'";>Сообщества</button>
             <button id="news" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/news.php'";>Новости</button>

        </div>
        <div class="contact-div">
            <div class="asd">
                            <div class="avatarka"></div>
            <div class="name"><p class="nickname">nickname</p></div>
            </div>

        </div>
        <div class="find">
            <input type="text" id="find-input" placeholder="Поиск">
        </div>
        <div class="scroll-contact">
            
        </div>
        <div class="findcont">
            <p class="netcont">На данный момент нет доступных сообществ.<br>Не переживайте!<br> Используйте поиск, чтобы добавить нужные сообщества. <br> Либо вы можете сделать своё сообщество.</p>
        </div>
        <div class="inp-msg">
            <input type="text" id="message" placeholder="Напишите сообщение...">
        </div>
    </div>
</section>
    <script src="script.js"></script>
</body>
</html>