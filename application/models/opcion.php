<?php

class Opcion extends CI_Model {

    public $id, $nombre, $precio;

    function __construct() {
        parent::__construct();
        
    }

    function load($id) {
        $query = $this->db->get_where('opcion', array('id =' => $id));
        $resultadosBd = $query->result();
        $resultados = $resultadosBd[0];
        $this->id = $resultados->id;
        $this->nombre = $resultados->nombre;
        $this->precio = $resultados->precio;
    }

}

?>
