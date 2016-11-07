<h1><?php echo __('Importar Entidades de Emplazamientos de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Emplazamiento', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
?>
<fieldset>
    <legend>
        <?php echo __('Encontrados') . ' ' . count($emplazamientos) . ' ' . __('Emplazamientos'); ?>
    </legend>
    <div class="form-group">
        <div class="col-md-12 text-center">
            <div class="btn-group" role="group" aria-label="...">
                <?php
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver a Emplazamientos'),
                    array('controller' => 'emplazamientos', 'action' => 'index'),
                    array('title' => __('Volver a Emplazamientos'), 'class' => 'btn btn-default', 'alt' => __('Volver a Emplazamientos'), 'escape' => false)
                );
                if ((AuthComponent::user('role') == 'admin') || (AuthComponent::user('role') == 'colab') && (count($emplazamientos) > 0)) {
                    echo $this->Form->button(
                        '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>' . ' ' . __('Guardar Emplazamientos'),
                        array('type' => 'submit', 'title' => __('Guardar Emplazamientos'), 'class' => 'btn btn-default', 'alt' => __('Guardar Emplazamientos'), 'escape' => false)
                    );
                }
                ?>
            </div>
        </div>
    </div>
</fieldset>
<?php
if (count($emplazamientos) > 0){
?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Id');?></th>
            <th><?php echo __('Emplazamiento');?></th>
            <th><?php echo __('Titular');?></th>
            <th><?php echo __('Entidad');?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($emplazamientos as $emplazamiento) {
            $i++;
        ?>
            <tr>
                <td><?php echo $emplazamiento['Emplazamiento']['id'];?></td>
                <td><?php echo $emplazamiento['Emplazamiento']['centro'];?></td>
                <td><?php echo $emplazamiento['Emplazamiento']['titular'];?></td>
                <td><?php echo $emplazamiento['Emplazamiento']['entidad_id'];?></td>
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
