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
                    'index', 'detalle', 'editar', 'agregar', 'importar', 'centrostdt',
                    'servcomdes', 'servtdtgva', 'servenlaces', 'servrtvv'
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

    public function detalle($id = null){
        $this->Servicio->id = $id;
        if (!$this->Servicio->exists()) {
            throw new NotFoundException(__('Error: el Servicio seleccionado no existe'));
        }
        // Buscamos los datos del Múltiple:
        $servicio = $this->Servicio->read(null, $id);
        $tiposerv = $servicio['Servicio']['servtipo_id'];
        $vistaserv = array('1' => 'servcomdes', '2' => 'servtdtgva', '3' => 'servenlaces', '4' => 'servrtvv');
        $vista = $vistaserv[$tiposerv];
        $idmun = $servicio['Emplazamiento']['municipio_id'];
        $this->loadModel('Municipio');
        $municipio = $this->Municipio->find('first', array('conditions' =>  array('Municipio.id' => $idmun)));
        $servicio['Municipio'] = $municipio['Municipio'];
        $servicio['Municipio']['Comarca'] = $municipio['Comarca'];
        // Buscamos los EDmisiones del centro
        if (!empty($servicio['Emision'])){
            foreach ($servicio['Emision'] as &$emision) {
                $idmux = $emision['multiple_id'];
                $multiple = $this->Servicio->Emision->Multiple->find('first',
                    array(
                        'conditions' => array('id' => $idmux),
                    )
                );
                $emision['nommux'] = $multiple['Multiple']['nombre'];
                $emision['programas'] = $multiple['Programa'];
            }
        }
        // Buscamos los Coberturas del centro
        if (!empty($servicio['Cobertura'])){
            foreach ($servicio['Cobertura'] as &$cobertura) {
                $habCubiertos = 0;
                $idmun = $cobertura['municipio_id'];
                $this->loadModel('Municipio');
                $this->Municipio->recursive = -1;
                $municipio = $this->Municipio->find('first', array('conditions' =>  array('id' => $idmun)));
                $habCubiertos = $habCubiertos + $municipio['Municipio']['poblacion'] * $cobertura['porcentaje'] / 100;
                $cobertura['municipio'] = $municipio['Municipio']['nombre'];
                $cobertura['provincia'] = $municipio['Municipio']['provincia'];
                $cobertura['poblacion'] = $municipio['Municipio']['poblacion'];
                $cobertura['habCubiertos'] = round($habCubiertos);
            }
        }
        $this->set('servicio', $servicio);
        // Cambiamos el Layout:
        $this->set('title_for_layout', __('Detalle de Centro TDT de la Comunitat'));
        $this->render($vista, 'detmapa');
    }

    public function centrostdt(){
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Centros TDT de la Comunitat'));

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
        $condiciones = array($addcond = array('Servicio.servtipo_id'  => 2));
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
        foreach ($servicios as &$servicio) {
            // Buscamos los múltiples que emite el centro
            if (!empty($servicio['Emision'])){
                foreach ($servicio['Emision'] as &$emision) {
                    $idmux = $emision['multiple_id'];
                    $multiple = $this->Servicio->Emision->Multiple->find('first',
                        array(
                            'conditions' => array('id' => $idmux),
                        )
                    );
                    $emision['nommux'] = $multiple['Multiple']['nombre'];
                }
            }
            // Buscamos los Coberturas del centro
            if (!empty($servicio['Cobertura'])){
                foreach ($servicio['Cobertura'] as &$cobertura) {
                    $habCubiertos = 0;
                    $idmun = $cobertura['municipio_id'];
                    $this->loadModel('Municipio');
                    $this->Municipio->recursive = -1;
                    $municipio = $this->Municipio->find('first', array('conditions' =>  array('id' => $idmun)));
                    $habCubiertos = $habCubiertos + $municipio['Municipio']['poblacion'] * $cobertura['porcentaje'] / 100;
                    $cobertura['habCubiertos'] = round($habCubiertos);
                }
            }
        }
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
