**Добавление нового лида в адресную книгу на SendPulse**

Установка:

composer.json:
```
"repositories": [
    {
      "type": "vcs",
      "url": "https://git.mega-dev.ru/develop/inner-modules/sendpulse"
    }
  ],
  "require":{
    "owl-verdant/sendpulse": "dev-main"
  }
```
`composer require owl-verdant/sendpulse:dev-main`

Пример использования:
```
use pulse\DocPulseService as pulse;

$sendPulse = new pulse($id,$secret);

$emails = array(
        array(
            'email' => $email,
            'variables' => array(
                'phone' => $phone,
                'name' => $name,
            )
        )
    );
    
$sendPulse->addLead($bookID, $emails)
```
