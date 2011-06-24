<?php
class BlogModel extends Zend_DB_Table
{
    private $db;
    protected $_name = 'user_posts';
    protected $_primary = 'post_id';
    private $groups;
    public function __construct ()
    {
        $registry = Zend_Registry::getInstance();
        $this->db = $registry->get('db');
        parent::setDefaultAdapter($this->db);
        parent::__construct();
    }
}
