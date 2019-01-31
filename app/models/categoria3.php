<?php
namespace App\Models;

class Categoria3 extends \DB\SQL\Mapper
{
    public $categoria3;

    public function __construct(\DB\SQL $db) {
        parent::__construct($db,'categoria3');
        $this->categoria3 = [];
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