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
$f3->route('GET @nuovo_2: /nuovo/@cat1', '\App\Inout->Nuovo_2');
$f3->route('GET @nuovo_3: /nuovo/@cat1/@cat2', '\App\Inout->Nuovo_3');
$f3->route('GET @nuovo_4: /nuovo/@cat1/@cat2/@cat3', '\App\Inout->Nuovo_4');
$f3->route('GET @nuovo_5: /nuovo/@cat1/@cat2/@cat3/@cat4', '\App\Inout->Nuovo_5');
$f3->route('POST @nuovo_salva: /nuovo/salva', '\App\Inout->Nuovo_Salva');
$f3->route('GET @delete_confirm: /inout/delete/@id', '\App\Inout->DeleteConfirm');
$f3->route('POST @delete: /inout/delete/@id', '\App\Inout->Delete');
$f3->route('GET @lista: /inout/lista', '\App\Inout->Lista');
$f3->route('GET @statistiche: /inout/statistiche', '\App\Inout->Statistiche');

// Auth
$f3->route('GET @login: /login', '\App\Auth->Login');
$f3->route('POST @loginCheck: /loginCheck', '\App\Auth->LoginCheck');
$f3->route('GET @logout: /logout', '\App\Auth->Logout');
$f3->route('GET @user: /user', '\App\Admin->User_list');
$f3->route('GET @user_new: /user/new', '\App\Admin->User_new');
$f3->route('GET @user_delete: /user/delete/@user_id', '\App\Admin->User_delete');
$f3->route('POST @user_save: /user/save', '\App\Admin->User_save');

$f3->run();
