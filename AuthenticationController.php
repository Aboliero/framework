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
}