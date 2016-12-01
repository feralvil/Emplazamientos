<h1><?php echo __('Nuevo Emplazamiento de Telecomunicaciones de la Comunitat'); ?></h1>
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
<fieldset>
    <legend><?php echo  __('Servicios del Emplazamiento'); ?></legend>
    <div class="form-group col-sm-4">
        <?php
        $opciones = array('NO' => 'No', 'SI' => 'Sí');
        echo $this->Form->label('Emplazamiento.comdes', __('Servicio COMDES'));
        echo $this->Form->input('Emplazamiento.comdes', array('options' => $opciones, 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-4">
        <?php
        echo $this->Form->label('Emplazamiento.tdt-gva', __('Servicio TDT Generalitat'));
        echo $this->Form->input('Emplazamiento.tdt-gva', array('options' => $opciones, 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-4">
        <?php
        echo $this->Form->label('Emplazamiento.rtvv', __('Servicio TDT RTVV'));
        echo $this->Form->input('Emplazamiento.rtvv', array('options' => $opciones, 'class' => 'form-control'));
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
            array('controller' => 'emplazamientos', 'action' => 'index'),
            array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
        );
        ?>
    </div>
</div>
<?php
echo $this->Form->end();
?>
