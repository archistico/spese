<?php
namespace App;

class Controller {

    protected $f3;
    protected $db;

    function __construct() {

        $f3=\Base::instance();
        $this->f3=$f3;

        $db = new \DB\SQL($f3->get('DB_APP'));

        $this->db=$db;
    }

}
