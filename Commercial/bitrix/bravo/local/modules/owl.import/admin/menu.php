<?
AddEventHandler('main', 'OnBuildGlobalMenu', 'addMenuItem');

function addMenuItem(&$aGlobalMenu, &$aModuleMenu)
{
    global $USER;

    if ($USER->IsAdmin()) {

        $aGlobalMenu['global_menu_custom'] = [
            'menu_id' => 'custom',
            'text' => 'Импорт',
            'title' => 'Импорт',
            'url' => 'settings.php?lang=ru',
            'sort' => 1000,
            'items_id' => 'global_menu_custom',
            'help_section' => 'custom',
            'items' => [
                [
                    'parent_menu' => 'global_menu_custom',
                    'sort'        => 10,
                    'url'         => 'importProduct.php?lang=ru',
                    'text'        => 'Импорт продуктов',
                    'title'       => 'Импорт продуктов',
                    'icon'        => 'fav_menu_icon',
                    'page_icon'   => 'fav_menu_icon',
                    'items_id'    => 'menu_custom',
                ],
//                [
//                    'parent_menu' => 'global_menu_custom',
//                    'sort'        => 10,
//                    'url'         => 'importAdditionals.php?lang=ru',
//                    'text'        => 'Импорт комплектов',
//                    'title'       => 'Импорт комплектов',
//                    'icon'        => 'fav_menu_icon',
//                    'page_icon'   => 'fav_menu_icon',
//                    'items_id'    => 'menu_custom',
//                ],
//                [
//                    'parent_menu' => 'global_menu_custom',
//                    'sort'        => 10,
//                    'url'         => 'importComplects.php?lang=ru',
//                    'text'        => 'Импорт комплектующих',
//                    'title'       => 'Импорт комплектующих',
//                    'icon'        => 'fav_menu_icon',
//                    'page_icon'   => 'fav_menu_icon',
//                    'items_id'    => 'menu_custom',
//                ],
            ],
        ];

    }
}
?>

