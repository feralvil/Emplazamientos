<h1><?php echo __('Importar Servicios de Telecomunicaciones de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Emplazamiento', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
?>
<fieldset>
    <legend>
        <?php echo __('Encontrados') . ' ' . count($servicios) . ' ' . __('Servicios'); ?>
    </legend>
    <div class="form-group">
        <div class="col-md-12 text-center">
            <div class="btn-group" role="group" aria-label="...">
                <?php
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver a Servicios'),
                    array('controller' => 'servicios', 'action' => 'index'),
                    array('title' => __('Volver a Servicios'), 'class' => 'btn btn-default', 'alt' => __('Volver a Servicios'), 'escape' => false)
                );
                if ((AuthComponent::user('role') == 'admin') || (AuthComponent::user('role') == 'colab') && (count($servicios) > 0)) {
                    echo $this->Form->button(
                        '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>' . ' ' . __('Guardar Servicios'),
                        array('type' => 'submit', 'title' => __('Guardar Servicios'), 'class' => 'btn btn-default', 'alt' => __('Guardar Servicio'), 'escape' => false)
                    );
                }
                ?>
            </div>
        </div>
    </div>
</fieldset>
<?php
if (count($servicios) > 0){
?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Id');?></th>
            <th><?php echo __('Servicio');?></th>
            <th><?php echo __('Tipo Servicio');?></th>
            <th><?php echo __('Emplazamiento');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($servicios as $servicio) {
            $i++;
        ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $servicio['descripcion'];?></td>
                <td><?php echo $servicio['servtipo_id'];?></td>
                <td><?php echo $servicio['emplazamiento_id'];?></td>
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
            <?php echo __('No se han econtrado servicios a importar'); ?>
        </div>
    </div>
<?php
}
?>
