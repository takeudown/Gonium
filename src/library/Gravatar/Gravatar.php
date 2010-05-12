<?php

class Gravatar_Gravatar
{
	private $m_szImage;
	private $m_szEmail;
	private $m_iSize;
	private $m_szRating;
	
	const GRAVATAR_SITE_URL = 'http://www.gravatar.com/avatar.php?gravatar_id=%ssize=%sdefault=%srating=%s';
	const GRAVATAR_RATING_G = 'G';
	const GRAVATAR_RATING_PG = 'PG';
	const GRAVATAR_RATING_R = 'R';
	const GRAVATAR_RATING_X = 'X';

	public function __construct()
	{
		$this->m_iSize = 80;
		$this->m_szRating = 'R';
		$this->m_szImage = '';
	}
	
	public function getAvatar()
	{
		return (string) sprintf
		(
			self::GRAVATAR_SITE_URL,
			$this->m_szEmail,
			$this->m_iSize,
			$this->m_szImage,
			$this->m_szRating
		);
	}
	
	public function __toString()
	{
		return $this->getAvatar();
	}
	
	public function setImage($szImage)
	{
		$this->m_szImage = (string) urlencode($szImage);
		return $this;
	}
	
	public function setEmail($szEmail)
	{
		$this->m_szEmail = (string) md5($szEmail);
		return $this;
	}
	
	public function setSize($iSize)
	{
		$this->m_iSize = (int) $iSize;
		return $this;
	}
	
	public function setRating($szRating)
	{
		$this->m_szRating = (string) $szRating;
		return $this;
	}
}
