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
        <div class="main-border1">
             <div class="main-header">
             <button id="button-chat" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/main.php'";>Чаты</button>
             <button id="group1" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/communities.php'";>Сообщества</button>
             <button id="news" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/news.php'";>Новости</button>

        </div>
        <?php

$name = $_POST['text'] ?? null; // Use null coalescing operator for cleaner code
$info = $_POST['info'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $name = trim($name); // Trim whitespace

    if (empty($name)) {
        $errors[] = 'Введите название поста';
    }

    // File upload handling
    $target_dir = "uploads/"; // Directory where uploaded files will be stored
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $picture_name = ''; // Initialize picture_name

    if (!empty($_FILES["file"]["name"])) {
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check === false) {
            $errors[] = "Файл не является изображением.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["file"]["size"] > 5000000) {
            $errors[] = "Файл слишком большой. Максимальный размер - 5MB.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedExtensions)) {
            $errors[] = "Разрешены только JPG, JPEG, PNG и GIF файлы.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $picture_name = basename($_FILES["file"]["name"]); // Store the filename for later use
            } else {
                $errors[] = "Ошибка при загрузке файла.";
            }
        }
    }

    if (empty($errors)) {
        // Data is valid, now you can save it (e.g., to a file, database)
        // For this example, we'll save to a file.
        $postData = [
            'name' => $name,
            'info' => $info,
            'picture' => $picture_name,
            'timestamp' => time() + 14400 // Добавляем 4 часа (4 * 60 * 60 секунд)
        ];

        // Retrieve existing posts
        $posts = [];
        if (file_exists('posts.txt')) {
            $posts = json_decode(file_get_contents('posts.txt'), true) ?? []; // Decode JSON, handle empty file
        }

        $posts[] = $postData; // Add the new post

        // Encode and save the updated posts
        file_put_contents('posts.txt', json_encode($posts, JSON_PRETTY_PRINT));

        $_SESSION['success'] = ''; // Set a success flash message
        header('Location: news.php'); // Redirect to the same page to prevent form resubmission
        exit();
    } else {
        $_SESSION['errors'] = $errors; // Store errors in the session
    }
}

// Retrieve errors from the session
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']); // Clear errors after retrieving

// Retrieve success message from the session
$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... ваш существующий код ...

    // Проверка на удаление всех постов
    if (isset($_POST['delete_posts'])) {
        if (file_exists('posts.txt')) {
            unlink('posts.txt'); // Удалить файл с постами
            $_SESSION['success'] = 'Все посты успешно удалены!'; // Успешное уведомление
        } else {
            $_SESSION['errors'][] = 'Нет постов для удаления.'; // ⁡⁣⁣⁢Сообщение об ошибке⁡
        }
        header('Location: news.php'); // Перенаправление после удаления
        exit();
    }

}
?>
                <?php

            // Display Existing Posts
            if (file_exists('posts.txt')) {
                $posts = json_decode(file_get_contents('posts.txt'), true) ?? [];

                if (!empty($posts)) {
                    echo "<div class='post-container' >";
                    foreach ($posts as $post) {
                        echo "<div class='post' style='display:grid; justify-content:center;'>";
                        echo "<div style='word-break: break-all; width: 800px;justify-content: center;display:flex;'><h3>" . htmlspecialchars($post['name']) . "</h3></div>";
                        if (!empty($post['picture'])) {
                            echo "<div style='max-width: auto; justify-content: center; display:flex;'><img src='uploads/" . htmlspecialchars($post['picture']) . "' alt='Post Image' style='width: 800px; max-height: 800px;'></div>";
                        }
                        echo "<div style='word-break: break-all; margin-top: 20px;width:800px;'><div style='word-break: break-all; width: 800px; '></div>" . nl2br(htmlspecialchars($post['info'])) . "</div>";
                        echo "<p class='post-date' style='justify-content: center;display: flex;'>". date("Y-m-d H:i:s", $post['timestamp']) ."</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            }
            ?>                
            


    </section>            
            <div class="intopost">
 
                <div class="button-cont">


                <form action="news.php" method="POST" enctype="multipart/form-data">
                </div>
                <div class="input1" style = "margin-left: -560px; margin-right: 60px;">
                    <?php if ($success): ?>
                        <div class="success-message" style="color: green;"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errors)): ?>
                        <div class="error-messages" style="color: red;">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <input type="text" id ='text' name = "text" placeholder="Название поста" value="<?= htmlspecialchars($name) ?>" autocomplete="off">
                    <div class="input__wrapper">
                        <input name="file" type="file" id="file" class="file" multiple value="<?= htmlspecialchars($post['picture']) ?>">
                        <label for="file" class="input__file-button">
                        <span class="input__file-button-text">Выберите картинку (не обязательно)</span>
                        </label>
                        </div>
                    <textarea name="info" id="info" placeholder="Введите текст" autocomplete="off"><?= htmlspecialchars($info) ?></textarea>
                    <button type="submit" class= "public" style="margin-bottom: -12px;">Опубликовать</button>
                </div>
            </div>
            </form>
           
        </div> 
        <div class="div-add">
                 <button type="button" class ="add">
        <div class="first-palochka"></div>
        <div class="second-palochka"></div>
    </button>   
        </div>

</section>

    <script src="script.js"></script>
</body>
</html>