<?php
/*
    Controlador de Múltiples
*/
class ProgramasController extends AppController {
    // Opciones de paginación por defecto:
    public $paginate = array(
        'Programa' => array(
            'limit' => 20,
            'order' => array('Programa.nombre' => 'asc')
        )
    );

    public function isAuthorized($user) {
        // Comprobamos el rol del usuario
        if (isset($user['role'])) {
            $rol = $user['role'];
            // Acciones por defecto
            $accPerm = array();
            if ($rol == 'colab') {
                $accPerm = array(
                    'index', 'editar', 'agregar', 'borrar'
                );
            }
            elseif ($rol == 'consum') {
                $accPerm = array('index');
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
        $this->set('title_for_layout', __('Programas TDT de la Comunitat'));

        // Select de Múltiples:
        ///$this->Programa->Multiple->recursive = -1;
        $opciones = array(
            'fields' => array('Multiple.id', 'Multiple.nombre'),
            'order' => 'Multiple.nombre'
        );
        $this->set('multiples', $this->Programa->Multiple->find('list', $opciones));

        // Comprobamos si hemos recibido datos del formulario:
        $condiciones = array();
        if ($this->request->is('post')){
            // Select de Altadef
            if (!empty($this->request->data['Programa']['multiple'])){
                $progmux = $this->Programa->Multiple->find('first',
                    array ('conditions' => array('id' => $this->request->data['Programa']['multiple']))
                );
                $selprogramas = array();
                foreach ($progmux['Programa'] as $selprog) {
                    $selprogramas[] = $selprog['id'];
                }
                $this->set('progmux', $selprogramas);
                $addcond = array('Programa.id'  => $selprogramas);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de Altadef
            if (!empty($this->request->data['Programa']['altadef'])){
                $addcond = array('Programa.altadef'  => $this->request->data['Programa']['altadef']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Select de codificado
            if (!empty($this->request->data['Programa']['codificado'])){
                $addcond = array('Programa.codificado'  => $this->request->data['Programa']['codificado']);
                $condiciones = array_merge($addcond, $condiciones);
            }
            // Cambio de página
            if (!empty($this->request->data['Programa']['irapag'])&&($this->request->data['Programa']['irapag'] > 0)){
                $this->paginate['page'] = $this->request->data['Programa']['irapag'];
            }
            // Tamaño de página
            if (!empty($this->request->data['Programa']['regPag'])&&($this->request->data['Programa']['regPag'] > 0)){
                $this->paginate['limit'] = $this->request->data['Programa']['regPag'];
            }
        }

        // Paginamos
        $this->paginate['Programa']['conditions'] = $condiciones;
        $programas = $this->paginate();
        $this->set('programas', $programas);
    }

    public function editar($id = null) {
        $this->Programa->id = $id;
        if (!$this->Programa->exists()) {
            throw new NotFoundException(__('Error: el programa seleccionado no existe'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $programa = array(
                'nombre' => $this->request->data['Programa']['nombre'],
                'altadef' => $this->request->data['Programa']['altadef'],
                'codificado' => $this->request->data['Programa']['codificado']
            );
            if(!empty($this->request->data['Programa']['logo']['name'])){
                $imagen = $this->request->data['Programa']['logo'];
                // Comprobamos la extensión
                $extension = substr(strtolower(strrchr($imagen['name'], '.')), 1);
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); // Extensiones permitidos
                if(in_array($extension, $arr_ext)){
                    if(move_uploaded_file($imagen['tmp_name'], WWW_ROOT . 'img' . DS .  'logos' . DS . $imagen['name'])){
                        $programa['logo'] = 'logos/' . $imagen['name'];
                    }
                    else{
                         $this->Flash->error(__('Error al modificar el programa. No se pudo guardar el logo'));
                         $this->redirect(array('controller' => 'programas', 'action' => 'editar', $id));
                    }
                }
                else{
                    $this->Flash->error(__('Error al modificar el programa. El logo debe ser una imagen'));
                    $this->redirect(array('controller' => 'programas', 'action' => 'editar', $id));
                }
            }
            if ($this->Programa->save($programa)) {
                $this->Flash->exito(__('Programa') . ' ' . $programa['nombre'] . ' ' . __('modificado correctamente'));
                $this->redirect(array('controller' => 'programas', 'action' => 'index'));
            }
            else {
                $this->Flash->error(__('Error al modificar el programa') . ' ' . $programa['nombre']);
            }
        }
        else{
            // Fijamos el título de la vista
            $this->set('title_for_layout', __('Modificar programas TDT de la Comunitat'));
            $this->request->data = $this->Programa->read(null, $id);
        }
    }

    public function agregar(){
       if ($this->request->is('post') || $this->request->is('put')) {
           // Guardamos los datos:
           $this->Programa->create();
           $programa = array(
               'nombre' => $this->request->data['Programa']['nombre'],
               'altadef' => $this->request->data['Programa']['altadef'],
               'codificado' => $this->request->data['Programa']['codificado'],
               'logo' => 'logos/nologo.png',
           );
           if(!empty($this->request->data['Programa']['logo']['name'])){
               $imagen = $this->request->data['Programa']['logo'];
               // Comprobamos la extensión
               $extension = substr(strtolower(strrchr($imagen['name'], '.')), 1);
               $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); // Extensiones permitidos
               if(in_array($extension, $arr_ext)){
                   if(move_uploaded_file($imagen['tmp_name'], WWW_ROOT . 'img' . DS .  'logos' . DS . $imagen['name'])){
                       $programa['logo'] = 'logos/' . $imagen['name'];
                   }
                   else{
                        $this->Flash->error(__('Error al crear el programa. No se pudo guardar el logo'));
                        $this->redirect(array('controller' => 'programas', 'action' => 'agregar'));
                   }
               }
               else{
                   $this->Flash->error(__('Error al crear el programa. El logo debe ser una imagen'));
                   $this->redirect(array('controller' => 'programas', 'action' => 'agregar'));
               }
           }
           if ($this->Programa->save($programa)) {
               $this->Flash->exito(__('Programa creado correctamente'));
               $this->redirect(array('controller' => 'programas', 'action' => 'index'));
           }
           else {
               $this->Flash->error(__('Error al crear el programa'));
           }
       }
       else{
           // Fijamos el título de la vista
           $this->set('title_for_layout', __('Nuevo Programa TDT de la Comunitat'));
       }
   }

   public function borrar($idprog = null){
       if ($this->request->is('post') || $this->request->is('put')) {
           $this->Programa->id = $idprog;
           if (!$this->Programa->exists()) {
               throw new NotFoundException(__('Error: el programa seleccionado no existe'));
           }
           // Buscamos los datos del Múltiple:
           $programa = $this->Programa->read(null, $id);
           if ($this->Programa->delete()) {
               $this->Flash->exito(__('Programa') . ' ' . $programa['Programa']['nombre'] . ' ' . __('eliminado correctamente'));
               $this->redirect(array('controller' => 'programas', 'action' => 'index'));
           }
           else{
               $this->Flash->error(__('Error al eliminar el programa') . ' ' . $programa['Programa']['nombre']);
           }
       }
       else{
           // Error
           throw new MethodNotAllowedException();
       }
   }
}
?>
