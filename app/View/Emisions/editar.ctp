<?php
$this->request->data = $emision;
$tipos = array('E' => 'Emisor', 'GF' => 'Gap-Filler');
?>
<h1><?php echo __('Modificar Emisiones del') . ' ' . $emision['Servicio']['descripcion']; ?></h1>
<?php
echo $this->Form->create('Emision', array(
    'inputDefaults' => array('label' => false,'div' => false)
));
?>
<fieldset>
    <legend><?php echo __('Modificar Multiple') . ' ' . $emision['Multiple']['nombre']; ?></legend>
    <div class="form-group col-sm-4">
        <?php
        echo $this->Form->label('Emision.canal', __('Canal'));
        echo $this->Form->input('Emision.canal', array('class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-4">
        <?php
        echo $this->Form->label('Emision.tipo', __('Tipo'));
        echo $this->Form->input('Emision.tipo', array('options' => $tipos, 'empty' => __('Seleccionar'), 'div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-4">
        <?php
        echo $this->Form->label('Emision.retardo', __('Retardo') . ' (x100 ns)');
        echo $this->Form->input('Emision.retardo', array('class' => 'form-control'));
        ?>
    </div>
</fieldset>
<div class="form-group text-center">
    <div class="btn-group" role="group" aria-label="...">
        <?php
        echo $this->Form->button(
        '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> &nbsp;' . __('Guardar Emisión'),
        array('type' => 'submit', 'class' => 'btn btn-default', 'title' => __('Guardar Emisión'), 'alt' => __('Guardar Emisión'), 'escape' => false)
        );
        echo $this->Form->button(
        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>  &nbsp;'.__('Cancelar Cambios'),
        array('type' => 'reset', 'class' => 'btn btn-default', 'title' => __('Cancelar Cambios'), 'alt' => __('Cancelar Cambios'), 'escape' => false)
        );
        echo $this->Html->Link(
            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
            array('controller' => 'emisions', 'action' => 'servicio', $emision['Servicio']['id']),
            array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
        );
        ?>
    </div>
</div>
<?php
echo $this->Form->end();
?>
