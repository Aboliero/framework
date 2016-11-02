<?php

namespace components;
use Query;

/**
 * Class User
 */
class User
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Database
     */
    protected $database;

    /**
     * @var array
     */
    protected $userCache;

    public function __construct(Session $session, Database $database)
    {
        $this->session = $session;
        $this->database = $database;
    }

    /**
     * @return array|null
     */
    public function getUser()
    {
        if (!$this->userCache) {
            $query = new Query($this->database);
            $query->select('username')->from('authentic')->where(['=', 'id', $this->session->authenticatedUserId]);
            $this->userCache = $query->getRow();
        }

        return $this->userCache;
    }

    public function login($username, $password)
    {
        $query = new Query($this->database );
        $query
            ->select('id')
            ->from('authentic')
            ->where(['and', ['=', 'username', $username], ['=', 'password', md5($password)]]);
        $authentic = $query->getRow();
        
        if (isset($authentic)) {
            $this->session->authenticatedUserId = $authentic['id'];
            
            return true;
        }
        
        return false;
    }

    public function changePassword($oldPassword)
    {
        $query = new Query($this->database);
        $query
            ->select()
            ->from('authentic')
            ->where(['and', ['=', 'id', $this->session->authenticatedUserId], ['=', 'password', md5($oldPassword)]]);
        $isPasswordOk = $query->getRow();
        
        if (isset($isPasswordOk)) {
            
            return true;
        }
        
        return false;
    }
}