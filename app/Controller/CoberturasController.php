<?php
/*
--------- Controlador de servicios --------------
*/

class CoberturasController extends AppController {
    // Opciones de paginación por defecto:
    public $paginate = array(
        'limit' => 30,
    );

    public function isAuthorized($user) {
        // Comprobamos el rol del usuario
        if (isset($user['role'])) {
            $rol = $user['role'];
            // Acciones por defecto
            $accPerm = array();
            if ($rol == 'colab') {
                $accPerm = array(
                    'servicio', 'agregar', 'editar', 'borrar'
                );
            }
            elseif ($rol == 'consum') {
                $accPerm = array();
            }
            if (in_array($this->action, $accPerm)) {
                return true;
            }
            else{
                return parent::isAuthorized($user);
            }
        }
    }

    public function servicio($idserv = null){
        $this->Cobertura->Servicio->id = $idserv;
        if (!$this->Cobertura->Servicio->exists()) {
            throw new NotFoundException(__('Error: el Servicio seleccionado no existe'));
        }
        // Fijamos el título de la vista:
        $this->set('title_for_layout', __('Cobertura de Centro TDT de la Comunitat'));
        // Buscamos los datos del Servicio:
        $this->Cobertura->Servicio->recursive = -1;
        $servicio = $this->Cobertura->Servicio->read(null, $idserv);
        // Buscamos las emisiones:
        $coberturas = $this->Cobertura->find('all', array(
                'conditions' => array('Cobertura.servicio_id' => $servicio['Servicio']['id']),
            )
        );
        // Buscamos los municipios:
        $condiciones = array('Municipio.cpro' => array('03', '12', '46'));
        if (!empty($coberturas)){
            $munid = array();
            foreach ($coberturas as $cobertura) {
                $munid[] = $cobertura['Cobertura']['municipio_id'];
            }
            $condiciones['NOT'] = array('Municipio.id' => $munid);
        }
        $municipios = $this->Cobertura->Municipio->find('list', array(
                'fields' => array('Municipio.id', 'Municipio.nombre'),
                'conditions' => $condiciones,
                'order' => array('Municipio.nombre')
            )
        );
        $this->set('municipios', $municipios);
        $servicio['Cobertura'] = $coberturas;
        $this->set('servicio', $servicio);
    }

    public function agregar(){
         if ($this->request->is('post') || $this->request->is('put')) {
             // Guardamos los datos:
             $this->Cobertura->create();
             if ($this->Cobertura->save($this->request->data)) {
                 $this->Flash->exito(__('Cobertura agregada correctamente'));
                 $this->redirect(array('controller' => 'coberturas', 'action' => 'servicio', $this->request->data['Cobertura']['servicio_id']));
             }
             else {
                 $this->Flash->error(__('Error al agregar la cobertura'));
             }
         }
         else{
             // Error
             throw new MethodNotAllowedException();
         }
    }

    public function editar($idcobertura = null){
        $this->Cobertura->id = $idcobertura;
        if (!$this->Cobertura->exists()) {
            throw new NotFoundException(__('Error: la cobertura seleccionada no existe'));
        }
        // Buscamos los datos del Múltiple:
        $cobertura = $this->Cobertura->read(null, $idcobertura);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Cobertura->save($this->request->data)) {
                $this->Flash->exito(__('Cobertura modificada correctamente'));
                $this->redirect(array('controller' => 'coberturas', 'action' => 'servicio', $cobertura['Cobertura']['servicio_id']));
            }
            else {
                $this->Flash->error(__('Error al modificar la emisión'));
            }
        }
        else {
            // Fijamos el título de la vista:
            $this->set('title_for_layout', __('Modificar Emisión de Centro TDT de la Comunitat'));
            $this->set('cobertura', $cobertura);
        }

    }

    public function borrar($idcobertura = null){
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Cobertura->id = $idcobertura;
            if (!$this->Cobertura->exists()) {
                throw new NotFoundException(__('Error: la cobertura seleccionada no existe'));
            }
            // Buscamos los datos del Múltiple:
            $cobertura = $this->Cobertura->read(null, $idcobertura);
            if ($this->Cobertura->delete()) {
                $this->Flash->exito(__('Cobertura eliminada correctamente'));
                $this->redirect(array('controller' => 'coberturas', 'action' => 'servicio', $cobertura['Cobertura']['servicio_id']));
            }
            else{
                $this->Flash->error(__('Error al eliminar la cobertura'));
            }
        }
        else{
            // Error
            throw new MethodNotAllowedException();
        }
    }
}
