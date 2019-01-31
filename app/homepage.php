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

        $ultimi10 = new \App\Models\Movimenti($this->db);
        $f3->set('ultimi10', $ultimi10->last10());

        $f3->set('euro', function ($i) {
            if ($i >= 0) {
                return "+" . number_format((float) $i, 2, '.', '') . " €";
            } else {
                return number_format((float) $i, 2, '.', '') . " €";
            }
        }
        );

        $f3->set('convertiData',
            function ($d) {
                $str = jdtojulian($d);
                $dmy = \DateTime::createFromFormat('m/d/Y', $str)->format('d/m/Y');
                return $dmy;
            }
        );
        
        $f3->set('unisci',
            function ($a, $b, $c, $d) {
                $cat1 = new \App\Models\Categoria1($this->db);
                $query_cat1 = $cat1->getById($a);

                $cat2 = new \App\Models\Categoria2($this->db);
                $query_cat2 = $cat2->getById($b);

                $cat3 = new \App\Models\Categoria3($this->db);
                $query_cat3 = $cat3->getById($c);

                $cat4 = new \App\Models\Categoria4($this->db);
                $query_cat4 = $cat4->getById($d);
                return $query_cat1[0]->descrizione . " / " . $query_cat2[0]->descrizione . " / " . $query_cat3[0]->descrizione . " / " . $query_cat4[0]->descrizione;
            }
        );

        $f3->set('title', 'Homepage');
        $f3->set('container', 'homepage.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

}
