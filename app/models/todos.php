<?php
namespace App\Models;

class Todos extends \DB\SQL\Mapper
{
    public $todos;

    public function __construct(\DB\SQL $db) {
        parent::__construct($db,'todos');
        $this->todos = [];
    }

    public function all() {
        $this->load();
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

    /*
    public function Add($todo)
    {
        $this->todos[] = $todo;
    }

    public function ToArray()
    {
        $ret = [];
        foreach ($this->todos as $todo) {
            $ret[] = $todo->ToArray();
        }
        return $ret;
    }

    public function GetList()
    {
        return $this->todos;
    }
    */
}
