<?php

namespace components;
use Query;
use User as Model;

/**
 * Class User
 */
class User extends \Component
{
    /**
     * @var Model
     */
    protected $userCache;

    /**
     * @return Model|null
     */
    public function getModel()
    {
        if (!$this->userCache) {
            $this->userCache = Model::getById($this->app->session->authenticatedUserId);
        }

        return $this->userCache;
    }

    public function login($username, $password)
    {
        $user = Model::getObject(['and', ['=', 'username', $username], ['=', 'password', md5($password)]]);

        if (isset($user)) {
            $this->app->session->authenticatedUserId = $user->id;
            $this->app->session->isUserAuthenticated = true;
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
        return $this->app->session->isUserAuthenticated ?: false;
    }

    public function logout()
    {
        unset($this->app->session->isUserAuthenticated);
        unset($this->app->session->authenticatedUserId);
        $this->userCache = null;
    }
}