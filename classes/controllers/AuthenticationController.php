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

            $query = new \Query($this->app->db);
            $query
                ->select('id')
                ->from('authentic')
                ->where(['and', ['=', 'username', $username], ['=', 'password', md5($password)]]);
            $authentic = $query->getRow();

            if (isset($authentic)) {
                $this->app->session->isUserAuthenticated = true;
                $this->app->flashMessages->add('Вы зашли под логином ' . $username);
                $this->app->session->authenticatedUserId = $authentic['id'];


                header('Location: /');

                exit;
            } else {
                $this->app->flashMessages->add('Вы ввели неверные данные!');
            }
        }

        $this->render('login', []);
    }

    public function logoutAction()
    {
        if ($this->app->session->isUserAuthenticated) {
            unset($this->app->session->isUserAuthenticated);
        } else {
            $this->app->flashMessages->add("Вы не залогинены.");
        }

        header('Location: /');
    }

    public function changePasswordAction()
    {
        if (!$this->app->session->isUserAuthenticated) {
            $this->app->flashMessages->add('Вы не авторизованы.');
            header('Location: /authentication/login');

            exit;
        }

        if (isset($_POST['submitNewPassword'])) {
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $newPasswordRepeat = $_POST['newPasswordRepeat'];

            if ($newPassword == $newPasswordRepeat) {
                $query = new \Query($this->app->db);
                $query
                    ->select()
                    ->from('authentic')
                    ->where(['and', ['=', 'id', $this->app->session->authenticatedUserId], ['=', 'password', md5($oldPassword)]]);
                $isPasswordOk = $query->getRow();

                if (isset($isPasswordOk)) {
                    $authenticatedUserId = $this->app->db->connection->real_escape_string($this->app->session->authenticatedUserId);
                    $newPasswordHash = $this->app->db->connection->real_escape_string(md5($newPassword));
                    $this->app->db->sendQuery("UPDATE authentic SET password = '$newPasswordHash' WHERE id = '$authenticatedUserId'");

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