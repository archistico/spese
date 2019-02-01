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

    public function Nuovo_5($f3, $params)
    {
        $cat1 = $params['cat1'];
        $cat2 = $params['cat2'];
        $cat3 = $params['cat3'];
        $cat4 = $params['cat4'];

        $categoria1 = new \App\Models\Categoria1($this->db);
        $f3->set('categoria1', $categoria1->getById($cat1));
        
        $categoria2 = new \App\Models\Categoria2($this->db);
        $f3->set('categoria2', $categoria2->getById($cat2));

        $categoria3 = new \App\Models\Categoria3($this->db);
        $f3->set('categoria3', $categoria3->getById($cat3));

        $categoria4 = new \App\Models\Categoria4($this->db);
        $f3->set('categoria4', $categoria4->getById($cat4));
        
        $f3->set('title', 'Nuovo');
        $f3->set('container', 'inout/nuovo5.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Nuovo_Salva($f3, $params)
    {
        // Categorie
        $cat1 = $f3->get('POST.cat1');
        $cat2 = $f3->get('POST.cat2');
        $cat3 = $f3->get('POST.cat3');
        $cat4 = $f3->get('POST.cat4');
        
        // Importo
        $importo = $f3->get('POST.importo');
        if ($cat1 == 1) {
            $importo = -$importo;
        }
        $importo = str_replace(',', '.', (string)$importo);

        // Data ex. 2018-09-13
        $data = $f3->get('POST.data');
        $data_array = explode("-", $data);
        $jd = juliantojd($data_array[1], $data_array[2], $data_array[0]);

        // Note
        $note = $f3->get('POST.note');
        $note = str_replace('"', "", $note);
        $note = str_replace("'", "", $note);
        
        $this->db->begin();
        $sql = "INSERT into movimenti values(null, '$jd', '$importo', '$note', '$cat1', '$cat2', '$cat3', '$cat4')";
        $this->db->exec($sql);
        $this->db->commit();

        $f3->reroute('/');
    }

    public function DeleteConfirm($f3, $params)
    {
        $f3->set('id', $params['id']);
        
        $f3->set('title', 'Cancella');
        $f3->set('container', 'inout/delete.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Delete($f3, $params)
    {
        $id = $f3->get('POST.id');
        $mov = new \App\Models\Movimenti($this->db);
        $mov->delete($id);

        $f3->reroute('/');
    }

    public function Lista($f3, $params)
    {
        $movimenti = new \App\Models\Movimenti($this->db);
        $f3->set('movimenti', $movimenti->all());

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

        $f3->set('title', 'Lista');
        $f3->set('container', 'inout/lista.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Statistiche($f3, $params)
    {
        $sql_categorie1 = "SELECT id, descrizione FROM categoria1";
        $categorie1 = $this->db->exec($sql_categorie1);

        $sql_categorie2_uscite = "SELECT id, descrizione FROM categoria2 WHERE madre = 1";
        $categorie2_uscite = $this->db->exec($sql_categorie2_uscite);

        $sql_categorie2_entrate = "SELECT id, descrizione FROM categoria2 WHERE madre = 2";
        $categorie2_entrate = $this->db->exec($sql_categorie2_entrate);

        // CAT2 - USCITE
        $lista2_uscite = [];
        foreach($categorie2_uscite as $uscita) {
            $id_uscita = $uscita['id'];
            $descrizione_uscita = $uscita['descrizione'];

            $sql = "SELECT SUM(importo) AS somma FROM movimenti WHERE cat1 = 1 AND cat2 = ".$id_uscita;
            $res = $this->db->exec($sql);

            $lista2_uscite[] = ['descrizione' => $descrizione_uscita, 'somma'=> $res[0]['somma']];
        }
        $f3->set('lista2_uscite', $lista2_uscite);

        // CAT2 - ENTRATE
        $lista2_entrate = [];
        foreach($categorie2_entrate as $entrata) {
            $id_entrata = $entrata['id'];
            $descrizione_entrata = $entrata['descrizione'];

            $sql = "SELECT SUM(importo) AS somma FROM movimenti WHERE cat1 = 2 AND cat2 = ".$id_entrata;
            $res = $this->db->exec($sql);

            $lista2_entrate[] = ['descrizione' => $descrizione_entrata, 'somma'=> $res[0]['somma']];
        }
        $f3->set('lista2_entrate', $lista2_entrate);

        $f3->set('euro', function ($i) {
            if ($i >= 0) {
                return "+" . number_format((float) $i, 2, '.', '') . " €";
            } else {
                return number_format((float) $i, 2, '.', '') . " €";
            }
        }
        );        

        $f3->set('title', 'Statistiche');
        $f3->set('container', 'inout/statistiche.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

}