<?php
/*
--------- Controlador de servicios --------------
*/

class EmisionsController extends AppController {
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
                    'servicio', 'agregar', 'editar', 'borrar', 'apagar'
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
        $this->Emision->Servicio->id = $idserv;
        if (!$this->Emision->Servicio->exists()) {
            throw new NotFoundException(__('Error: el Servicio seleccionado no existe'));
        }
        // Fijamos el título de la vista:
        $this->set('title_for_layout', __('Emisiones de Centro TDT de la Comunitat'));
        // Buscamos los datos del Servicio:
        $this->Emision->Servicio->recursive = -1;
        $servicio = $this->Emision->Servicio->read(null, $idserv);
        // Buscamos las emisiones:
        $emisiones = $this->Emision->find('all', array(
                'conditions' => array('Emision.servicio_id' => $servicio['Servicio']['id']),
            )
        );
        // Buscamos los múltiples:
        $condiciones = array('Multiple.soportado' => 'SI');
        if (!empty($emisiones)){
            $muxid = array();
            foreach ($emisiones as $emision) {
                $muxid[] = $emision['Emision']['multiple_id'];
            }
            $condiciones['NOT'] = array('Multiple.id' => $muxid);
        }
        $multiples = $this->Emision->Multiple->find('list', array(
                'fields' => array('Multiple.id', 'Multiple.nombre'),
                'conditions' => $condiciones,
            )
        );
        $this->set('multiples', $multiples);
        $servicio['Emision'] = $emisiones;
        $this->set('servicio', $servicio);
    }

    public function agregar(){
         if ($this->request->is('post') || $this->request->is('put')) {
             // Guardamos los datos:
             $this->Emision->create();
             if ($this->Emision->save($this->request->data)) {
                 $this->Flash->exito(__('Emisión agregada correctamente'));
                 $this->redirect(array('controller' => 'emisions', 'action' => 'servicio', $this->request->data['Emision']['servicio_id']));
             }
             else {
                 $this->Flash->error(__('Error al agregar la emisión'));
             }
         }
         else{
             // Error
             throw new MethodNotAllowedException();
         }
    }

    public function editar($idemision = null){
        $this->Emision->id = $idemision;
        if (!$this->Emision->exists()) {
            throw new NotFoundException(__('Error: la emisión seleccionada no existe'));
        }
        // Buscamos los datos del Múltiple:
        $emision = $this->Emision->read(null, $idemision);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Emision->save($this->request->data)) {
                $this->Flash->exito(__('Emisión modificada correctamente'));
                $this->redirect(array('controller' => 'emisions', 'action' => 'servicio', $emision['Emision']['servicio_id']));
            }
            else {
                $this->Flash->error(__('Error al modificar la emisión'));
            }
        }
        else {
            // Fijamos el título de la vista:
            $this->set('title_for_layout', __('Modificar Emisión de Centro TDT de la Comunitat'));
            $this->set('emision', $emision);
        }

    }

    public function borrar($idemision = null){
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Emision->id = $idemision;
            if (!$this->Emision->exists()) {
                throw new NotFoundException(__('Error: la emisión seleccionada no existe'));
            }
            // Buscamos los datos del Múltiple:
            $emision = $this->Emision->read(null, $idemision);
            if ($this->Emision->delete()) {
                $this->Flash->exito(__('Emisión eliminada correctamente'));
                $this->redirect(array('controller' => 'emisions', 'action' => 'servicio', $emision['Emision']['servicio_id']));
            }
            else{
                $this->Flash->error(__('Error al eliminar la emisión'));
            }
        }
        else{
            // Error
            throw new MethodNotAllowedException();
        }
    }

    public function apagar ($idserv = null){
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Emision->Servicio->id = $idserv;
            if (!$this->Emision->Servicio->exists()) {
                throw new NotFoundException(__('Error: el servicio seleccionado no existe'));
            }
            // Buscamos los datos del Múltiple:
            if ($this->Emision->deleteAll(array('Emision.servicio_id' => $idserv, false))) {
                if ($this->Emision->Servicio->Cobertura->deleteAll(array('Cobertura.servicio_id' => $idserv, false))) {
                    $this->Flash->exito(__('Emisiones apagadas correctamente'));
                    $this->redirect(array('controller' => 'servicios', 'action' => 'detalle', $idserv));
                }
                else{
                    $this->Flash->error(__('Error al eminar las coberturas'));
                }
            }
            else{
                $this->Flash->error(__('Error al apagar las emisiones'));
            }
        }
        else{
            // Error
            throw new MethodNotAllowedException();
        }
    }
}
