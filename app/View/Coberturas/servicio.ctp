<?php
$nmux = 0;
if (!empty($servicio['Cobertura'])){
    $ncob = count($servicio['Cobertura']);
}
?>
<h1><?php echo __('Cobertura del') . ' ' . $servicio['Servicio']['descripcion']; ?></h1>
<h2><?php echo $ncob . ' ' . __('Municipios cubiertos'); ?></h2>
<?php
if ($ncob > 0){
?>
    <table class="table table-condensed table-hover table-striped">
        <tr>
            <th><?php echo __('Provincia');?></th>
            <th><?php echo __('Municipio');?></th>
            <th><?php echo __('Población');?></th>
            <th><?php echo __('Hab. Cubiertos (%100)');?></th>
            <th><?php echo __('Acciones');?></th>
        </tr>
        <?php
        foreach ($servicio['Cobertura'] as $cobertura) {
        ?>
            <tr>
                <td><?php echo $cobertura['Municipio']['provincia'];?></td>
                <td><?php echo $cobertura['Municipio']['nombre'];?></td>
                <td><?php echo $cobertura['Municipio']['poblacion'];?></td>
                <td>
                    <?php echo round ($cobertura['Municipio']['poblacion'] * $cobertura['Cobertura']['porcentaje'] / 100);?> (<?php echo $cobertura['Cobertura']['porcentaje'];?> %)
                </td>
                <td class="text-center">
                    <?php
                    echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
                            array('controller' => 'coberturas', 'action' => 'editar', $cobertura['Cobertura']['id']),
                            array('title' => __('Modificar Emisión'), 'alt' => __('Modificar Emisión'), 'escape' => false)
                    );
                    ?>
                     &mdash;
                    <?php
                    echo $this->Form->postLink(
                        '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
                        array('controller' => 'coberturas', 'action' => 'borrar',  $cobertura['Cobertura']['id']),
                        array('title' => __('Borrar Emisión'), 'alt' => __('Borrar Emisión'), 'escape' => false),
                        __('¿Seguro que desea eliminar la cobertura del municipio') . ' ' . $cobertura['Municipio']['nombre'] . "\n" . 'del Servicio' . '?'
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
            <?php echo __('No se han econtrado municipios cubiertos en este servicio'); ?>
        </div>
    </div>
<?php
}
?>
<?php
echo $this->Form->create('Cobertura', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'url' => array('controller' => 'coberturas', 'action' => 'agregar'),
));
echo $this->Form->hidden('Cobertura.servicio_id', array('value' => $servicio['Servicio']['id']));
?>
<fieldset>
    <legend><?php echo __('Agregar Municipio a la cobertura'); ?></legend>
    <div class="form-group col-sm-8">
        <?php
        echo $this->Form->label('Cobertura.municipio_id', __('Municipio'));
        echo $this->Form->input('Cobertura.municipio_id', array('options' => $municipios, 'empty' => __('Seleccionar'), 'div' => 'has-error', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group col-sm-4">
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
        '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> &nbsp;' . __('Agregar Municipio'),
        array('type' => 'submit', 'class' => 'btn btn-default', 'title' => __('Agregar Municipio'), 'alt' => __('Agregar Municipio'), 'escape' => false)
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
