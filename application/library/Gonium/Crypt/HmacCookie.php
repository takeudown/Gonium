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
 * @category    Gonium
 * @package     Gonium_Crypt
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: HmacCookie.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/**
 * BigOrNot_CookieManager
 *
 * Based in
 * {@link http://www.cse.msu.edu/%7Ealexliu/publications/Cookie/cookie.pdf
 * Alex X. Liu1, Jason M. Kovacs, Chin-Tser Huang, Mohamed G. Gouda;
 * Secure Cookie Algorithm}
 * 
 * @copyright   Copyleft 2008, Matthieu Huguet, All wrongs reserved
 * @author      {@link http://bigornot.blogspot.com/ Matthieu Huguet}
 *
 * @category    Gonium
 * @package     Gonium_Crypt
 * @author      Modified by {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: HmacCookie.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_Crypt_HmacCookie
{
  /* Server secret key */
  protected $_secret = '';

  /* If PHP has mcrypt support */
  protected $_hasMcrypt;

  /* Cryptographic algorithm used to encrypt cookies data */
  protected $_algorithm;

  /* Cryptographic mode (CBC, CFB ...)*/
  protected $_mode;

  /* mcrypt module resource */
  protected $_cryptModule = null;

  /* Enable high confidentiality for cookie value (symmetric encryption) */
  protected $_highConfidentiality = true;

  /* Enable SSL support */
  protected $_ssl = false;
  
  protected $_deleteIfInvalid = true;

  /**
   * Constructor
   *
   * Initialize cookie manager and mcrypt module.
   *
   * @param string $secret  server's secret key
   * @param array $config
   */
  public function __construct($secret, $config = null)
  {
    if (empty($secret))
      throw new Exception('You must provide a secret key');
    $this->_secret = $secret;

    if ($config !== null && !is_array($config))
      throw new Exception('Config must be an array');
    if (is_array($config))
    {
        if($this->hasMcrypt())
        {
            /* Cryptographic algorithm used to encrypt cookies data */
            $this->_algorithm = MCRYPT_RIJNDAEL_256;
            /* Cryptographic mode (CBC, CFB ...)*/
            $this->_mode = MCRYPT_MODE_CBC;

            if (isset($config['high_confidentiality']))
                $this->_highConfidentiality = $config['high_confidentiality'];
            if (isset($config['mcrypt_algorithm']))
                $this->_algorithm = $config['mcrypt_algorithm'];
            if (isset($config['mcrypt_mode']))
                $this->_mode = $config['mcrypt_mode'];

            $this->_cryptModule =
                mcrypt_module_open( $this->_algorithm, '', $this->_mode, '');

            if ($this->_cryptModule === false)
                throw new Exception('Error while loading mcrypt module');
        }

        if (isset($config['enable_ssl']))
            $this->_ssl = $config['enable_ssl'];

        if (isset($config['delete_invalid']))
            $this->_deleteIfInvalid = $config['delete_invalid'];
    }
  }


  public function hasMcrypt()
  {
    if($this->_hasMcrypt === null)
        $this->_hasMcrypt = extension_loaded('mcrypt');

    return $this->_hasMcrypt;
  }

  /**
   * Get the high confidentiality mode
   *
   * @return bool TRUE if cookie data encryption is enabled, or FALSE if it isn't
   */
  public function getHighConfidentiality()
  {
    return ($this->_highConfidentiality);
  }

  /**
   * Set the high confidentiality mode
   * Enable or disable cookie data encryption
   *
   * @param bool $enable  TRUE to enable, FALSE to disable
   */
  public function setHighConfidentiality($enable)
  {
    $this->_highConfidentiality = $enable;
    return ($this);
  }

  /**
   * Get the SSL status (enabled or disabled?)
   *
   * @return bool TRUE if SSL support is enabled, or FALSE if it isn't
   */
  public function getSSL()
  {
    return ($this->_ssl);
  }

  /**
   * Enable SSL support (not enabled by default)
   * pro: protect against replay attack
   * con: cookie's lifetime is limited to SSL session's lifetime
   *
   * @param bool $enable TRUE to enable, FALSE to disable
   */
  public function setSSL($enable)
  {
    $this->_ssl = $enable;
    return ($this);
  }

  public function setDeleteIfInvalid( $deleteIfInvalid )
  {
      $this->_deleteIfInvalid = $deleteIfInvalid;
  }
  
  /**
   * Send a secure cookie
   *
   * @param string $name cookie name
   * @param string $value cookie value
   * @param string $username user name (or ID)
   * @param integer $expire expiration time
   * @param string $path cookie path
   * @param string $domain cookie domain
   * @param bool $secure when TRUE, send the cookie only on a secure connection
   * @param bool $httponly when TRUE the cookie will be made accessible only through the HTTP protocol
   */
  public function setCookie($cookiename, $value, $username, $expire = 0, $path = '', $domain = '', $secure = false, $httponly = null)
  {
    $value = serialize($value);
    $secureValue = $this->_secureCookieValue($value, $username, $expire);
    $this->setClassicCookie($cookiename, $secureValue, $expire, $path, $domain, $secure, $httponly);
  }

  /**
   * Delete a cookie
   *
   * @param string $name cookie name
   * @param string $path cookie path
   * @param string $domain cookie domain
   * @param bool $secure when TRUE, send the cookie only on a secure connection
   * @param bool $httponly when TRUE the cookie will be made accessible only through the HTTP protocol
   */
  public function deleteCookie($name, $path = '/', $domain = '', $secure = false, $httponly = null)
  {
    /* 1980-01-01 */
    $expire = 315554400;
    setcookie($name, '', $expire, $path, $domain, $secure, $httponly);
  }


  /**
   * Get a secure cookie value
   *
   * Verify the integrity of cookie data and decrypt it.
   * If the cookie is invalid, it can be automatically destroyed (default behaviour)
   *
   * @param string $cookiename cookie name
   * @param bool $deleteIfInvalid destroy the cookie if invalid
   */
  public function getCookieValue($cookiename, $deleteIfInvalid = null)
  {
    if ($this->cookieExists($cookiename))
    {
      $cookieValues = explode('|', $_COOKIE[$cookiename]);
      if ((count($cookieValues) === 4) &&
        ($cookieValues[1] == 0 || $cookieValues[1] >= time()))
      {
        $key = hash_hmac('sha1', $cookieValues[0].$cookieValues[1], $this->_secret);
        $data = base64_decode($cookieValues[2]);

        if ($this->getHighConfidentiality() && $this->hasMcrypt())
        {
            $data = $this->_decrypt($data, $key, md5($cookieValues[1]));
        }

        $verifyKey = $cookieValues[0].$cookieValues[1].$data;

        if ($this->_ssl && isset($_SERVER['SSL_SESSION_ID']))
          $verifyKey .= $_SERVER['SSL_SESSION_ID'];

        $verifyKey = hash_hmac('sha1', $verifyKey, $key);

        if ($verifyKey == $cookieValues[3])
          return unserialize(base64_decode($data));
      }
    }

    if( (($deleteIfInvalid !== null) && $deleteIfInvalid) ||
        (($deleteIfInvalid === null) && $this->_deleteIfInvalid) )
        $this->deleteCookie($cookiename);

    return false;
  }

  /**
   * Send a classic (unsecure) cookie
   *
   * @param string $name cookie name
   * @param string $value cookie value
   * @param integer $expire expiration time
   * @param string $path cookie path
   * @param string $domain cookie domain
   * @param bool $secure when TRUE, send the cookie only on a secure connection
   * @param bool $httponly when TRUE the cookie will be made accessible only through the HTTP protocol
   */
  protected function setClassicCookie($cookiename, $value, $expire = 0, $path = '', $domain = '', $secure = false, $httponly = null)
  {
    /* httponly option is only available for PHP version >= 5.2 */
    if ($httponly === null)
      setcookie($cookiename, $value, $expire, $path, $domain, $secure);
    else
      setcookie($cookiename, $value, $expire, $path, $domain, $secure, $httponly);
  }


  /**
   * Verify if a cookie exists
   *
   * @param string $cookiename
   * @return bool TRUE if cookie exist, or FALSE if not
   */
  public function cookieExists($cookiename)
  {
    return (bool) @$_COOKIE[$cookiename]; //in_array($cookiename, $_COOKIE);
  }

  /**
   * Secure a cookie value
   *
   * The initial value is transformed with this protocol :
   *
   *  secureValue = username|expire|base64((value)k,expire)|HMAC(user|expire|value,k)
   *  where k = HMAC(user|expire, sk)
   *  and sk is server's secret key
   *  (value)k,md5(expire) is the result an cryptographic function (ex: AES256) on "value" with key k and initialisation vector = md5(expire)
   *
   * @param string $value unsecure value
   * @param string $username user name (or ID)
   * @param integer $expire expiration time
   * @return string secured value
   */

  protected function _secureCookieValue($value, $username, $expire)
  {
    $key = hash_hmac('sha1', $username.$expire, $this->_secret);

    $value = base64_encode($value);
    $encryptedValue = $value;

    if ($this->getHighConfidentiality() && $this->hasMcrypt())
    {
      $encryptedValue = $this->_encrypt($value, $key, md5($expire));
    }
    // Reencode (to avoid "serialize" encoding fail)
    $encryptedValue = base64_encode($encryptedValue);

    $verifKey = $username . $expire . $value;
    if ($this->_ssl && isset($_SERVER['SSL_SESSION_ID']))
      $verifKey .= $_SERVER['SSL_SESSION_ID'];

    $verifKey = hash_hmac('sha1', $verifKey, $key);

    $result = array($username, $expire, $encryptedValue, $verifKey);
    return(implode('|', $result));
  }

  /**
   * Encrypt a given data with a given key and a given initialisation vector
   *
   * @param string $data data to crypt
   * @param string $key secret key
   * @param string $iv initialisation vector
   * @return string encrypted data
   */
  protected function _encrypt($data, $key, $iv)
  {
    $iv = $this->_validateIv($iv);
    $key = $this->_validateKey($key);

    mcrypt_generic_init($this->_cryptModule, $key, $iv);
    $res = mcrypt_generic($this->_cryptModule, $data);
    mcrypt_generic_deinit($this->_cryptModule);

    return ($res);
  }

  /**
   * Decrypt a given data with a given key and a given initialisation vector
   *
   * @param string $data data to crypt
   * @param string $key secret key
   * @param string $iv initialisation vector
   * @return string encrypted data
   */
  protected function _decrypt($data, $key, $iv)
  {
    $iv = $this->_validateIv($iv);
    $key = $this->_validateKey($key);
    mcrypt_generic_init($this->_cryptModule, $key, $iv);
    $decryptedData = mdecrypt_generic($this->_cryptModule, $data);
    $res = str_replace("\x0", '', $decryptedData);
    mcrypt_generic_deinit($this->_cryptModule);
    return ($res);
  }

  /**
   * Validate Initialization vector
   *
   * If given IV is too long for the selected mcrypt algorithm, it will be truncated
   *
   * @param string $iv Initialization vector
   */
  protected function _validateIv($iv)
  {
    $ivSize = mcrypt_enc_get_iv_size($this->_cryptModule);
    if (strlen($iv) > $ivSize)
      $iv = substr($iv, 0, $ivSize);
    return ($iv);
  }

  /**
   * Validate key
   *
   * If given key is too long for the selected mcrypt algorithm, it will be truncated
   *
   * @param string $key key
   */
  protected function _validateKey($key)
  {
    $keySize = mcrypt_enc_get_key_size($this->_cryptModule);
    if (strlen($key) > $keySize)
      $key = substr($key, 0, $keySize);
    return ($key);
  }

}
