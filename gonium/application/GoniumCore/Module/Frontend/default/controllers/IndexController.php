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
 * @package     GoniumCore_Module_Frontend
 * @subpackage  GoniumCore_Module_Frontend_Default
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/**
 * @package     GoniumCore_Module_Frontend
 * @subpackage  GoniumCore_Module_Frontend_Default
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->view->bodyTitle = '<h1>Hello World!</h1>';
        $this->view->bodyCopy = "<p>Lorem ipsum dolor sit amet, consectetuer
            adipiscing elit. Pellentesque semper dui. Aliquam vestibulum nulla id
            enim. Curabitur ac tortor. Integer quis massa a magna consectetuer
            molestie. Sed sit amet risus. Suspendisse orci. Phasellus mauris dui,
            tempus vitae, scelerisque sit amet, scelerisque at, ligula. Donec ut
            sem. Integer placerat odio at nibh. Sed consequat erat aliquet dui.
            Curabitur malesuada ultricies quam. Pellentesque semper dui a turpis.
            Sed in ante id mauris facilisis feugiat. Suspendisse rutrum euismod
            turpis. Sed quis diam a neque dapibus faucibus. Duis in lorem. In a
            turpis. Integer a odio sed tellus sollicitudin pharetra. Lorem ipsum
            dolor sit amet, consectetuer adipiscing elit. Nam eros.</p><p>Vivamus
            mattis posuere ligula. Quisque magna tellus, semper aliquet, gravida
            quis, viverra ac, dolor. Nullam iaculis rhoncus enim. Vivamus sit amet
            dui a pede eleifend faucibus. Integer tempor, ipsum vel eleifend tempus,
            sapien lacus adipiscing est, eu laoreet diam metus nec libero. Duis
            ornare, enim ut aliquet tincidunt, diam arcu rutrum nulla, iaculis
            aliquet elit tellus id nisi. Class aptent taciti sociosqu ad litora
            torquent per conubia nostra, per inceptos hymenaeos. Nam mattis nisl.
            Curabitur sollicitudin vehicula massa. Integer felis leo, accumsan eget,
            cursus ac, venenatis et, quam. Suspendisse eleifend nisl eu ligula.</p>";
    }
}
