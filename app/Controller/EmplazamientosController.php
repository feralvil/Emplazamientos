<?php
/**
 * Controlador de la Clase Emplazamiento
 *
 * @author alfonso_fer
 */
class EmplazamientosController extends AppController {
    // Opciones de paginación por defecto:
    public $paginate = array(
        'limit' => 30,
        'order' => array('Emplazamiento.centro' => 'asc')
    );

    public function isAuthorized($user) {
        // Comprobamos el rol del usuario
        if (isset($user['role'])) {
            $rol = $user['role'];
            // Acciones por defecto
            $accPerm = array();
            if ($rol == 'colab') {
                $accPerm = array(
                    'index', 'detalle', 'editar', 'agregar', 'xlsexportar', 'mapa'
                );
            }
            elseif ($rol == 'consum') {
                $accPerm = array('index', 'detalle',);
            }
            if (in_array($this->action, $accPerm)) {
                return true;
            }
            else{
                return parent::isAuthorized($user);
            }
        }
    }


    public function index() {
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Emplazamientos de Telecomunicaciones de la Comunitat'));

        // Select de Provincias:
        $this->Emplazamiento->Municipio->recursive = -1;
        $opciones = array(
            'fields' => array('Municipio.cpro', 'Municipio.provincia'),
            'order' => 'Municipio.provincia'
        );
        $this->set('provincias', $this->Emplazamiento->Municipio->find('list', $opciones));

        // Select de Comarcas:
        $this->Emplazamiento->Comarca->recursive = -1;
        $opciones = array(
            'fields' => array('Comarca.id', 'Comarca.comarca'),
            'order' => 'Comarca.comarca'
        );
        if (!empty($this->request->data['Emplazamiento']['provincia'])){
            $opciones['conditions'] = array('Comarca.provincia' => $this->request->data['Emplazamiento']['provincia']);
        }
        $this->set('comarcas', $this->Emplazamiento->Comarca->find('list', $opciones));

        // Select de Titulares:
        $opciones = array(
            'fields' => array('Emplazamiento.titular', 'Emplazamiento.titular'),
            'order' => 'Emplazamiento.titular',
            'group' => 'Emplazamiento.titular'
        );
        $this->set('titulares', $this->Emplazamiento->find('list', $opciones));

        // Comprobamos si hemos recibido datos del formulario:
        $condiciones = array();
        if ($this->request->is('post')){
            // Condiciones iniciales:
            $tampag = 30;
            $pagina = 1;
            // Select de Provincia
            if (!empty($this->request->data['Emplazamiento']['provincia'])){
                $addcond = array('Emplazamiento.municipio_id LIKE'  => $this->request->data['Emplazamiento']['provincia'] . '%');
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Comarca
            if (!empty($this->request->data['Emplazamiento']['comarca'])){
                $addcond = array('Emplazamiento.comarca_id'  => $this->request->data['Emplazamiento']['comarca']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Titular
            if (!empty($this->request->data['Emplazamiento']['titular'])){
                $addcond = array('Emplazamiento.titular'  => $this->request->data['Emplazamiento']['titular']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de COMDES
            if (!empty($this->request->data['Emplazamiento']['comdes'])){
                $addcond = array('Emplazamiento.comdes'  => $this->request->data['Emplazamiento']['comdes']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de TDT-GVA
            if (!empty($this->request->data['Emplazamiento']['tdt-gva'])){
                $addcond = array('Emplazamiento.tdt-gva'  => $this->request->data['Emplazamiento']['tdt-gva']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de RTVV
            if (!empty($this->request->data['Emplazamiento']['rtvv'])){
                $addcond = array('Emplazamiento.rtvv'  => $this->request->data['Emplazamiento']['rtvv']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Cambio de página
            if (!empty($this->request->data['Emplazamiento']['irapag'])&&($this->request->data['Emplazamiento']['irapag'] > 0)){
                $this->paginate['page'] = $this->request->data['Emplazamiento']['irapag'];
            }
            // Tamaño de página
            if (!empty($this->request->data['Emplazamiento']['regPag'])&&($this->request->data['Emplazamiento']['regPag'] > 0)){
                $this->paginate['limit'] = $this->request->data['Emplazamiento']['regPag'];
            }
        }
        $this->paginate['conditions'] = $condiciones;
        $emplazamientos = $this->paginate();
        $this->set('emplazamientos', $emplazamientos);
    }

    public function detalle ($id = null){
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Emplazamiento de Telecomunicaciones'));
        $this->Emplazamiento->id = $id;
        if (!$this->Emplazamiento->exists()) {
            throw new NotFoundException(__('Error: el emplazamiento seleccionado no existe'));
        }
        $emplazamiento = $this->Emplazamiento->read(null, $id);

        $this->set('emplazamiento', $emplazamiento);

        // Cambiamos el Layout:
        $this->render('detalle', 'detmapa');
    }

    public function mapa () {
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Emplazamiento de Telecomunicaciones'));
        // Buscamos los emplazamientos
        $emplazamientos = $this->Emplazamiento->find('all', array('order' => 'Emplazamiento.centro'));
        $this->set('emplazamientos', $emplazamientos);

        // Cambiamos el Layout:
        $this->render('mapa', 'indexmapa');
    }

    public function xlsexportar () {
        // Buscamos los emplazamientos
        $emplazamientos = $this->Emplazamiento->find('all', array('order' => 'Emplazamiento.centro'));
        $this->set('emplazamientos', $emplazamientos);

        // Definimos la vista
        $this->render('xlsexportar', 'xls');
    }
}
?>
