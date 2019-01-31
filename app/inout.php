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
        $cat1 = $params['cat1'];

        $categoria1 = new \App\Models\Categoria1($this->db);
        $f3->set('categoria1', $categoria1->getById($cat1));
                
        $categoria2 = new \App\Models\Categoria2($this->db);
        $f3->set('categoria2', $categoria2->getByMadre($cat1));

        $f3->set('title', 'Nuovo');
        $f3->set('container', 'inout/nuovo2.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Nuovo_3($f3, $params)
    {
        $cat1 = $params['cat1'];
        $cat2 = $params['cat2'];

        $categoria1 = new \App\Models\Categoria1($this->db);
        $f3->set('categoria1', $categoria1->getById($cat1));
        
        $categoria2 = new \App\Models\Categoria2($this->db);
        $f3->set('categoria2', $categoria2->getById($cat2));
        
        $categoria3 = new \App\Models\Categoria3($this->db);
        $f3->set('categoria3', $categoria3->getByMadre($cat2));

        $f3->set('title', 'Nuovo');
        $f3->set('container', 'inout/nuovo3.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Nuovo_4($f3, $params)
    {
        $cat1 = $params['cat1'];
        $cat2 = $params['cat2'];
        $cat3 = $params['cat3'];

        $categoria1 = new \App\Models\Categoria1($this->db);
        $f3->set('categoria1', $categoria1->getById($cat1));
        
        $categoria2 = new \App\Models\Categoria2($this->db);
        $f3->set('categoria2', $categoria2->getById($cat2));

        $categoria3 = new \App\Models\Categoria3($this->db);
        $f3->set('categoria3', $categoria3->getById($cat3));
        
        $categoria4 = new \App\Models\Categoria4($this->db);
        $f3->set('categoria4', $categoria4->getByMadre($cat3));

        $f3->set('title', 'Nuovo');
        $f3->set('container', 'inout/nuovo4.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

}