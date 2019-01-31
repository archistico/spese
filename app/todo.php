<?php
namespace App;

class Todo extends Controller
{
    public function beforeroute($f3)
    {
        \App\Auth::PageCheckAuth($f3);
    }

    public $id;
    public $todo;

    public function __construct($id, $todo)
    {
        parent::__construct();
        $this->id = $id;
        $this->todo = $todo;
    }

    public function ToArray()
    {
        return ['id' => $this->id, 'todo' => $this->todo];
    }

    public function Delete($f3, $params)
    {
        $id = $params['id'];

        $t = new \App\Models\Todos($this->db);
        $t->delete($id);

        // ridirigi
        $f3->reroute('/');
    }

    public function Add($f3)
    {
        $todo = $f3->get('POST.todo');

        $todo = \App\Utility::CleanString($todo);

        if (isset($todo)) {
            $sql = "INSERT into todos values(null, '$todo')";
            $this->db->begin();
            $this->db->exec($sql);
            $this->db->commit();
        }

        // ridirigi
        $f3->reroute('/');
    }
}
