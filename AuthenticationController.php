<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.09.2016
 * Time: 22:12
 */
class AuthenticationController extends Controller
{
    public $defaultActionName = 'login';

    public function loginAction()
    {
        
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = new Query($this->app->db);
            $query
                ->select('id')
                ->from('authentic')
                ->where(['and', ['=', 'username', $username], ['=', 'password', $password]]);
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

    public function profileAction()
    {
        if (isset($_POST['submitNewPassword']) && $this->app->session->isUserAuthenticated) {
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $newPasswordRepeat = $_POST['newPasswordRepeat'];

            if ($newPassword == $newPasswordRepeat) {
                $query = new Query($this->app->db);
                $query
                    ->select()
                    ->from('authentic')
                    ->where(['and', ['=', 'id', $this->app->session->authenticatedUserId], ['=', 'password', $oldPassword]]);
                $isPasswordOk = $query->getRow();

                if (isset($isPasswordOk)) {
                    $authenticatedUserId = $this->app->session->authenticatedUserId;
                    $this->app->session->isPasswordAuthenticated = true;
                    $this->app->db->sendQuery("UPDATE authentic SET password = '$newPassword' WHERE id = '$authenticatedUserId'");

                    $this->app->flashMessages->add('Пароль успешно изменён');

                    header('Location: /');

                    exit;
                } else {
                    if ($this->app->session->isUserAuthenticated) {
                        unset($this->app->session->flashMessages);
                        $this->app->flashMessages->add('Неверные данные');
                    }
                }
            }
            unset($this->app->session->flashMessages);
            $this->app->flashMessages->add('Неверные данные');
        } else if (!$this->app->session->isUserAuthenticated) {
            $this->app->flashMessages->add("Вы не залогинены.");
            }

        $this->render('profile');
    }
}