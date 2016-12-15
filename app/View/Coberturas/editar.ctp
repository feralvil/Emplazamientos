<?php
$this->request->data = $cobertura;
?>
<h1><?php echo __('Modificar Cobertura del') . ' ' . $cobertura['Servicio']['descripcion']; ?></h1>
<?php
echo $this->Form->create('Cobertura', array(
    'inputDefaults' => array('label' => false,'div' => false)
));
?>
<fieldset>
    <legend><?php echo __('Modificar Cobertura del Municipio') . ' ' . $cobertura['Municipio']['nombre']; ?></legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Cobertura.porcentaje', __('Porcentaje'));
        echo $this->Form->input('Cobertura.porcentaje', array('div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<div class="form-group text-center">
    <div class="btn-group" role="group" aria-label="...">
        <?php
        echo $this->Form->button(
        '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> &nbsp;' . __('Guardar Cobertura'),
        array('type' => 'submit', 'class' => 'btn btn-default', 'title' => __('Guardar Emisión'), 'alt' => __('Guardar Emisión'), 'escape' => false)
        );
        echo $this->Form->button(
        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>  &nbsp;'.__('Cancelar Cambios'),
        array('type' => 'reset', 'class' => 'btn btn-default', 'title' => __('Cancelar Cambios'), 'alt' => __('Cancelar Cambios'), 'escape' => false)
        );
        echo $this->Html->Link(
            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
            array('controller' => 'emisions', 'action' => 'servicio', $cobertura['Servicio']['id']),
            array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
        );
        ?>
    </div>
</div>
<?php
echo $this->Form->end();
?>
