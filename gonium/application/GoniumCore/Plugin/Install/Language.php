<?php
/**
 * Gonium, Zend Framework based Content Manager System.
 *  Copyright (C) 2008 Gonzalo Diaz Cruz
 *
 * LICENSE
 *
 * Gonium is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or any
 * later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Load Gettext translation adapter and configure user language.
 *
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class GoniumCore_Plugin_Install_Language extends Zend_Controller_Plugin_Abstract
{
    /**
    * @todo Configurar el idioma dependiendo de la preferencia del usuario,
    * o de las cabeceras del navegador.
    * @todo Create a LoadTranslation action/view helper
    */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        parent::routeStartup($request);
        Zend_Loader::loadClass('Zend_Translate');
        Zend_Loader::loadClass('Zend_Locale');

        $translate = new Zend_Translate(
            'gettext',
            APP_ROOT.'language/',
            new Zend_Locale('es_ES'),
            array('scan' => Zend_Translate::LOCALE_DIRECTORY)
        );

        Zend_Registry::set('Zend_Translate', $translate);

        $translate->setLocale('es_ES');

        $view = Zend_Registry::get('GoniumCore_View');
        $view->headMeta()->appendHttpEquiv('Content-Language', 'es-CL');
    }
}