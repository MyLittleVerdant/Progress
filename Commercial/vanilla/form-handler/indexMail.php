<?php

ini_set('default_charset', 'UTF-8');
ini_set('display_errors', E_ALL);
?>
<button class="mail">Клик</button>

<script>
    document.querySelector(".mail").onclick = async function () {
        let data = new FormData();
        data.append('username', 'formhandler@testers-site.ru');
        data.append('password', 'P3jaX&%S');
        data.append('from', 'formhandler@testers-site.ru');
        data.append('fromName', 'formhandler');
        data.append('to', 'a.podgornyak@owlagency.ru');
        data.append('html', 'true');
        data.append('subject', 'test');
        data.append('message', "<h1> Это учебная тревога</h1>Повторяю,это учебная тревога");


        let response = await fetch('/form-handler/sendMail.php', {
            method: 'POST',
            body: data,
        });
        let result = await response.json();
        console.log(result);
    }

</script>