<?php
namespace App;

class Auth
{
    public static function PageCheckAuth($f3)
    {
        if (!\App\Auth::Auth($f3)) {
            \App\Flash::instance()->addMessage('Login required', 'danger');
            $f3->set('logged', false);
            $f3->reroute('/login');
        } else {
            $f3->set('logged', true);
        }
    }

    public function Login($f3, $args)
    {
        // CSRF
        $session = new \Session();
        $csrf = $session->csrf();
        $f3->set('token', $csrf);
        $f3->set('SESSION.csrf', $csrf);

        // Reset persistenza
        $f3->set('COOKIE.sessionName', null);

        echo \Template::instance()->render('templates/authentication/login.htm');
    }

    public function Logout($f3, $args)
    {
        $session = new \Session();
        $csrf = $f3->get('COOKIE.sessionName');

        $csrfArray = explode(".", $csrf);
        $sessionUserid = "SESSION." . $csrfArray[0];
        $sessionPassword = "SESSION." . $csrfArray[1];

        $f3->set('COOKIE.sessionName', null);
        $f3->set($sessionUserid, null);
        $f3->set($sessionPassword, null);

        \App\Flash::instance()->addMessage('Logout avvenuto', 'success');
        $f3->reroute('/login');
    }

    public static function Auth($f3)
    {
        $session = new \Session();
        $csrf = $f3->get('COOKIE.sessionName');

        if (isset($csrf)) {
            $csrfArray = explode(".", $csrf);
            $sessionUserid = "SESSION." . $csrfArray[0];
            $sessionPassword = "SESSION." . $csrfArray[0].'_password';

            $f3_sessionUserid = $f3->get($sessionUserid);
            $f3_sessionPassword = $f3->get($sessionPassword);

            $utente = trim($f3_sessionUserid);
            $password = trim($f3_sessionPassword);

            if (isset($utente) && isset($password)) {
                $db = new \DB\SQL($f3->get('DB_APP'));
                $users = new \DB\SQL\Mapper($db, 'users');
                $auth = new \Auth($users, array('id' => 'user_id', 'pw' => 'password'));
                $login_result = $auth->login($utente, $password);

                return $login_result;
            } else {
                return false;
            }
        }
        //echo "false";
        return false;
    }

    public function LoginCheck($f3, $args)
    {
        // INIZIALIZZA SESSIONE
        $session = new \Session();

        if ($f3->VERB == 'POST') {

            // CARICA I DATI INVIATI E DI SESSIONE
            $utente = $f3->get('POST.username');
            $password = $f3->get('POST.p');
            $token = $f3->get('POST.token');
            $csrf = $f3->get('SESSION.csrf');

            $utente = str_replace('"', "", $utente);
            $utente = str_replace("'", "", $utente);

            // Resetta il csrf per evitare il doppio invio
            $f3->set('SESSION.csrf', $session->csrf());

            // CONTROLLA SE NON SONO SOTTO ATTACCO CSRF
            if ($token === $csrf) {

                $db = new \DB\SQL($f3->get('DB_APP'));
                $users = new \DB\SQL\Mapper($db, 'users');
                $auth = new \Auth($users, array('id' => 'user_id', 'pw' => 'password'));
                $login_result = $auth->login($utente, $password);

                if ($login_result) {

                    $f3->set('COOKIE.sessionName', $csrf);
                    $csrfArray = explode(".", $csrf);

                    $sessionUserid = "SESSION." . $csrfArray[0];
                    $sessionPassword = "SESSION." . $csrfArray[0].'_password';

                    $f3->set($sessionUserid, $utente);
                    $f3->set($sessionPassword, $password);

                    $f3->reroute('/');
                } else {
                    \App\Flash::instance()->addMessage('Nome utente o password non corretta', 'danger');
                    $f3->reroute('/login');
                }
            } else {
                \App\Flash::instance()->addMessage('CSRF attack!', 'danger');
                $f3->reroute('/login');
            }
        }
    }
}
