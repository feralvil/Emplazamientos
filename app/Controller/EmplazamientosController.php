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
                    'index', 'detalle', 'editar', 'agregar', 'xlsexportar', 'mapa', 'entidades'
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
            'fields' => array('Emplazamiento.entidad_id'),
            'order' => 'Emplazamiento.entidad_id',
            'group' => 'Emplazamiento.entidad_id'
        );
        $titulares = $this->Emplazamiento->find('list', $opciones);
        $titsel = array();
        foreach ($titulares as $titular){
            $this->Emplazamiento->Entidad->recursive = -1;
            $entidad = $this->Emplazamiento->Entidad->read(null, $titular);
            $nomentidad = $entidad['Entidad']['nombre'];
            $vectent = explode(' ', $nomentidad);
            $entidad = $vectent[0];
            $indice = $titular;
            switch ($entidad) {
                case 'Generalitat':
                    $entidad = 'GVA';
                    break;

                case 'Ayuntamiento':
                    $entidad = 'GVA-AYTO';
                    $indice = 100;
                    break;

                case 'Ferrocarrils':
                    $entidad = 'FGV';
                    break;

                case 'RadioTelevisió':
                    $entidad = 'RTVV';
                    break;

                case 'Diputación':
                    $entidad = 'DIP. ' . mb_strtoupper($vectent[2]);
                    break;

                default:
                    $entidad = mb_strtoupper($entidad);
                    break;
            }
            $titsel[$indice] = $entidad;
        }
        $this->set('titulares', $titsel);

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
            // Input de Centro
            if (!empty($this->request->data['Emplazamiento']['centro'])){
                $addcond = array('Emplazamiento.centro LIKE'  => '%' . $this->request->data['Emplazamiento']['centro'] . '%');
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Comarca
            if (!empty($this->request->data['Emplazamiento']['comarca'])){
                $addcond = array('Emplazamiento.comarca_id'  => $this->request->data['Emplazamiento']['comarca']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Titular
            if (!empty($this->request->data['Emplazamiento']['titular'])){
                if ($this->request->data['Emplazamiento']['titular'] == 100){                    
                    $addcond = array('Emplazamiento.entidad_id BETWEEN ? AND ?'  => array(6,547));
                }
                else{
                    $addcond = array('Emplazamiento.entidad_id'  => $this->request->data['Emplazamiento']['titular']);
                }
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

    public function entidades(){
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Importar Titulares de Emplazamientos'));
        // Limitamos el alcance de las búsquedas:
        $this->Emplazamiento->recursive = -1;
        // Buscamos el fichero
        App::uses('Folder', 'Utility');
        App::uses('File', 'Utility');
        // Comrpobamos si existe
        $ruta = 'files' . DS . 'EmplazamientosTitulares.ods';
        $fichero = new File($ruta, false);
        if ($fichero->exists()){
            // Cargamos la clase para leer el fichero Excel:
            App::import('Vendor', 'Classes/PHPExcel');
            // Intentamos cargar el fichero
            try{
                $tipoFich = PHPExcel_IOFactory::identify($ruta);
                $objReader = PHPExcel_IOFactory::createReader($tipoFich);
                // Sólo nos interesa cargar los datos:
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($ruta);
            }
            catch(Exception $e){
                die("Error al cargar el fichero de datos: ".$e->getMessage());
            }
            // Nos vamos a la hoja de Catastro
            // Fijamos como hoja activa la primera (sólo se importa una)
            $objPHPExcel->setActiveSheetIndex(0);
            // Obtenemos el número de filas de la hoja:
            $maxfila = $objPHPExcel->getActiveSheet()->getHighestRow() + 1;
            $fila = 2;
            $emplazamientos = array();
            while (($fila < $maxfila) && ($objPHPExcel->getActiveSheet()->getCell("A" . $fila)->getValue()!= "")){
                $idemp = $objPHPExcel->getActiveSheet()->getCell("A" . $fila)->getValue();
                $emplazamiento = $this->Emplazamiento->read(null, $idemp);
                $emplazamiento['Emplazamiento']['entidad_id'] = $objPHPExcel->getActiveSheet()->getCell("G" . $fila)->getValue();
                $emplazamientos[] = $emplazamiento;
                $fila++;
            }
            if ($this->request->is('post') || $this->request->is('put')) {
                $datos = array();
                foreach ($emplazamientos as $emplazamiento) {
                    $datosemp = array(
                        'Emplazamiento' => array(
                            'id' => $emplazamiento['Emplazamiento']['id'],
                            'entidad_id' => $emplazamiento['Emplazamiento']['entidad_id'],
                        ),
                    );
                    $datos[] = $datosemp;
                }
                $nemp = count($datos);
                if ($this->Emplazamiento->saveMany($datos)){
                    $this->Flash->exito(__('Actualizados correctamente') . ' ' . $nemp . ' ' . __('Emplazamientos') . '.');
                    $this->redirect(array('controller' => 'emplazamientos', 'action' => 'index'));
                }
                else{
                    $this->Flash->error(__('Error al guardar las entidades'));
                    $this->redirect(array('controller' => 'emplazamientos', 'action' => 'entidades'));
                }
            }
            else{
                $this->set('emplazamientos', $emplazamientos);
            }
        }
    }
}
?>
