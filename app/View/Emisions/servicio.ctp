<?php
$nmux = 0;
$tipos = array('E' => 'Emisor', 'GF' => 'Gap-Filler');
if (!empty($servicio['Emision'])){
    $nmux = count($servicio['Emision']);
}
?>
<h1><?php echo __('Emisiones del') . ' ' . $servicio['Servicio']['descripcion']; ?></h1>
<h2><?php echo $nmux . ' ' . __('Multiples emitidos'); ?></h2>
<?php
if ($nmux > 0){
?>
    <table class="table table-condensed table-hover table-striped">
        <tr>
            <th><?php echo __('Múltiple');?></th>
            <th><?php echo __('Canal');?></th>
            <th><?php echo __('Tipo');?></th>
            <th><?php echo __('Retardo (x100 ns)');?></th>
            <th><?php echo __('Acciones');?></th>
        </tr>
        <?php
        foreach ($servicio['Emision'] as $emision) {
        ?>
            <tr>
                <td><?php echo $emision['Multiple']['nombre'];?></td>
                <td><?php echo $emision['Emision']['canal'];?></td>
                <td><?php echo $tipos[$emision['Emision']['tipo']];?></td>
                <td><?php echo $emision['Emision']['retardo'];?></td>
                <td class="text-center">
                    <?php
                    echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
                            array('controller' => 'emisions', 'action' => 'editar', $emision['Emision']['id']),
                            array('title' => __('Modificar Emisión'), 'alt' => __('Modificar Emisión'), 'escape' => false)
                    );
                    ?>
                     &mdash;
                    <?php
                    echo $this->Form->postLink(
                        '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
                        array('controller' => 'emisions', 'action' => 'borrar', $emision['Emision']['id']),
                        array('title' => __('Borrar Emisión'), 'alt' => __('Borrar Emisión'), 'escape' => false),
                        __('¿Seguro que desea eliminar la emisión del múltiple') . ' ' . $emision['Multiple']['nombre'] . "\n" . 'del Servicio' . '?'
                    );
                    ?>
                </td>
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
            <h3 class="panel-title"><?php echo  __('No hay múltiples'); ?></h3>
        </div>
        <div class="panel-body">
            <?php echo __('No se han econtrado múltiples emitidos en este servicio'); ?>
        </div>
    </div>
<?php
}
?>
<?php
echo $this->Form->create('Emision', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'url' => array('controller' => 'emisions', 'action' => 'agregar'),
));
echo $this->Form->hidden('Emision.servicio_id', array('value' => $servicio['Servicio']['id']));
?>
<fieldset>
    <legend><?php echo __('Agregar Multiple a las emisiones'); ?></legend>
    <div class="form-group col-sm-3">
        <?php
        echo $this->Form->label('Emision.multiple_id', __('Múltiple'));
        echo $this->Form->input('Emision.multiple_id', array('options' => $multiples, 'empty' => __('Seleccionar'), 'div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo $this->Form->label('Emision.canal', __('Canal'));
        echo $this->Form->input('Emision.canal', array('class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-3">
        <?php
        echo $this->Form->label('Emision.tipo', __('Tipo'));
        echo $this->Form->input('Emision.tipo', array('options' => $tipos, 'empty' => __('Seleccionar'), 'div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-3">
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
        '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> &nbsp;' . __('Agregar Emisión'),
        array('type' => 'submit', 'class' => 'btn btn-default', 'title' => __('Agregar Emisión'), 'alt' => __('Agregar Emisión'), 'escape' => false)
        );
        echo $this->Form->button(
        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>  &nbsp;'.__('Cancelar Cambios'),
        array('type' => 'reset', 'class' => 'btn btn-default', 'title' => __('Cancelar Cambios'), 'alt' => __('Cancelar Cambios'), 'escape' => false)
        );
        echo $this->Html->Link(
            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
            array('controller' => 'servicios', 'action' => 'detalle', $servicio['Servicio']['id']),
            array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
        );
        ?>
    </div>
</div>
<?php
echo $this->Form->end();
?>
