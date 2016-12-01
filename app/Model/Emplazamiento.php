<?php
/*
*   Modelo de Emplazamiento
*/

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Emplazamiento extends AppModel {
    public $belongsTo = array('Municipio', 'Comarca', 'Entidad');
    public $hasMany = array('Servicio');
    //public $actsAs = array('Containable');
    public $validate = array(
        'centro' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'El Emplazamiento no puede estar vacío'
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
