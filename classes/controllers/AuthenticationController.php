<?php

namespace controllers;

use Controller;

class AuthenticationController extends Controller
{
    public $defaultActionName = 'login';

    public function loginAction()
    {
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->app->user->login($username, $password)) {
                $this->app->flashMessages->add('Вы зашли под логином ' . $username);

                header('Location: /');

                exit;
            } else {
                $this->app->flashMessages->add('Вы ввели неверные данные!');
            }
        }

        $this->render('login');
    }

    public function logoutAction()
    {
        if ($this->app->user->isAuthenticated()) {
            $this->app->user->logout();
        } else {
            $this->app->flashMessages->add("Вы не залогинены.");
        }

        header('Location: /');
    }

    public function changePasswordAction()
    {
        if (!$this->app->user->isAuthenticated()) {
            $this->app->flashMessages->add('Вы не авторизованы.');
            
            header('Location: /authentication/login');

            exit;
        }

        if (isset($_POST['submitNewPassword'])) {
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $newPasswordRepeat = $_POST['newPasswordRepeat'];

            if ($newPassword == $newPasswordRepeat) {
                if ($this->app->user->checkPassword($oldPassword)) { // isset $isPasswordOk
                    $this->app->user->setPassword($newPassword);
                    $this->app->flashMessages->add('Пароль успешно изменён');

                    header('Location: /');

                    exit;
                } else {
                    $this->app->flashMessages->add('Неверный старый пароль');
                }
            } else {
                $this->app->flashMessages->add('Новые пароли не совпадают');
            }
        }

        $this->render('changePassword');
    }
}