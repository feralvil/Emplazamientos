<?php
/**
 * Descriptción de Emisión
 *
 * @author alfonso_fer
 */

 App::uses('AppModel', 'Model');
 App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Emision extends AppModel {
    public $belongsTo = array('Servicio', 'Multiple');
    public $validate = array(
        'servicio_id' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe seleccionar un centro TDT'
            )
        ),
        'multiple_id' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe seleccionar un Múltiple'
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
