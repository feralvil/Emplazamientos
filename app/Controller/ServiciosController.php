<?php
/*
--------- Controlador de servicios --------------
*/

class ServiciosController extends AppController {
    // Opciones de paginación por defecto:
    public $paginate = array(
        'limit' => 30,
        'order' => array('Servicio.descripcion' => 'asc')
    );

    public function isAuthorized($user) {
        // Comprobamos el rol del usuario
        if (isset($user['role'])) {
            $rol = $user['role'];
            // Acciones por defecto
            $accPerm = array();
            if ($rol == 'colab') {
                $accPerm = array(
                    'index', 'detalle', 'editar', 'agregar', 'importar'
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

    public function index(){
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Servicios de Telecomunicaciones de la Comunitat'));

        // Select de Emplazamiento:
        $this->Servicio->Emplazamiento->recursive = -1;
        $opciones = array(
            'fields' => array('Emplazamiento.id', 'Emplazamiento.centro'),
            'order' => 'Emplazamiento.centro'
        );
        $this->set('emplazamientos', $this->Servicio->Emplazamiento->find('list', $opciones));

        // Select de Tipo de Servicio:
        $this->Servicio->Servtipo->recursive = -1;
        $opciones = array(
            'fields' => array('Servtipo.id', 'Servtipo.nombre'),
            'order' => 'Servtipo.nombre'
        );
        $this->set('tiposerv', $this->Servicio->Servtipo->find('list', $opciones));

        // Comprobamos si hemos recibido datos del formulario:
        $condiciones = array();
        if ($this->request->is('post')){
            // Select de Emplazamiento
            if (!empty($this->request->data['Servicio']['emplazamiento'])){
                $addcond = array('Servicio.emplazamiento_id'  => $this->request->data['Servicio']['emplazamiento']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Tipo de Servicio
            if (!empty($this->request->data['Servicio']['servtipo'])){
                $addcond = array('Servicio.servtipo_id'  => $this->request->data['Servicio']['servtipo']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Cambio de página
            if (!empty($this->request->data['Servicio']['irapag'])&&($this->request->data['Servicio']['irapag'] > 0)){
                $this->paginate['page'] = $this->request->data['Servicio']['irapag'];
            }
            // Tamaño de página
            if (!empty($this->request->data['Servicio']['regPag'])&&($this->request->data['Servicio']['regPag'] > 0)){
                $this->paginate['limit'] = $this->request->data['Servicio']['regPag'];
            }
        }

        $this->paginate['conditions'] = $condiciones;
        $servicios = $this->paginate();
        $this->set('servicios', $servicios);

    }

    public function importar(){
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Importar Servicios de Telecomunicaciones'));
        // Buscamos los emplazamientos
        $this->Servicio->Emplazamiento->recursive = -1;
        $emplazamientos = $this->Servicio->Emplazamiento->find('all', array('order' => 'Emplazamiento.centro'));
        $servicios = array();
        $tiposerv = array(1 => 'comdes', 2 => 'tdt-gva', 4 => 'rtvv');
        foreach ($emplazamientos as $emplazamiento) {
            $centro = $emplazamiento['Emplazamiento']['centro'];
            foreach ($tiposerv as $servindex => $servnom) {
                $servicio = array();
                if ($emplazamiento['Emplazamiento'][$servnom] == 'SI'){
                    $servicio ['servtipo_id'] = $servindex;
                    $servicio ['descripcion'] = 'Servicio' . ' ' . strtoupper($servnom) . ' de ' . $centro;
                    $servicio ['emplazamiento_id'] = $emplazamiento['Emplazamiento']['id'];
                    $servicios[] = $servicio;
                }
            }
        }
        $this->set('servicios', $servicios);
        if ($this->request->is('post') || $this->request->is('put')) {
            $nserv = count($servicios);
            $this->Servicio->create();
            if ($this->Servicio->saveAll($servicios)){
                $this->Flash->exito(__('Importados correctamente') . ' ' . $nserv . ' ' . __('Servicios') . '.');
                $this->redirect(array('controller' => 'servicios', 'action' => 'importar'));
            }
            else{
                $this->Flash->error(__('Error al guardar los servicios'));
                $this->redirect(array('controller' => 'servicios', 'action' => 'importar'));
            }
        }
    }
}

?>
