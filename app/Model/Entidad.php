<?php

/**
 * Descriptción de Entidad
 *
 * @author alfonso_fer
 */

 App::uses('AppModel', 'Model');
 App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Entidad extends AppModel {
    public $useTable = 'entidades';
    public $hasMany = array('Emplazamiento');
}

?>
