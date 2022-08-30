<?php
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', E_ALL);
?>
<button class="table">Клик</button>

<script>
    document.querySelector(".table").onclick = async function () {
        let formData = new FormData();
        formData.append('spreadsheetId', '1bQ6Z6UoMXBvN0yhtUwvPZVRcNByMUIT1VtFjNIEzQ');
        formData.append('range', 'Лист1!A14');
        formData.append('column', 'true');

        let values = [
            ["Eric", "3", "3", "3", "3"],
            [],
            ["Stan", "4", "3", "4", "3"]
        ]
        formData.append('data', JSON.stringify(values));

        let response = await fetch('/form-handler/writeToTable.php', {
            method: 'POST',
            body: formData
        })

        let result = await response.json();
        console.log(result);
    }

</script>