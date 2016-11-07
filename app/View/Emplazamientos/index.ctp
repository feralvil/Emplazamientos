<?php
// Dinamismo con JQuery
$next = $this->Paginator->counter('{:page}') + 1;
$prev = $this->Paginator->counter('{:page}') - 1;
$ultima = $this->Paginator->counter('{:pages}');
$this->Js->get("#anterior");
$this->Js->event('click', "$('#EmplazamientoIrapag').val($prev);$('#EmplazamientoIndexForm').submit()");
$this->Js->get("#siguiente");
$this->Js->event('click', "$('#EmplazamientoIrapag').val($next);$('#EmplazamientoIndexForm').submit()");
$this->Js->get("#primera");
$this->Js->event('click', "$('#EmplazamientoIrapag').val(1);$('#EmplazamientoIndexForm').submit()");
$this->Js->get("select");
$this->Js->event('change', '$("#EmplazamientoIndexForm").submit()');
$this->Js->get("#ultima");
$this->Js->event('click', "$('#EmplazamientoIrapag').val($ultima);$('#EmplazamientoIndexForm').submit()");
$nemp = count($emplazamientos);
?>
<h1><?php echo __('Emplazamientos de Telecomunicaciones de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Emplazamiento', array(
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
            array('controller' => 'emplazamientos', 'action' => 'index'),
            array('title' => __('Limpiar Criterios'), 'escape' => false)
        );
        ?>
    </legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Emplazamiento.provincia', __('Provincia'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.provincia', array('options' => $provincias, 'empty' => __('Seleccionar'), 'div' => 'col-sm-3', 'class' => 'form-control'));
        echo $this->Form->label('Emplazamiento.comarca', __('Comarca'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.comarca', array('options' => $comarcas, 'empty' => __('Seleccionar'), 'div' => 'col-sm-3', 'class' => 'form-control'));
        echo $this->Form->label('Emplazamiento.centro', __('Centro'), array('class' => 'col-sm-1 control-label'));
        ?>
        <div class="input-group col-sm-2">
            <?php
            echo $this->Form->input('Emplazamiento.centro', array('class' => 'form-control'));
            ?>
            <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?php
        $opciones = array ('SI' => 'Sí', 'NO' => 'No');
        echo $this->Form->label('Emplazamiento.comdes', __('COMDES'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.comdes', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Emplazamiento.tdt-gva', __('TDT GVA'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.tdt-gva', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Emplazamiento.rtvv', __('TDT RTVV'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.rtvv', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Emplazamiento.titular', __('Titular'), array('class' => 'col-sm-1 control-label'));
        echo $this->Form->input('Emplazamiento.titular', array('options' => $titulares, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend>
        <?php
        echo __('Resultados de Búsqueda');
        if ($nemp > 0){
            echo ' &mdash; ' . __($this->Paginator->counter("Emplazamientos <b>{:start}</b> a <b>{:end}</b> de <b>{:count}</b>"));
        }
        ?>
    </legend>
    <div class="form-group">
        <?php
        $opciones = array(30 => 30, 50 => 50, 100 => 100, $this->Paginator->counter('{:count}') => 'Todos');
        echo $this->Form->label('Emplazamiento.regPag', __('Emplazamientos por página'), array('class' => 'col-md-2 control-label'));
        echo $this->Form->input('Emplazamiento.regPag', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-md-2', 'class' => 'form-control'));
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
                        array('controller' => 'emplazamientos', 'action' => 'agregar'),
                        array('title' => __('Agregar Emplazamiento'), 'class' => 'btn btn-default', 'alt' => __('Agregar Emplazamiento'), 'escape' => false)
                    );
                }
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>',
                    array('controller' => 'emplazamientos', 'action' => 'xlsexportar'),
                    array('title' => __('Exportar a Excel'), 'class' => 'btn btn-default', 'alt' => __('Exportar a Excel'), 'target' => '_blank', 'escape' => false)
                );
                ?>
            </div>
        </div>
    </div>
</fieldset>
<?php
echo $this->Form->end();
if ($nemp > 0){
?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Acciones');?></th>
            <th><?php echo __('Emplazamiento');?></th>
            <th><?php echo __('Provincia');?></th>
            <th><?php echo __('Titular');?></th>
            <th><?php echo __('Latitud');?></th>
            <th><?php echo __('Longitud');?></th>
            <th><?php echo __('COMDES');?></th>
            <th><?php echo __('TDT-GVA');?></th>
            <th><?php echo __('RTVV');?></th>
        </tr>
        <?php
        foreach ($emplazamientos as $emplazamiento) {
        ?>
            <tr>
                <td class="text-center">
                    <?php
                    echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
                            array('controller' => 'emplazamientos', 'action' => 'editar', $emplazamiento['Emplazamiento']['id']),
                            array('title' => __('Modificar Emplazamiento'), 'alt' => __('Modificar Emplazamiento'), 'escape' => false)
                    );
                    ?> &mdash;
                    <?php
                    echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>',
                            array('controller' => 'emplazamientos', 'action' => 'detalle', $emplazamiento['Emplazamiento']['id']),
                            array('title' => __('Detalle de Emplazamiento'), 'alt' => __('Detalle de Emplazamiento'), 'escape' => false)
                    );
                    ?>
                </td>
                <td><?php echo $emplazamiento['Emplazamiento']['centro'];?></td>
                <td><?php echo $emplazamiento['Municipio']['provincia'];?></td>
                <td>
                    <?php
                    $entidad = $emplazamiento['Entidad']['nombre'];
                    $vectent = explode(' ', $entidad);
                    $entidad = $vectent[0];
                    switch ($entidad) {
                        case 'Generalitat':
                            $entidad = 'GVA';
                            break;

                        case 'Ayuntamiento':
                            $entidad = 'GVA-AYTO';
                            break;

                        case 'Ferrocarrils':
                            $entidad = 'FGV';
                            break;

                        case 'RadioTelevisió':
                            $entidad = 'RTVV';
                            break;

                        case 'Diputación':
                            $entidad = 'DIP. ' . mb_strtoupper($vectent[2]);
                            break;

                        default:
                            $entidad = mb_strtoupper($entidad);
                            break;
                    }
                    echo $entidad;
                    ?>
                </td>
                <td><?php echo $emplazamiento['Emplazamiento']['latitud'];?></td>
                <td><?php echo $emplazamiento['Emplazamiento']['longitud'];?></td>
                <?php
                // Buscamos los servicios
                $servtipos = array();
                foreach ($emplazamiento['Servicio'] as $servemp) {
                    $servtipos[] = $servemp['servtipo_id'];
                }
                $servicios = array(1 => 'comdes', 2 => 'tdt-gva', 4 => 'rtvv');
                foreach ($servicios as $indserv => $nomserv) {
                ?>
                    <td class="text-center">
                        <?php
                        $servicio = 'glyphicon glyphicon-remove';
                        if (in_array($indserv, $servtipos)){
                            $servicio = 'glyphicon glyphicon-ok';
                        }
                        ?>
                        <span class="'. <?php echo $servicio;?> . '" aria-hidden="true"></span>
                    </td>
                <?php
                }
                ?>
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
            <?php echo __('No se han econtrado emplazamientos con los criterios de búsqueda seleccionados'); ?>
        </div>
    </div>
<?php
}
?>
