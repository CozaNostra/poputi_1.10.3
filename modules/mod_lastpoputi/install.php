<?php
/******************************************************************************/
//                                                                            //
//                             InstantCMS v1.10                                //
//                        http://www.instantcms.ru/                           //
//                                                                            //
//                   written by InstantCMS Team, 2007-2012                    //
//                produced by InstantSoft, (www.instantsoft.ru)               //
//                                                                            //
//                        LICENSED BY GNU/GPL v2                              //
//                                                                            //
/******************************************************************************/

    function info_module_mod_lastpoputi(){

        //
        // Описание модуля
        //

        //Заголовок (на сайте)
        $_module['title']        = 'Последние маршруты';

        //Название (в админке)
        $_module['name']         = 'Последние маршруты';

        //описание
        $_module['description']  = 'Показывает список последних маршрутов в сервисе "Попутчики"';
        
        //ссылка (идентификатор)
        $_module['link']         = 'mod_lastpoputi';
        
        //позиция
        $_module['position']     = 'maintop';

        //автор
        $_module['author']       = 'CozaNostra';

        //текущая версия
        $_module['version']      = '1.10.3';

        //
        // Настройки по-умолчанию
        //
        $_module['config'] = array();

        return $_module;

    }

// ========================================================================== //

    function install_module_mod_lastpoputi(){

        return true;

    }

// ========================================================================== //

    function upgrade_module_mod_lastpoputi(){

        return true;
        
    }

// ========================================================================== //

?>