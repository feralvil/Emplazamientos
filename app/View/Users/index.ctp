<?php
// Dinamismo con JQuery
$next = $this->Paginator->counter('{:page}') + 1;
$prev = $this->Paginator->counter('{:page}') - 1;
$ultima = $this->Paginator->counter('{:pages}');
$this->Js->get("#anterior");
$this->Js->event('click', "$('#UserIrapag').val($prev);$('#UserIndexForm').submit()");
$this->Js->get("#siguiente");
$this->Js->event('click', "$('#UserIrapag').val($next);$('#UserIndexForm').submit()");
$this->Js->get("#primera");
$this->Js->event('click', "$('#UserIrapag').val(1);$('#UserIndexForm').submit()");
$this->Js->get("select");
$this->Js->event('change', '$("#UserIndexForm").submit()');
$this->Js->get("#ultima");
$this->Js->event('click', "$('#UserIrapag').val($ultima);$('#UserIndexForm').submit()");
$nusers = count($users);
?>
<h1><?php echo __('Usuarios de la aplicación'); ?></h1>
<?php
echo $this->Form->create('User', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
?>
<fieldset>
    <legend>
        <?php
        echo __('Criterios de Búsqueda') . ' &mdash; ';
        echo $this->Html->Link(
            '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>',
            array('controller' => 'users', 'action' => 'index'),
            array('title' => __('Limpiar Criterios'), 'escape' => false)
        );
        ?>
    </legend>
        <div class="form-group">
            <?php
            $usersel = array();
            foreach ($users as $usuario) {
                $usersel[$usuario['User']['id']] = $usuario['User']['nombre'] . ' ' . $usuario['User']['apellido1'];
            }
            echo $this->Form->label('User.usersel', __('Usuario'), array('class' => 'col-sm-2 control-label'));
            echo $this->Form->input('User.usersel', array('options' => $usersel, 'empty' => __('Seleccionar Usuario'), 'div' => 'col-sm-4', 'class' => 'form-control'));
            ?>
            <?php
            $opciones = array('admin' => __('Administrador'), 'colab' => __('Colaborador'), 'consum' => 'Consumidor');
            echo $this->Form->label('User.role', __('Tipo de Usuario'), array('class' => 'col-smd control-label'));
            echo $this->Form->input('User.role', array('options' => $opciones, 'empty' => __('Seleccionar Tipo'), 'div' => 'col-sm-4', 'class' => 'form-control'));
            ?>
        </div>
</fieldset>
<fieldset>
    <legend>
        <?php
        echo __('Resultados de Búsqueda');
        if ($nusers > 0){
            echo ' &mdash; ' . __($this->Paginator->counter("Usuarios <b>{:start}</b> a <b>{:end}</b> de <b>{:count}</b>"));
        }
        ?>
    </legend>
        <div class="form-group">
            <?php
            $opciones = array(20 => 20, 30 => 30, 50 => 50, $this->Paginator->counter('{:count}') => 'Todos');
            echo $this->Form->label('User.regPag', __('Usuarios por página'), array('class' => 'col-md-2 control-label'));
            echo $this->Form->input('User.regPag', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-md-3', 'class' => 'form-control'));
            ?>
            <div class="btn-group col-md-4" role="group" aria-label="...">
                <?php
                $clase = 'btn btn-default';
                if ($this->Paginator->counter('{:page}') == 1) {
                        $clase .= ' disabled';
                }
                echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>', '#',
                        array('title' => __('Primera Página'), 'class' => $clase, 'alt' => __('Primera Página'), 'escape' => false)
                );
                $clase = 'btn btn-default';
                if (!$this->Paginator->hasPrev()) {
                        $clase .= ' disabled';
                }
                echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-backward" aria-hidden="true"></span>', '#',
                        array('title' => __('Página Anterior'), 'class' => $clase, 'alt' => __('Página Anterior'), 'escape' => false)
                );
                $clase = 'btn btn-default';
                echo $this->Html->Link(
                        __('Página') . ' ' . $this->Paginator->counter('{:page}')  . ' / ' . $this->Paginator->counter('{:pages}'), '#',
                        array('title' => __('Página Actual'), 'class' => $clase, 'alt' => __('Página Actual'), 'escape' => false)
                );
                $clase = 'btn btn-default';
                if (!$this->Paginator->hasNext()) {
                        $clase .= ' disabled';
                }
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-forward" aria-hidden="true"></span>', '#',
                    array('title' => __('Página Siguiente'), 'class' => $clase, 'alt' => __('Página Siguiente'), 'escape' => false)
                );
                $clase = 'btn btn-default';
                if ($this->Paginator->counter('{:page}') == $this->Paginator->counter('{:pages}')) {
                        $clase .= ' disabled';
                }
                echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>', '#',
                        array('title' => __('Última Página'), 'class' => $clase, 'alt' => __('Última Página'), 'escape' => false)
                );
                ?>
            </div>
            <div class="col-md-1">
                <?php
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>' . ' ' . __('Agregar Usuario'),
                    array('controller' => 'users', 'action' => 'agregar'),
                    array('title' => __('Agregar Usuario'), 'class' => 'btn btn-default', 'alt' => __('Agregar Usuario'), 'escape' => false)
                );
                ?>
            </div>
        </div>
</fieldset>
<?php
echo $this->Form->end();
if ($nusers > 0){
?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Acciones');?></th>
            <th><?php echo __('Nombre');?></th>
            <th><?php echo __('Usuario');?></th>
            <th><?php echo __('Tipo de Usuario');?></th>
        </tr>
        <?php
        foreach ($users as $usuario) {
        ?>
            <tr>
                <td>
                    <?php
                    echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
                            array('controller' => 'users', 'action' => 'editar', $usuario['User']['id']),
                            array('title' => __('Modificar Usuario'), 'alt' => __('Modificar Usuario'), 'escape' => false)
                        );
                    ?> &mdash;
                    <?php
                    echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>',
                            array('controller' => 'users', 'action' => 'acceso', $usuario['User']['id']),
                            array('title' => __('Cambiar Contraseña'), 'alt' => __('Cambiar Contraseña'), 'escape' => false)
                        );
                    ?> &mdash;
                    <?php
                    echo $this->Form->postLink(
                            '<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>',
                            array('controller' => 'users', 'action' => 'resetear', $usuario['User']['id']),
                            array('title' => __('Resetear Contraseña'), 'alt' => __('Resetear Contraseña'), 'escape' => false),
                            __('¿Seguro que desea resetear la contraseña del Usuario')." '". $usuario['User']['username'] . "'?"
                            );
                    ?> &mdash;
                    <?php
                    echo $this->Form->postLink(
                        '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
                        array('controller' => 'users', 'action' => 'borrar', $usuario['User']['id']),
                        array('title' => __('Borrar Usuario'), 'escape' => false),
                        __('¿Seguro que desea eliminar el Usuario')." '". $usuario['User']['username'] . "'?"
                    );
                    ?>
                </td>
                <td><?php echo $usuario['User']['nombre'] . ' ' . $usuario['User']['apellido1'] . ' ' . $usuario['User']['apellido2'];?></td>
                <td><?php echo $usuario['User']['username'];?></td>
                <td><?php echo $usuario['User']['role'];?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
}
else{
?>
    <div class='panel panel-warning'>
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo  __('No hay resultados'); ?></h3>
        </div>
        <div class="panel-body">
            <?php echo __('No se han econtrado usuarios con los criterios de búsqueda seleccionados'); ?>
        </div>
    </div>
<?php
}
?>
