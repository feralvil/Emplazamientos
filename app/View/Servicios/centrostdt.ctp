<?php
// Dinamismo con JQuery
$next = $this->Paginator->counter('{:page}') + 1;
$prev = $this->Paginator->counter('{:page}') - 1;
$ultima = $this->Paginator->counter('{:pages}');
$this->Js->get("#anterior");
$this->Js->event('click', "$('#ServicioIrapag').val($prev);$('#ServicioCentrostdtForm').submit()");
$this->Js->get("#siguiente");
$this->Js->event('click', "$('#ServicioIrapag').val($next);$('#ServicioCentrostdtForm').submit()");
$this->Js->get("#primera");
$this->Js->event('click', "$('#ServicioIrapag').val(1);$('#ServicioCentrostdtForm').submit()");
$this->Js->get("select");
$this->Js->event('change', '$("#ServicioCentrostdtForm").submit()');
$this->Js->get("#ultima");
$this->Js->event('click', "$('#ServicioIrapag').val($ultima);$('#ServicioCentrostdtForm').submit()");
$nserv = count($servicios);
?>
<h1><?php echo __('Centros TDT de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Servicio', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
echo $this->Form->hidden('tampag', array('value' => $this->Paginator->counter('{:current}')));
echo $this->Form->hidden('irapag', array('value' => '0'));
?>
<fieldset>
    <legend>
        <?php
        echo __('Criterios de Búsqueda') . ' &mdash; ';
        echo $this->Html->Link(
            '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>',
            array('controller' => 'servicios', 'action' => 'centrostdt'),
            array('title' => __('Limpiar Criterios'), 'escape' => false)
        );
        ?>
    </legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Servicio.descripcion', __('Centro'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Servicio.emplazamiento', array('options' => $emplazamientos, 'empty' => __('Seleccionar'), 'div' => 'col-sm-3', 'class' => 'form-control'));
        echo $this->Form->label('Servicio.servtipo', __('Tipo'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Servicio.servtipo', array('options' => $tiposerv, 'empty' => __('Seleccionar'), 'div' => 'col-sm-3', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend>
        <?php
        echo __('Resultados de Búsqueda');
        if ($nserv > 0){
            echo ' &mdash; ' . __($this->Paginator->counter("Servicios <b>{:start}</b> a <b>{:end}</b> de <b>{:count}</b>"));
        }
        ?>
    </legend>
    <div class="form-group">
        <?php
        $opciones = array(30 => 30, 50 => 50, 100 => 100, $this->Paginator->counter('{:count}') => 'Todos');
        echo $this->Form->label('Servicio.regPag', __('Servicios por página'), array('class' => 'col-md-2 control-label'));
        echo $this->Form->input('Servicio.regPag', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-md-2', 'class' => 'form-control'));
        ?>
        <div class="btn-group col-md-4" role="group" aria-label="...">
            <?php
            $clase = 'btn btn-default';
            if ($this->Paginator->counter('{:page}') == 1) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>', '#',
                    array('title' => __('Primera Página'), 'class' => $clase, 'id' => 'primera', 'alt' => __('Primera Página'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            if (!$this->Paginator->hasPrev()) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-backward" aria-hidden="true"></span>', '#',
                    array('title' => __('Página Anterior'), 'class' => $clase, 'id' => 'anterior', 'alt' => __('Página Anterior'), 'escape' => false)
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
                array('title' => __('Página Siguiente'), 'class' => $clase, 'id' => 'siguiente', 'alt' => __('Página Siguiente'), 'escape' => false)
            );
            $clase = 'btn btn-default';
            if ($this->Paginator->counter('{:page}') == $this->Paginator->counter('{:pages}')) {
                    $clase .= ' disabled';
            }
            echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>', '#',
                    array('title' => __('Última Página'), 'class' => $clase, 'id' => 'ultima', 'alt' => __('Última Página'), 'escape' => false)
            );
            ?>
        </div>
        <div class="col-md-2">
            <div class="btn-group" role="group" aria-label="...">
                <?php
                if ((AuthComponent::user('role') == 'admin') || (AuthComponent::user('role') == 'colab')) {
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                        array('controller' => 'servicios', 'action' => 'agregar'),
                        array('title' => __('Agregar Servicio'), 'class' => 'btn btn-default', 'alt' => __('Agregar Servicio'), 'escape' => false)
                    );
                }
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>',
                    array('controller' => 'servicios', 'action' => 'xlsexportar'),
                    array('title' => __('Exportar a Excel'), 'class' => 'btn btn-default', 'alt' => __('Exportar a Excel'), 'target' => '_blank', 'escape' => false)
                );
                ?>
            </div>
        </div>
    </div>
</fieldset>

<?php
echo $this->Form->end();
if ($nserv > 0){
?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Acciones');?></th>
            <th><?php echo __('Centro');?></th>
            <th><?php echo __('Tipo');?></th>
            <th><?php echo __('Nº Mux');?></th>
            <?php
            $arraymux = array('RGE1', 'RGE2', 'MPE1', 'MPE2', 'MPE3', 'MAUT');
            foreach ($arraymux as $muxnom) {
            ?>
                <th><?php echo $muxnom;?></th>
            <?php
            }
            ?>
            <th><?php echo __('Municipios cubiertos');?></th>
            <th><?php echo __('Habitantes cubiertos');?></th>
        </tr>
        <?php
        foreach ($servicios as $servicio) {
            $nmun = 0;
            $habCubiertos = 0;
            $tipo = 'C2';
            if (!empty($servicio['Cobertura'])){
                $nmun = count($servicio['Cobertura']);
                foreach ($servicio['Cobertura'] as $cobertura) {
                    $habCubiertos += $cobertura['habCubiertos'];
                }
            }
            if ($habCubiertos > 1000){
                $tipo = 'C1';
            }
        ?>
            <tr>
                <td class="text-center">
                    <?php
                    echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
                            array('controller' => 'servicios', 'action' => 'editar', $servicio['Servicio']['id']),
                            array('title' => __('Modificar Servicio'), 'alt' => __('Modificar Servicio'), 'escape' => false)
                    );
                    ?> &mdash;
                    <?php
                    echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
                            array('controller' => 'servicios', 'action' => 'detalle', $servicio['Servicio']['id']),
                            array('title' => __('Detalle de Servicio'), 'alt' => __('Detalle de Servicio'), 'escape' => false)
                    );
                    ?>
                </td>
                <td><?php echo substr($servicio['Servicio']['descripcion'], 20);?></td>
                <td class="text-center"><?php echo $tipo;?></td>
                <td class="text-center"><?php echo count($servicio['Emision']);?></td>
                <?php
                foreach ($arraymux as $muxnom) {
                    $muxcanal = "&mdash;";
                    if (!empty($servicio['Emision'])){
                        foreach ($servicio['Emision'] as $emision) {
                            if ($emision['nommux'] == $muxnom){
                                $muxcanal = $emision['canal'] . '-' . $emision['tipo'];
                            }
                        }
                    }
                ?>
                    <td class="text-center"><?php echo $muxcanal;?></td>
                <?php
                }
                ?>
                <td class="text-center"><?php echo $nmun;?></td>
                <td class="text-right"><?php echo $habCubiertos;?></td>
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
            <?php echo __('No se han econtrado servicios con los criterios de búsqueda seleccionados'); ?>
        </div>
    </div>
<?php
}
?>
