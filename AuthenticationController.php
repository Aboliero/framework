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
                ->select()
                ->from('authentic')
                ->where(['and', ['=', 'username', $username], ['=', 'password', $password]]);
            $authentic = $query->getRow();

            if (isset($authentic)) {
                $this->app->session->isUserAuthenticated = true;
                $this->app->flashMessages->add('Вы зашли под логином ' . $username);

                header('Location: /city/list');

                exit;
            } else {
                $this->app->flashMessages->add('Вы ввели неверные данные!');
            }
        }

        $this->render('login', []);
    }

    public function logoutAction()
    {
        
    }
}