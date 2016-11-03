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
            $query->select()->from('authentic')->where(['=', 'id', $this->session->authenticatedUserId]);
            $this->userCache = $query->getRow();
        }

        return $this->userCache;
    }

    public function login($username, $password)
    {
        $query = new Query($this->database);
        $query
            ->select()
            ->from('authentic')
            ->where(['and', ['=', 'username', $username], ['=', 'password', md5($password)]]);
        $user = $query->getRow();
        
        if (isset($user)) {
            $this->session->authenticatedUserId = $user['id'];
            $this->session->isUserAuthenticated = true;
            $this->userCache = $user;
            
            return true;
        }
        
        return false;
    }

    public function checkPassword($oldPassword)
    {
        $user = $this->getUser();

        return $user['password'] == md5($oldPassword);
    }

    public function setPassword($newPassword)
    {
        $authenticatedUserId = $this->database->connection->real_escape_string($this->session->authenticatedUserId);
        $newPasswordHash = $this->database->connection->real_escape_string(md5($newPassword));
        $this->database->sendQuery("UPDATE authentic SET password = '$newPasswordHash' WHERE id = '$authenticatedUserId'");
    }

    public function isAuthenticated()
    {
        return $this->session->isUserAuthenticated ?: false;
    }

    public function logout()
    {
        unset($this->session->isUserAuthenticated);
        unset($this->session->authenticatedUserId);
        $this->userCache = null;
    }
}