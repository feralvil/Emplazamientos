<h1><?php echo __('Modificar Contraseña del usuario') . ' ' . $this->request->data['User']['nombre'] . ' ' . $this->request->data['User']['apellido1']; ?></h1>
<?php
echo $this->Form->create('User', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
?>
<fieldset>
    <legend><?php echo  __('Nueva Contraseña'); ?></legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('User.password', __('Contraseña'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('User.password', array('div' => 'col-sm-2 has-error', 'class' => 'form-control'));
        echo $this->Form->label('User.passconf', __('Repetir Contraseña'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('User.passconf', array('type' => 'password', 'div' => 'col-sm-2 has-error', 'class' => 'form-control'));
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
