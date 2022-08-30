<?php
header("Content-Type: text/html; charset=utf-8");

function authenticate()
{
    header('WWW-Authenticate: Basic realm="Test Authentication System"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Вы должны ввести корректный логин и пароль для получения доступа к ресурсу \n";
    exit;
}

$door = ['admin' => 'owlpass'];
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    authenticate();
} else {
    if (empty($door[$_SERVER['PHP_AUTH_USER']]) || ($_SERVER['PHP_AUTH_PW'] !== $door[$_SERVER['PHP_AUTH_USER']])) {
        authenticate();
    } else {

        echo "<button class='sync'>Синхронизация</button>";
    }
}
?>

<script>
    document.querySelector(".sync").onclick = async function () {
        alert("Синхронизирую");
        let response = await fetch('/copyFiles.php');

        console.log(response);
        if (response.ok) {
            let json = await response.json();
            if (json.ok) {
                alert("Синхронизация завершена");
            }else {
                alert("Упс,что-то пошло не так");
            }
        } else {
            alert("Ошибка HTTP: " + response.status);
        }
    }
</script>
