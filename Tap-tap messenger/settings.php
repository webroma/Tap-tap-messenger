<?php

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $uploadOk = 1; // Initialize uploadOk

    // File upload handling
    $target_file = $target_dir . basename($_FILES["file1"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!empty($_FILES["file1"]["name"])) {
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["file1"]["tmp_name"]);
        if ($check === false) {
            $errors[] = "Файл не является изображением.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["file1"]["size"] > 5000000) {
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
            if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)) {
                $picture_name = basename($_FILES["file1"]["name"]); // Store the filename for later use
            } else {
                $errors[] = "Ошибка при загрузке файла.";
            }
        }
    }

    if (empty($errors)) {
        // Data is valid, now you can save it (e.g., to a file, database)
        $postData = [
            'picture' => $picture_name,
        ];

        // Retrieve existing posts
        $posts = [];
        if (file_exists('avatarka.txt')) {
            $posts = json_decode(file_get_contents('avatarka.txt'), true) ?? []; // Decode JSON, handle empty file
        }

        $posts[] = $postData; // Add the new post

        // Encode and save the updated posts
        file_put_contents('avatarka.txt', json_encode($posts, JSON_PRETTY_PRINT));

        $_SESSION['success'] = 'Пост успешно опубликован!'; // Set a success flash message
        header('Location: settings.php'); // Redirect to the same page to prevent form resubmission
        exit();
    } else {
        $_SESSION['errors'] = $errors; // Store errors in the session
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css tap/style.css">
    <title>Tap-tap</title>
</head>
<body>
    <section class="profile1">
        <div class="border1">

            <div class="header">
                <button id="button-profile" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/main.php'";>Профиль</button>
                <button id="settings1" onclick="window.location.href='http://localhost/DEMO/Tap-tap%20messenger/settings.php'">Настройки</button>
        </div>
        <form method="post" enctype="multipart/form-data" class="set">
        <div class="avatar-css">
        <div class="avatar" id="avatar-image">
            <?php if (!empty($picture_name)): ?>
                <img id="preview" src="<?php echo htmlspecialchars($target_dir . $picture_name); ?>" alt="Image Preview" style="width: 200px; height: 200px; border: 1px solid #ccc; border-radius:300px;"/>
            <?php else: ?>
                <p>Аватарка не загружена.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="input__wrapper1">
        <input name="file1" type="file" id="file1" class="file1" accept="image/*">
        <label for="file1" class="input__file-button1">
            <span class="input__file-button-text1">Выберите аватарку</span>    <button type="submit" class="addavatar">Загрузить</button> 
        </label>
    </div>

</form>

        <div class="information">
        <div class="nick1">
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
            echo "<p id='email1'>Ваша почта: " . htmlspecialchars($user['email']) . "</p>";
        }else {
            echo "<p id='email1'>Ваша почта: </p>";
        } 
        
    }else {
            echo "<p id='email1'>Ваша почта: </p>";
        } 
}

?>
            </div>
            <?php
// Handle the form submission here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add-inf'])) {
        // Получаем информацию из POST-запроса
        $info = isset($_POST['info']) ? trim($_POST['info']) : '';

        // Проверка на пустоту поля
        if (!empty($info)) {
            // Инициализация существующей информации
            $existingInfo = [];

            // Читаем существующие данные из файла, если он существует
            if (file_exists('info.txt')) {
                $jsonContent = file_get_contents('info.txt');
                $existingInfo = json_decode($jsonContent, true) ?? []; // Декодируем JSON
            }
            
            // Добавляем новую информацию в массив
            $existingInfo[] = $info;

            // Сохраняем новый массив обратно в файл в формате JSON
            file_put_contents('info.txt', json_encode($existingInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
            
            // Очистим поле ввода после успешного сохранения, если это необходимо
            $_POST['info'] = ''; // Установка пустой строки в твой код.
        }
    }
}
?>
<div class="inf">
    <p id="aboutme">Добавить информацию:</p>
    <form method="POST" action="">
        <input type="text" id="add-inf" name="info" placeholder="Напишите что-нибудь" autocomplete="off" value="<?php echo isset($_POST['info']) ? htmlspecialchars($_POST['info'], ENT_QUOTES) : ''; ?>">
        <input type="submit" class="addinfo" name="add-inf" value="Сохранить">
    </form>
</div>
        </div> 
        </div>

    </section>
</body>
</html>