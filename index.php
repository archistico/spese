<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();

// Config
$f3->set('CACHE', true);
$f3->set('DEBUG', 3);
$f3->set('TITLE_APP','IN/OUT');
$f3->set('DB_APP', 'sqlite:db/db.sqlite');

// Home
$f3->route('GET @home: /', '\App\Homepage->Show');

// Todo
$f3->route('GET @todo_delete: /todo/delete/@id', '\App\Todo->Delete');
$f3->route('POST @todo_add: /todo/add', '\App\Todo->Add');

// Spese
$f3->route('GET @nuovo_2: /nuovo/@num', '\App\Movimento->Nuovo_2');

// Auth

$f3->route('GET @login: /login', '\App\Auth->Login');
$f3->route('POST @loginCheck: /loginCheck', '\App\Auth->LoginCheck');

$f3->route('GET @logout: /logout', '\App\Auth->Logout');

$f3->route('GET @user: /user', '\App\Admin->User_list');
$f3->route('GET @user_new: /user/new', '\App\Admin->User_new');
$f3->route('GET @user_delete: /user/delete/@user_id', '\App\Admin->User_delete');
$f3->route('POST @user_save: /user/save', '\App\Admin->User_save');

$f3->run();
