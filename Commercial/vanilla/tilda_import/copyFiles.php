<?php
$realm = 'Запретная зона';

//user => password
$users = array('admin' => 'mypass', 'guest' => 'guest');


if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Digest realm="'.$realm.
           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

    die('Текст, отправляемый в том случае, если пользователь нажал кнопку Cancel');
}


// анализируем переменную PHP_AUTH_DIGEST
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']]))
    die('Неправильные данные!');


// генерируем корректный ответ
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response)
    die('Неправильные данные!');


// функция разбора заголовка http auth
function http_digest_parse($txt)
{
    // защита от отсутствующих данных
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

/**
 * Копирует в корень структуру из папки /origin с заменой в html id метрики по соответствию $pageID=>$metrikaID массива $pages
 */
include 'tilda-php/classes/Tilda/LocalProject.php';
include 'tilda-php/classes/Tilda/Api.php';

//$config = Cfg::getInstance();
//$pages = $config->get('pages');
$config = include 'config.php';
$pages = $config['pages'];

synchronization($config['TILDA_PUBLIC_KEY'], $config['TILDA_SECRET_KEY'], $config['TILDA_PROJECT_ID']);
copyStructure($pages);

function copyStructure($pages)
{
    $source = null;
    $dest = null;

    foreach (scandir("origin") as $item) {
        switch ($item) {
            case 'css':
                $source = "origin/css/";
                $dest = "css";
                break;
            case 'images':
                $source = "origin/images/";
                $dest = "images";
                break;
            case 'js':
                $source = "origin/js/";
                $dest = "js";
                break;
            case '.':
            case '..':
            case 'meta':
                break;
            default:
                $html = file_get_contents('origin/' . $item);
                $id = intval(preg_replace('/[^0-9]+/', '', $item));
                $html = preg_replace('/mainMetrikaId = (\d*)/', 'mainMetrikaId = ' . $pages[$id]['metrikaID'],
                    $html);
                if (!file_exists($pages[$id]['path'])) {
                    mkdir($pages[$id]['path'], 0755);
                }
                $res = file_put_contents($pages[$id]['path'] . DIRECTORY_SEPARATOR . $item, $html);
                file_put_contents($pages[$id]['path'] . DIRECTORY_SEPARATOR . '.htaccess', "RewriteEngine on
                RewriteCond %{REQUEST_URI} !^" . $id . ".html
                RewriteRule ^(.*)$ " . $id . ".html [L]
                ");
                break;
        }
        if ($dest && $source) {
            if (!file_exists($dest)) {
                mkdir($dest, 0755);
            }
            foreach (
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST) as $item
            ) {
                if ($item->isDir()) {
                    if (!file_exists($dest)) {
                        mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathname());
                    }
                } else {
                    copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathname());
                }
            }
        }

    }
}

function synchronization($TILDA_PUBLIC_KEY, $TILDA_SECRET_KEY, $TILDA_PROJECT_ID)
{
    if (empty($_SERVER['DOCUMENT_ROOT'])) {
        $_SERVER['DOCUMENT_ROOT'] = __DIR__;
    }

    $api = new Tilda\Api($TILDA_PUBLIC_KEY, $TILDA_SECRET_KEY);

    /* Запрашиваем список страниц проекта и сохраняем ID страниц */
    $arExportPages = array();
    $arPages = $api->getPagesList($TILDA_PROJECT_ID);
    if (!$arPages) {
        die('Error working with API: ' . $api->lastError);
    }

    /* собираем список ID страниц */
    foreach ($arPages as $arPage) {
        $arExportPages[] = $arPage['id'];
    }
    unset($arPages);

    /* если все таки есть, что экспортировать */
    if (count($arExportPages)) {
        try {
            $local = new Tilda\LocalProject(
                array(
                    'projectDir' => '/origin',
                    /*
                     'buglovers' => 'dev@example.ru', // email for send mail with error or exception
                     'baseDir' => '/var/www/example.ru/'  //  absolute path for sites files
                    */
                )
            );
        } catch (Exception $e) {
            die('Error in TildaProject: ' . $e->getMessage() . PHP_EOL);
        }

        /*  берем данные по общим файлам проекта */
        $arProject = $api->getProjectInfo($TILDA_PROJECT_ID);
        if (!$arProject) {
            die('Not found project [' . $api->lastError . ']');
        }
        $local->setProject($arProject);

        /* создаем основные директории проекта (если еще не созданы) */
        if ($local->createBaseFolders() === false) {
            die('Error for create folders' . PHP_EOL);
        }

//        echo '<pre>';

        /* копируем общие IMG файлы */
        $imagesPath = !empty($local->arProject['export_imgpath']) ? $local->arProject['export_imgpath'] : 'images';
        $arFiles = $local->copyImagesFiles($local->getPath('images', false));
        if (!$arFiles) {
            die('Error in copy IMG files [' . $api->lastError . ']');
        }
//        print_r($arFiles);

        $countExport = 0;
        /* перебираем теперь страницы и скачиваем каждую по одной */
        foreach ($arExportPages as $pageid) {
            try {
//                echo 'Export page ' . $pageid . PHP_EOL;

                /* запрашиваем все данные для экспорта страницы */
                $tildaPage = $api->getPageFullExport($pageid);
                if (!$tildaPage || empty($tildaPage['html'])) {
//                    echo 'Error: cannot get page [' . $pageid . '] or page is not published' . PHP_EOL;
                    continue;
                }

                $tildaPage['needsync'] = 0;

                /* сохраним страницу (при сохранении также происходит копирование картинок/js/css использованных на странице) */
                $tildaPage = $local->savePage($tildaPage);
//                echo 'Save page ' . $pageid . ' - success' . PHP_EOL;

                $tildaPage = $local->saveMetaPage($tildaPage);

//                echo '<br>============ ' .
//                    '<a href="/' . $local->getProjectDir() . '/' . $tildaPage['id'] . '.html" target="_blank">' .
//                    'View page ' . $tildaPage['id'] .
//                    '</a>' .
//                    '<br>' . PHP_EOL;
            } catch (Exception $e) {
                echo 'Error [' . $countExport . '] tilda page dont export ' . $pageid . ' [' . $e->getMessage() . ']' . PHP_EOL;
            }
            $countExport++;
        }

        unset($arExportPages);
    }

}

echo json_encode(['status' => 200, 'ok' => true]);