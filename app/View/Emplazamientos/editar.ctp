<h1><?php echo __('Modificar Emplazamiento de Telecomunicaciones de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Emplazamiento', array(
    'inputDefaults' => array('label' => false,'div' => false),
));
?>
<fieldset>
    <legend><?php echo  __('Datos del Emplazamiento'); ?></legend>
    <div class="form-group col-sm-6">
        <?php
        echo $this->Form->label('Emplazamiento.centro', __('Nombre'));
        echo $this->Form->input('Emplazamiento.centro', array('div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-6">
        <?php
        $vectent = explode(' ', $this->request->data['Entidad']['nombre']);
        if ($vectent[0] == "Ayuntamiento"){
            $this->request->data['Emplazamiento']['entidad_id'] = 100;
        }
        echo $this->Form->label('Emplazamiento.entidad_id', __('Titular'));
        echo $this->Form->input('Emplazamiento.entidad_id', array('options' => $titulares, 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend><?php echo  __('Ubicación del Emplazamiento'); ?></legend>
    <div class="form-group col-sm-6">
        <?php
        echo $this->Form->label('Emplazamiento.municipio_id', __('Municipio'));
        echo $this->Form->input('Emplazamiento.municipio_id', array('options' => $municipios, 'div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo $this->Form->label('Emplazamiento.latitud', __('Latitud'));
        echo $this->Form->input('Emplazamiento.latitud', array('div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo $this->Form->label('Emplazamiento.longitud', __('Longitud'));
        echo $this->Form->input('Emplazamiento.longitud', array('div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<div class="form-group text-center">
    <div class="btn-group" role="group" aria-label="...">
        <?php
        echo $this->Form->button(
        '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> &nbsp;' . __('Guardar Cambios'),
        array('type' => 'submit', 'class' => 'btn btn-default', 'title' => __('Guardar Cambios'), 'alt' => __('Guardar Cambios'), 'escape' => false)
        );
        echo $this->Form->button(
        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>  &nbsp;'.__('Cancelar Cambios'),
        array('type' => 'reset', 'class' => 'btn btn-default', 'title' => __('Cancelar Cambios'), 'alt' => __('Cancelar Cambios'), 'escape' => false)
        );
        echo $this->Html->Link(
            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
            array('controller' => 'emplazamientos', 'action' => 'detalle', $this->request->data['Emplazamiento']['id']),
            array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
        );
        ?>
    </div>
</div>
<?php
echo $this->Form->end();
$servicios = array(1 => 0, 2 => 0, 4 => 0);
$nomserv = array(1 => 'COMDES', 2 => 'TDT-GVA', 4 => 'RTVV');
foreach ($this->request->data['Servicio'] as $servemp) {
    $servicios[$servemp['servtipo_id']] = $servemp['id'];
}
?>
<fieldset>
    <legend><?php echo  __('Servicios del Emplazamiento'); ?></legend>
    <?php
    foreach ($servicios as $indexserv => $idserv) {
        $servicon = 'glyphicon glyphicon-remove';
        $texto = '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' . __('Agregar');
        $title = __('Agregar Servicio');
        $accion = array('controller' => 'emplazamientos', 'action' => 'agregarserv', $this->request->data['Emplazamiento']['id'], $indexserv);
        $aviso = __('¿Seguro que desea agregar el servicio'). ' '. $nomserv[$indexserv] . ' ' . __('al emplazamiento') . ' ' . $this->request->data['Emplazamiento']['centro'] . "?";
        if ($idserv > 0){
            $servicon = 'glyphicon glyphicon-ok';
            $texto = '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ' . __('Borrar');
            $title = __('Borrar Servicio');
            $accion = array('controller' => 'emplazamientos', 'action' => 'borrarserv', $this->request->data['Emplazamiento']['id'], $idserv);
            $aviso = __('¿Seguro que desea borrar el servicio'). ' '. $nomserv[$indexserv] . ' ' . __('del emplazamiento') . ' ' . $this->request->data['Emplazamiento']['centro'] . "?";
        }
    ?>
        <div class="col-sm-4 text-center">
            <?php echo $nomserv[$indexserv]; ?> &mdash; <span class="'. <?php echo $servicon;?> . '" aria-hidden="true"></span> <br />
            <?php
            echo $this->Form->postLink(
                $texto,
                $accion,
                array('class' => 'btn btn-default', 'title' => $title, 'escape' => false),
                $aviso
            );
            ?>
        </div>
    <?php
    }
    ?>
</fieldset>
