<?php

/**
 * Gonium, Zend Framework based Content Manager System.
 * Copyright (C) 2008 Gonzalo Diaz Cruz
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
 * @subpackage  GoniumCore_Module_Frontend_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/**
 * @package     GoniumCore_Module_Frontend
 * @subpackage  GoniumCore_Module_Frontend_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class User_IndexController extends Zend_Controller_Action
{
    public function indexAction ()
    {
        $auth = Zend_Registry::get('GoniumCore_Auth');
        
        if ($auth->hasIdentity())
        {
            return $this->_forward('profile');
        } else
            return $this->_forward('login', 'auth');
    }
    
    public function profileAction ()
    {
        $auth = Zend_Registry::get('GoniumCore_Auth');
        if (! $auth->hasIdentity()) return $this->_forward('login', 'auth');
        
        $userModel = $this->_helper->LoadModel('User');
        $this->view->userData = $userModel->getUser(
        $auth->getIdentity()
            ->getId());
        
        Zend_Loader::loadclass('Gravatar_Gravatar');
        
        $this->view->pAvatar = new Gravatar_Gravatar();
        
        $this->view->pAvatar->setEmail($this->view->userData->user_email)
            ->setSize(80)
            ->setRating(Gravatar_Gravatar::GRAVATAR_RATING_PG);
    }
}
