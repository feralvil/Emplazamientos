<?php

/**
 * Descriptción de Municipio
 *
 * @author alfonso_fer
 */

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Servicio extends AppModel {
    public $hasMany = array('Emision', 'Cobertura');
    public $belongsTo = array('Emplazamiento','Servtipo');
    public $validate = array(
        'descripcion' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'La descripción no puede estar vacia'
            ),
            'longitud' => array(
                'rule' => array('minLength', 6),
                'message' => 'La descripción debe tener al menos 6 carácteres'
            ),
            'unico' => array(
                'rule' => 'isUnique',
                'message' => 'La descripción elegida ya está utilizada'
            )
        ),
    );
}

?>
