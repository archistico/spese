<?php
namespace App;

class Inout extends Controller
{
    public function beforeroute($f3)
    {
        \App\Auth::PageCheckAuth($f3);
    }

    public function Nuovo_2($f3, $params)
    {
        $cat1 = $params['num'];
        
        $categoria2 = new \App\Models\Categoria2($this->db);
        $f3->set('categoria2', $categoria2->all());

        $f3->set('title', 'Nuovo');
        $f3->set('container', 'homepage.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

}