<?php

/**
 * Descriptción de Municipio
 *
 * @author alfonso_fer
 */

 App::uses('AppModel', 'Model');
 App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Nucleo extends AppModel {
    public $belongsTo = array('Municipio');
}

?>
