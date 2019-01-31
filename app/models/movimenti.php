<?php
namespace App\Models;

class Movimenti extends \DB\SQL\Mapper
{
    public $movimenti;

    public function __construct(\DB\SQL $db) {
        parent::__construct($db,'movimenti');
        $this->movimenti = [];
    }

    public function all() {
        $this->load();
        return $this->query;
    }

    public function last10() {
        $this->load([], ['order' => 'giorno DESC','limit' => 10,'offset' => 0]);
        return $this->query;
    }

    public function getById($id) {
        $this->load(array('id=?',$id));
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