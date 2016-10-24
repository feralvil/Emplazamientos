<?php
/*
*   Modelo de Emplazamiento
*/

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Emplazamiento extends AppModel {
    public $belongsTo = array('Municipio', 'Comarca');
    public $validate = array(
        'centro' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'El Emplazamiento no puede estar vacío'
            ),
            'alfanumerico' => array(
                'rule' => '/^[A-Za-z0-9_-]*$/',
                'message' => 'Sólo debe introducir letras, números y guiones'
            ),
            'unico' => array(
                'rule' => 'isUnique',
                'message' => 'Ya existe un Emplazamiento con el mismo nombre'
            )
        ),
        'latitud' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'La latitud no puede estar vacía'
            ),
        ),
        'longitud' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'La latitud no puede estar vacía'
            ),
        ),
    );
}
?>
