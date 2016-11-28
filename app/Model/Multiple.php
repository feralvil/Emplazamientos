<?php

/**
 * Descriptción de Múltiple
 *
 * @author alfonso_fer
 */

 App::uses('AppModel', 'Model');
 App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Multiple extends AppModel {
    public $hasAndBelongsToMany = array('Programa');
    public $validate = array(
        'nombre' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe introducir un nombre de Múltiple'
            ),
            'unico' => array(
                'rule'    => 'isUnique',
                'message' => 'El nombre de Múltiple ya está utilizado'
            )
        ),
        'ambito' => array(
           'valid' => array(
               'rule' => array('inList', array('NAC', 'AUT', 'LOC')),
               'message' => 'Por favor, seleccione un ámbito válido',
               'allowEmpty' => false
           )
       ),
       'soportado' => array(
           'valid' => array(
               'rule' => array('inList', array('SI', 'NO')),
               'message' => 'Por favor, indique si el múltiple esta soportado o no',
               'allowEmpty' => false
           )
       )
    );
}

?>
