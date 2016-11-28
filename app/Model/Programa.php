<?php

/**
 * Descriptción de Programa
 *
 * @author alfonso_fer
 */

 App::uses('AppModel', 'Model');
 App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Programa extends AppModel {
    public $hasAndBelongsToMany = array('Multiple');
    //public $actsAs = array('Containable');
    public $validate = array(
        'nombre' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe introducir un nombre de Programa'
            ),
            'unico' => array(
                'rule'    => 'isUnique',
                'message' => 'El nombre de Programa ya está utilizado'
            )
        ),
        'codificado' => array(
           'valid' => array(
               'rule' => array('inList', array('SI', 'NO')),
               'message' => 'Por favor, seleccione si el programa es HD o no',
               'allowEmpty' => false
           )
       ),
       'altadef' => array(
           'valid' => array(
               'rule' => array('inList', array('SI', 'NO')),
               'message' => 'Por favor, seleccione si el programa está codificado HD o no',
               'allowEmpty' => false
           )
       )
    );
}

?>
