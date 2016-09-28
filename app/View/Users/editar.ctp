<h1><?php echo __('Modificar el usuario') . ' ' . $this->request->data['User']['nombre'] . ' ' . $this->request->data['User']['apellido1']; ?></h1>
<?php
echo $this->Form->create('User', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
?>
<fieldset>
    <legend><?php echo  __('Datos del usuario'); ?></legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('User.username', __('Usuario'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('User.username', array('div' => 'col-sm-4 has-error', 'class' => 'form-control'));
        $opciones = array('admin' => __('Administrador'), 'colab' => __('Colaborador'), 'consum' => 'Consumidor');
        echo $this->Form->label('User.role', __('Tipo de Usuario'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('User.role', array('options' => $opciones, 'empty' => __('Seleccionar Tipo'), 'div' => 'col-sm-4 has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $this->Form->label('User.nombre', __('Nombre'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('User.nombre', array('div' => 'col-sm-2 has-error', 'class' => 'form-control'));
        echo $this->Form->label('User.apellido1', __('Primer Apellido'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('User.apellido1', array('div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('User.apellido2', __('Segundo Apellido'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('User.apellido2', array('div' => 'col-sm-2', 'class' => 'form-control'));
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
                array('controller' => 'users', 'action' => 'index'),
                array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
            );
            ?>
        </div>
    </div>
</fieldset>
<?php
echo $this->Form->end();
?>
