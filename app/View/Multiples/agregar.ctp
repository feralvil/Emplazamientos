<?php
// Dinamismo con JQuery
$funcselect = "var programa = $(this).val();";
$funcselect .= "if (programa > 0){";
$funcselect .= '$("#addboton").removeClass("hidden");';
$funcselect .= "} else {";
$funcselect .= '$("#addboton").addClass("hidden");}';
$this->Js->get("select#MultiplePrograma");
$this->Js->event('change', $funcselect);
?>
<h1><?php echo __('Agregar Múltiple TDT') ?></h1>
<?php
echo $this->Form->create('Multiple', array(
    'inputDefaults' => array('label' => false,'div' => false),
));
?>
<fieldset>
    <legend><?php echo  __('Datos del Múltiple'); ?></legend>
    <div class="form-group col-sm-4">
        <?php
        echo $this->Form->label('Multiple.nombre', __('Nombre'));
        echo $this->Form->input('Multiple.nombre', array('div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-4">
        <?php
        $ambitos = array ('NAC' => __('Nacional'), 'AUT' => __('Autonómico'), 'LOC' => __('Local'));
        echo $this->Form->label('Multiple.ambito', __('Ámbito'));
        echo $this->Form->input('Multiple.ambito', array('options' => $ambitos, 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-4">
        <?php
        $opciones = array ('SI' => 'Sí', 'NO' => 'No');
        echo $this->Form->label('Multiple.soportado', __('Soportado'));
        echo $this->Form->input('Multiple.soportado', array('options' => $opciones, 'class' => 'form-control'));
        ?>
    </div>
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
                array('controller' => 'multiples', 'action' => 'index'),
                array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
            );
            ?>
        </div>
    </div>
</fieldset>
<?php
echo $this->Form->end();
?>
