<?php

class GoniumCore_Module_Frontend_Auth_Helper
{
    public function direct ()
    {
        return $this;
    }
    
    public function getCookieStorage ()
    {
        // Check cookie for login
        Zend_Loader::loadClass('Gonium_Crypt_HmacCookie');
        Zend_Loader::loadClass('Gonium_Auth_Storage_SecureCookie');
        $hmacCookie = new Gonium_Crypt_HmacCookie($config->system->key, 
        array('high_confidentiality' => true, 'enable_ssl' => true));
        $bUrl = $this->getRequest()->getBaseUrl();
        $bUrl = $bUrl != '' ? $bUrl : '/';
        $cookieAuth = new Gonium_Auth_Storage_SecureCookie($hmacCookie, 
        array(
            'cookieName' => $config->system->cookie->name_prefix . 'Auth', 
                'cookieExpire' => (time() + $config->system->cookie->expire), 
                'cookiePath' => $bUrl));
        return $cookieAuth;
    }
    
    public function remember ()
    {
        // Remember?
        if ($form->remember->getValue() === '1')
        {
            // Set a secure cookie
            $hmacCookie = new Gonium_Crypt_HmacCookie(
            $config->system->key, 
            array('high_confidentiality' => true, 'enable_ssl' => true));
            
            $bUrl = $this->getRequest()->getBaseUrl();
            $bUrl = $bUrl != '' ? $bUrl : '/';
            
            $cookieAuth = new Gonium_Auth_Storage_SecureCookie($hmacCookie, 
            array(
                'cookieName' => $config->system->cookie->name_prefix . 'Auth', 
                    'cookieExpire' => (time() + $config->system->cookie->expire), 
                    'cookiePath' => $bUrl));
            
            $auth->clearIdentity();
            $auth->setStorage($cookieAuth);
        
        }
        
        $auth->getStorage()->write($user);
    }
}