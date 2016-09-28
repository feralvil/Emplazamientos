<?php
/**
 * Controlador de la Clase User
 *
 * @author alfonso_fer
 */
class UsersController extends AppController {

    // Opciones de paginación por defecto:
    public $paginate = array(
        'limit' => 30,
        'order' => array('User.apellido1' => 'asc','User.apellido2' => 'asc','User.nombre' => 'asc')
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('agregar');
    }

    public function isAuthorized($user) {
        if ($this->action === 'acceso') {
            if (isset($user['id'])){
                $userId = $this->request->params['pass'][0];
                if ($userId === $user['id']){
                    return TRUE;
                }
            }
        }
        return parent::isAuthorized($user);
    }

    public function login() {
        $this->render('login', 'inicio');
        $this->set('title_for_layout', __('Iniciar Sesión'));
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                // Comprobamos si Usuario = Contraseña
                if (($this->Auth->user('resetpw') == "SI")){
                    return $this->redirect(array('action' => 'acceso', $this->Auth->user('id')));
                }
                else{
                    return $this->redirect($this->Auth->redirectUrl());
                }
            } else {
                $this->Flash->error(__('Usuario o Contraseña incorrectos'));
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function index() {
        // Fijamos el título de la vista
        $this->set('title_for_layout', __('Usuarios de la aplicación de Coberturas TDT'));

        // Array de condiciones para la búsqueda:
        $condiciones = array();
        // Comprobamos si hemos recibido datos del formulario:
        if ($this->request->is('post')) {
            // Condiciones iniciales:
            $tampag = 30;
            $pagina = 1;

            // Condición para elegir un usuario
            if (!empty($this->request->data['User']['usersel'])) {
                $addcond = array('User.id' => $this->request->data['User']['usersel']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Condición para elegir un tipo de usuario
            if (!empty($this->request->data['User']['role'])) {
                $addcond = array('User.role' => $this->request->data['User']['role']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Cambio de página
            if (!empty($this->request->data['User']['irapag']) && ($this->request->data['User']['irapag'] > 0)) {
                $this->paginate['page'] = $this->request->data['User']['irapag'];
            }
            // Tamaño de página
            if (!empty($this->request->data['User']['regPag']) && ($this->request->data['User']['regPag'] > 0)) {
                $this->paginate['limit'] = $this->request->data['User']['regPag'];
            }
        }
        $this->User->recursive = 0;
        $this->paginate['conditions'] = $condiciones;
        $this->set('users', $this->paginate());
    }

    public function agregar() {
        if (($this->request->is('post')) || ($this->request->is('put'))) {
            $this->request->data['User']['password'] = $this->request->data['User']['username'];
            $this->request->data['User']['passconf'] = $this->request->data['User']['username'];
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->exito(__('Usuario creado correctamente'));
                $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Flash->error(__('No se pudo crear el usuario. Por favor, intentalo de nuevo.'));
            }
        }
        else{
            // Fijamos el título de la vista
            $this->set('title_for_layout', __('Agregar Usuario'));
        }
    }

    public function editar($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Usuario incorrecto'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->exito(__('Usuario modificado correctamente'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('No se pudo modificar el usuario. Por favor, intentalo de nuevo.'));
            }
        }
        else {
            // Fijamos el título de la vista
            $this->set('title_for_layout', __('Modificar Usuario de la aplicación de Coberturas TDT'));
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

     public function acceso($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('El usuario seleccionado no existe'));
        }
        $usuario = $this->User->read(null, $id);
        $this->set('usuario', $usuario);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['User']['resetpw'] = 'NO';
            if ($this->User->save($this->request->data)) {
                $this->Flash->exito(__('Se ha modificado la contraseña correctamente'));
                $controladorv = 'emplazamientos';
                if ($this->Auth->user('role') == 'admin'){
                    $controlador = 'users';
                }
                $this->redirect(array('controller' => $controlador, 'action' => 'index'));
            } else {
                $this->Flash->error(__('No se pudo modificar el usuario. Por favor, intentalo de nuevo.'));
            }
        }
        else {
            // Fijamos el título de la vista
            $this->set('title_for_layout', __('Modificar Contraseña de Usuario'));
            $this->request->data = $usuario;
            unset($this->request->data['User']['password']);
        }
    }

    public function resetear($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Usuario incorrecto'));
        }
        $usuario = $this->User->read('username', $id);
        $this->User->set(array(
            'password' => $usuario['User']['username'],
            'passconf' => $usuario['User']['username'],
            'resetpw' => 'SI'
        ));
        if ($this->User->save()) {
            $this->Flash->exito(__('Se ha reseteado la contraseña del usuario'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Flash->error(__('No se pudo modificar el usuario. Por favor, intentalo de nuevo.'));
        }

    }

    public function borrar($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Usuario incorrecto'));
        }
        if ($this->User->delete()) {
            $this->Flash->exito(__('Usuario eliminado'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('No se pudo eliminar el usuario'));
        $this->redirect(array('action' => 'index'));
    }

}
?>
