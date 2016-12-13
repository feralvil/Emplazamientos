<?php
/**
 * Descriptción de Emisión
 *
 * @author alfonso_fer
 */

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Cobertura extends AppModel {
    public $belongsTo = array('Servicio', 'Municipio');
    public $validate = array(
        'municipio_id' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe seleccionar un Municipio'
            )
        ),
        'servicio_id' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe seleccionar un Servicio'
            )
        ),
        'canal' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe seleccionar un Canal'
            )
        ),
        'tipo' => array(
           'valid' => array(
               'rule' => array('inList', array('E', 'GF')),
               'message' => 'Por favor, indique si es un centro Emisor o Gap-Filler',
               'allowEmpty' => false
           )
       )
   );
}
?>
