<?php

class Comercio extends CI_Model {

    public $id, $nombre, $logo, $latitud, $longitud, $radioCobertura, $telefono, $horarios, $categorias, $temaHeader, $temaPage, $temaFooter, $foto, $descripcion, $fotosCategorias, $fondo;

    function __construct() {
        parent::__construct();
        $this->categorias = array();
    }

    function load() {
        $query = $this->db->get('comercio');
        $resultadosComercio = $query->result();
        $resultadosComercio = $resultadosComercio[0];
        //var_dump($resultadosComercio);
        $this->id = $resultadosComercio->id;
        $this->nombre = $resultadosComercio->nombre;
        $this->logo = $resultadosComercio->logo;
        $this->latitud = $resultadosComercio->latitud;
        $this->longitud = $resultadosComercio->longitud;
        $this->radioCobertura = $resultadosComercio->radioCobertura;
        $this->telefono = $resultadosComercio->telefono;
        $this->temaHeader = $resultadosComercio->temaHeader;
        $this->temaPage = $resultadosComercio->temaPage;
        $this->temaFooter = $resultadosComercio->temaFooter;
        $this->foto = $resultadosComercio->foto;
        $this->descripcion = $resultadosComercio->descripcion;
        $this->fotosCategorias = $resultadosComercio->fotosCategorias;
        $this->fondo = $resultadosComercio->fondo;
        // Construye horarios
        $this->db->order_by('dia');
        $query = $this->db->get('horario');
        $resultados = $query->result();
        $keyDia = '';
        $arrHorarios = array();
        foreach ($resultados as $resultado) {
            if ($resultado->dia != $keyDia) {
                $arrHorarios[] = new HorarioDia($resultado->dia, array($resultado->horario));
                $keyDia = $resultado->dia;
            } else {
                $arrHorarios[count($arrHorarios) - 1]->horarios[] = $resultado->horario;
            }
        }
        $this->horarios = $arrHorarios;
        $query = $this->db->get('categoria');
        $resultadosCategorias = $query->result();
        foreach ($resultadosCategorias as $resultadosCategoria) {
            $categoria = new Categoria();
            $categoria->id = $resultadosCategoria->id;
            $categoria->icono = $resultadosCategoria->icono;
            $categoria->nombre = $resultadosCategoria->nombre;
            $this->categorias[] = $categoria;
        }
    }

    function save() {
        $id = $this->id;
        $data = array(
            'nombre' => $this->nombre,
            'logo' => $this->logo,
            'telefono' => $this->telefono,
            'descripcion' => $this->descripcion,
            'radioCobertura' => $this->radioCobertura,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'foto' => $this->foto,
            'fondo' => $this->fondo,
            'temaHeader' => $this->temaHeader,
            'temaPage' => $this->temaPage,
            'temaFooter' => $this->temaFooter,
            'fotosCategorias' => $this->fotosCategorias
        );
        $this->db->where('id', $id);
        $this->db->update('comercio', $data);
    }

    function toHtmlHorarios() {
        $strHtml = '<ul data-role="listview">';
        foreach ($this->horarios as $horario) {
            $strHtml.= '<li><span>' . $horario->getTextoDia() . '  </span><span class="nobold">';
            $strHtml.= implode(',', $horario->horarios);
            $strHtml.= '</span></li>';
        }
        $strHtml.='</ul>';
        return $strHtml;
    }

}

?>
