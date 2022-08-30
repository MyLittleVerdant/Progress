Универсальный обработчик форм для записи в гугл таблицы и отправки писем на почту

# Таблицы

Структура запроса для записи:

```javascript

let formData = new FormData();
formData.append('spreadsheetId', '1bQ6Z6UoMXBvN0yhtUwvPZVRcN8yMUIT1VtFjNIEzQ');
formData.append('range', 'Лист1!A14'); // Только страница для вставки в конец,либо с ячейкой для указания старта
formData.append('column', 'true'); // для записи по вертикали,по умолчанию по горизонтали

let values = [
    ["Eric", "3", "3", "3", "3"],
    [], //Пустой массив для пропуска строки 
    ["Stan", "4", "3", "4", "3"]
]
formData.append('data', JSON.stringify(values));

await fetch('/form-handler/writeToTable.php', {
    method: 'POST',
    body: formData
});

}
```

При успешной запси возврашается объект со следующей структурой:

```json
{
  "spreadsheetId": string,
  "tableRange": string,
  "updates": {
    object
    (UpdateValuesResponse)
  }
}
```

# Письма

Структура запроса для отправки писем:

```javascript

document.querySelector(".mail").onclick = async function () {
    let data = new FormData();
    data.append('username', 'formhandler@testers-site.ru');
    data.append('password', 'P3jaX&%S');
    data.append('from', 'formhandler@testers-site.ru');
    data.append('fromName', 'formhandler');
    data.append('to', 'a.podgornyak@owlagency.ru');
    data.append('html', 'false'); //Обработка html тегов, по дефолту (false) экранирование
    data.append('subject', 'test');
    data.append('message', "<h1> Это учебная тревога</h1>Повторяю,это учебная тревога");


    await fetch('/form-handler/sendMail.php', {
        method: 'POST',
        body: data,
    });
```

При успешной отправке возврашается true
