<?php

/**
 * Modelo de Usuarios (User)
 *
 * @author alfonso_fer
 */

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'El usuario no puede estar vacio'
            ),
            'alfanumerico' => array(
                'rule' => '/^[A-Za-z0-9_-]*$/',
                'message' => 'Sólo debe introducir letras, números y guiones'
            ),
            'longitud' => array(
                'rule' => array('minLength', 6),
                'message' => 'El usuario debe tener al menos 6 carácteres'
            ),
            'unico' => array(
                'rule' => 'isUnique',
                'message' => 'El usuario elegido ya está utilizado'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'La contraseña no debe estar vacía'
            ),
            'alfanumerico' => array(
                'rule' => '/^[A-Za-z0-9_-]*$/',
                'message' => 'Sólo debe introducir letras, números y guiones'
            ),
            'longitud' => array(
                'rule'    => array('minLength', 6),
                'message' => 'La contraseña debe tener al menos 6 carácteres'
            ),
            'coincide' => array(
                'rule' => 'compruebaPassword',
                'message' => 'La contraseña y su confirmación no coinciden'
            )
        ),
        'passconf' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'La confirmación de la contraseña no puede estar vacía'
            ),
            'alfanumerico' => array(
                'rule' => '/^[A-Za-z0-9_-]*$/',
                'message' => 'Sólo debe introducir letras y números'
            ),
            'longitud' => array(
                'rule'    => array('minLength', 6),
                'message' => 'La contraseña debe tener al menos 6 carácteres'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'colab', 'consum')),
                'message' => 'Por favor, seleccione un rol válido',
                'allowEmpty' => false
            )
        ),
        'nombre' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'El nombre no puede estar vacío'
            ),
        )
    );

    public function compruebaPassword($data) {
        if ($data['password']==$this->data['User']['passconf']){
            return true;
        }

        $this->invalidate('password_conf', __('La contraseña y su confirmación no coinciden'));
        unset($this->data['User']['password']);
        unset($this->data['User']['passconf']);
        return false;
    }

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        return true;
    }
}

?>
