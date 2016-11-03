<?php

namespace components;
use Query;
use User as Model;

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
     * @return Model|null
     */
    public function getModel()
    {
        if (!$this->userCache) {
            $this->userCache = Model::getById($this->session->authenticatedUserId);
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
        $model = $this->getModel();

        return $model->password == md5($oldPassword);
    }

    public function setPassword($newPassword)
    {
        $model = $this->getModel();
        $model->password = md5($newPassword);
        $model->save();
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