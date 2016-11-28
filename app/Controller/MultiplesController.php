<?php
/*
    Controlador de Múltiples
*/
class MultiplesController extends AppController {
    // Opciones de paginación por defecto:
    public $paginate = array(
        'limit' => 20,
        'order' => array('Multiple.nombre' => 'asc')
    );

    public function isAuthorized($user) {
        // Comprobamos el rol del usuario
        if (isset($user['role'])) {
            $rol = $user['role'];
            // Acciones por defecto
            $accPerm = array();
            if ($rol == 'colab') {
                $accPerm = array(
                    'index', 'editar', 'agregar', 'borrar', 'agregarprog', 'borrarprog'
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
        $this->set('title_for_layout', __('Múltiples TDT de la Comunitat'));

        // Comprobamos si hemos recibido datos del formulario:
        $condiciones = array();
        if ($this->request->is('post')){
            // Select de Múltiple
            if (!empty($this->request->data['Multiple']['ambito'])){
                $addcond = array('Multiple.ambito'  => $this->request->data['Multiple']['ambito']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Soportado
            if (!empty($this->request->data['Multiple']['soportado'])){
                $addcond = array('Multiple.soportado'  => $this->request->data['Multiple']['soportado']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Cambio de página
            if (!empty($this->request->data['Multiple']['irapag'])&&($this->request->data['Multiple']['irapag'] > 0)){
                $this->paginate['page'] = $this->request->data['Multiple']['irapag'];
            }
            // Tamaño de página
            if (!empty($this->request->data['Multiple']['regPag'])&&($this->request->data['Multiple']['regPag'] > 0)){
                $this->paginate['limit'] = $this->request->data['Multiple']['regPag'];
            }
        }

        $this->paginate['conditions'] = $condiciones;
        $multiples = $this->paginate();
        $this->set('multiples', $multiples);
    }

    public function editar($id = null) {
        $this->Multiple->id = $id;
        if (!$this->Multiple->exists()) {
            throw new NotFoundException(__('Error: el múltiple seleccionado no existe'));
        }
        $multiple = $this->Multiple->read(null, $id);
        $this->set('multiple', $multiple);
        // Almacenamos los programas:
        $progmux = array();
        foreach ($multiple['Programa'] as $programa) {
            $progmux[] = $programa['id'];
        }
        // Select de Programas:
        $opciones = array(
            'fields' => array('Programa.id', 'Programa.nombre'),
            'order' => 'Programa.nombre'
        );
        $programas = $this->Multiple->Programa->find('list', $opciones);
        // Buscamos los programas a agregar (Eliminamos los que ya están):
        $selprogramas = array();
        foreach ($programas as $idprog => $nomprog) {
            if (!(in_array($idprog, $progmux))){
                $selprogramas[$idprog] = $nomprog;
            }
        }
        $this->set('programas', $selprogramas);

        if ($this->request->is('post') || $this->request->is('put')) {
            // Guardamos los datos:
            if ($this->Multiple->save($this->request->data)) {
                $this->Flash->exito(__('Múltiple') . ' ' . $this->request->data['Multiple']['nombre'] . ' ' .  __('modificado correctamente'));
                $this->redirect(array('controller' => 'multiples', 'action' => 'index'));
            }
            else {
                $this->Flash->error(__('Error al guardar el Múltiple'));
            }
        }
        else{
            // Fijamos el título de la vista
            $this->set('title_for_layout', __('Modificar múltiple TDT de la Comunitat'));
            // Datos para el formulario
            $this->request->data = $this->Multiple->read(null, $id);
        }
    }

    public function agregar(){
       if ($this->request->is('post') || $this->request->is('put')) {
           // Guardamos los datos:
           $this->Multiple->create();
           if ($this->Multiple->save($this->request->data)) {
               $this->Flash->exito(__('Múltiple creado correctamente'));
               $this->redirect(array('controller' => 'multiples', 'action' => 'index'));
           }
           else {
               $this->Flash->error(__('Error al crear el múltiple'));
           }
       }
       else{
           // Fijamos el título de la vista
           $this->set('title_for_layout', __('Nuevo Múltiple TDT de la Comunitat'));
       }
   }

   public function agregarprog(){
       if ($this->request->is('post') || $this->request->is('put')) {
           // Guardamos los datos:
           if (isset($this->request->data['Multiple']['id']) && (isset($this->request->data['Multiple']['programa']))){
               $idmux = $this->request->data['Multiple']['id'];
               $idprog = $this->request->data['Multiple']['programa'];
               $this->Multiple->MultiplesPrograma->create();
               if ($this->Multiple->MultiplesPrograma->save(array('multiple_id' => $idmux, 'programa_id' => $idprog))){
                   $this->Flash->exito(__('Programa agregado al múltiple correctamente'));
                   $this->redirect(array('controller' => 'multiples', 'action' => 'editar', $idmux));
               }
               else {
                   $this->Flash->error(__('Error al agregar el programa al múltiple'));
               }
           }
           else{
               $this->Flash->error(__('Error: No se han pasado los datos de múltiple y programa'));
               $this->redirect(array('controller' => 'multiples', 'action' => 'index'));
           }
       }
       else{
           // Error
           throw new MethodNotAllowedException();
       }
   }

   public function borrarprog($idmux = null, $idprog = null){
       if ($this->request->is('post') || $this->request->is('put')) {
           // Guardamos los datos:
           if (isset($idmux) && (isset($idprog))){
               if ($this->Multiple->MultiplesPrograma->deleteAll(array('multiple_id' => $idmux, 'programa_id' => $idprog))){
                   $this->Flash->exito(__('Programa eliminado del múltiple correctamente'));
                   $this->redirect(array('controller' => 'multiples', 'action' => 'editar', $idmux));
               }
               else {
                   $this->Flash->error(__('Error al eliminar el programa del múltiple'));
               }
           }
           else{
               $this->Flash->error(__('Error: No se han pasado los datos de múltiple y programa'));
               $this->redirect(array('controller' => 'multiples', 'action' => 'index'));
           }
       }
       else{
           // Error
           throw new MethodNotAllowedException();
       }
   }

   public function borrar($idmux = null){
       if ($this->request->is('post') || $this->request->is('put')) {
           $this->Multiple->id = $idmux;
           if (!$this->Multiple->exists()) {
               throw new NotFoundException(__('Error: el multiple seleccionado no existe'));
           }
           // Buscamos los datos del Múltiple:
           $multiple = $this->Multiple->read(null, $id);
           if ($this->Multiple->delete()) {
               $this->Flash->exito(__('Múltiple') . ' ' . $multiple['Multiple']['nombre'] . ' ' . __('eliminado correctamente'));
               $this->redirect(array('controller' => 'multiples', 'action' => 'index'));
           }
           else{
               $this->Flash->error(__('Error al eliminar el múltiple') . ' ' . $multiple['Multiple']['nombre']);
           }
       }
       else{
           // Error
           throw new MethodNotAllowedException();
       }
   }
}
?>
