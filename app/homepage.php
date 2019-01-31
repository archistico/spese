<?php
namespace App;

class Homepage extends Controller
{
    public function beforeroute($f3)
    {
        \App\Auth::PageCheckAuth($f3);
    }

    public function Show($f3)
    {
        $todos = new \App\Models\Todos($this->db);
        $f3->set('todos', $todos->all());

        $categoria1 = new \App\Models\Categoria1($this->db);
        $f3->set('categoria1', $categoria1->all());

        $f3->set('title', 'Homepage');
        $f3->set('container', 'homepage.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

}
