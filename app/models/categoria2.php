<?php
namespace App\Models;

class Categoria2 extends \DB\SQL\Mapper
{
    public $categoria2;

    public function __construct(\DB\SQL $db) {
        parent::__construct($db,'categoria2');
        $this->categoria2 = [];
    }

    public function all() {
        $this->load();
        return $this->query;
    }

    public function getById($id) {
        $this->load(array('id=?',$id));
        return $this->query;
    }

    public function getByMadre($id) {
        $this->load(array('madre=?',$id));
        return $this->query;
    }

    public function add() {
        $this->copyFrom('POST');
        $this->save();
    }

    public function edit($id) {
        $this->load(array('id=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }

    public function delete($id) {
        $this->load(array('id=?',$id));
        $this->erase();
    }
}