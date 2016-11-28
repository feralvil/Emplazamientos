<h1><?php echo __('Agregar Programa TDT de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Programa', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'type' => 'file'
));
?>
<fieldset>
    <legend><?php echo  __('Datos del Programa'); ?></legend>
    <div class="form-group col-sm-4">
        <?php
        echo $this->Form->label('Programa.nombre', __('Nombre'));
        echo $this->Form->input('Programa.nombre', array('div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-2">
        <?php
        $opciones = array ('NO' => 'No', 'SI' => 'Sí');
        echo $this->Form->label('Programa.altadef', __('Alta Definicion'));
        echo $this->Form->input('Programa.altadef', array('options' => $opciones, 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-2">
        <?php
        echo $this->Form->label('Programa.codificado', __('Codificado'));
        echo $this->Form->input('Programa.codificado', array('options' => $opciones, 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-4">
        <?php
        echo $this->Form->label('Programa.logo', __('Logotipo'));
        echo $this->Form->input('Programa.logo', array('type' => 'file', 'class' => 'form-control', 'placeholder' => __('Seleccione el logo')));
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
                array('controller' => 'programas', 'action' => 'index'),
                array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
            );
            ?>
        </div>
    </div>
</fieldset>
<?php
echo $this->Form->end();
?>
