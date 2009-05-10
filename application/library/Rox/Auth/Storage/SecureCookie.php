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
 * @package     Rox_Auth
 * @subpackage  Rox_Auth_Storage
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: SecureCookie.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** Zend_Auth_Storage_Interface*/
 include_once 'Zend/Auth/Storage/Interface.php';

/**
 * BigOrNot_Cookie, Zend_Auth storage adapter. 
 * 
 * Store User data in a secure cookie.
 *
 * @copyright   Copyleft 2008, Matthieu Huguet, All wrongs reserved
 * @author      {@link http://bigornot.blogspot.com/ Matthieu Huguet}
 * 
 * @package     Rox_Auth
 * @subpackage  Rox_Auth_Storage
 * @author      Mofified by {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @version     $Id: SecureCookie.php 153 2009-05-10 21:20:21Z gnzsquall $
 * @see Rox_Crypt_HmacCookie
 */
class Rox_Auth_Storage_SecureCookie
    implements Zend_Auth_Storage_Interface
{
  /* Instance of BigOrNot_CookieManager  */
  protected     $_cookieManager = null;

  /* Cookie configuration (see setcookie() for details) */
  protected     $_cookieName = 'auth';
  protected     $_cookieExpire = 0;
  protected     $_cookiePath = '/';
  protected     $_cookieDomain = '';
  protected     $_cookieSecure = false;
  protected     $_cookieHttpOnly = false;

  /* Local "cache" to store cookie value, in order to not waste
     time in cryptographic functions of cookieManager->getCookieValue() */
  protected     $_cache = null;

  /**
   * Constructor
   *
   * Available configuration options are :
   * cookieName, cookieExpire, cookiePath, cookieDomain,  cookieSecure, cookieHttpOnly
   * (see native setcookie() documentation for more details)
   *
   * @param BigOrNot_CookieManager $cookieManager the secure cookie manager
   * @param array|Zend_Config $config configuration
   */
  public function __construct(Rox_Crypt_HmacCookie $cookieManager, $config = array())
  {
    $this->_cookieManager = $cookieManager;

    if ($config instanceof Zend_Config)
      $config = $config->toArray();
    if (is_array($config))
      {
	    if (array_key_exists('cookieName', $config))
	      $this->_cookieName = $config['cookieName'];
	    if (array_key_exists('cookieExpire', $config))
	      $this->_cookieExpire = $config['cookieExpire'];
	    if (array_key_exists('cookiePath', $config))
	      $this->_cookiePath = $config['cookiePath'];
	    if (array_key_exists('cookieDomain', $config))
	      $this->_cookieDomain = $config['cookieDomain'];
	    if (array_key_exists('cookieSecure', $config))
	      $this->_cookieSecure = $config['cookieSecure'];
	    if (array_key_exists('cookieHttpOnly', $config))
	      $this->_cookieHttpOnly = $config['cookieHttpOnly'];
      }
  }

  /**
   * Defined by Zend_Auth_Storage_Interface
   *
   * @return boolean
   */
  public function isEmpty()
  {
    if ($this->_cache)
      return false;

    $content = $this->_cookieManager->getCookieValue($this->_cookieName);
    if($content)
    {
        $this->_cache = $content;
        return false;
    }

    return true;
  }

  /**
   * Defined by Zend_Auth_Storage_Interface
   *
   * @return mixed
   */
  public function read()
  {
    if ($this->_cache)
      return ($this->_cache);
    elseif ($this->_cookieManager->cookieExists($this->_cookieName))
    {
    	$content = $this->_cookieManager->getCookieValue($this->_cookieName);
	    if ($content)
        {
	        $this->_cache = unserialize($content);
	        return ($this->_cache);
        }
    }

    return false;
  }

  /**
   * Defined by Zend_Auth_Storage_Interface
   *
   * @param  mixed $contents
   * @return void
   */
  public function write($contents)
  {
    $this->_cache = $contents;
    $serializedContent = serialize($contents);
    $userIdentifier = substr(md5($serializedContent), 0, 10);

    $this->_cookieManager->setCookie($this->_cookieName,
                     $contents,
                     $userIdentifier,
                     $this->_cookieExpire,
                     $this->_cookiePath,
                     $this->_cookieDomain,
                     $this->_cookieSecure,
                     $this->_cookieHttpOnly);
  }

  /**
   * Defined by Zend_Auth_Storage_Interface
   *
   * @return void
   */
  public function clear()
  {
    $this->_cache = null;
    $this->_cookieManager->deleteCookie($this->_cookieName,
                    $this->_cookiePath,
                    $this->_cookieDomain,
                    $this->_cookieSecure,
                    $this->_cookieHttpOnly);
  }
}
