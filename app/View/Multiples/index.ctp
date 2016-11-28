<?php
// Dinamismo con JQuery
$next = $this->Paginator->counter('{:page}') + 1;
$prev = $this->Paginator->counter('{:page}') - 1;
$ultima = $this->Paginator->counter('{:pages}');
$this->Js->get("#anterior");
$this->Js->event('click', "$('#MultipleIrapag').val($prev);$('#MultipleIndexForm').submit()");
$this->Js->get("#siguiente");
$this->Js->event('click', "$('#MultipleIrapag').val($next);$('#MultipleIndexForm').submit()");
$this->Js->get("#primera");
$this->Js->event('click', "$('#MultipleIrapag').val(1);$('#MultipleIndexForm').submit()");
$this->Js->get("select");
$this->Js->event('change', '$("#MultipleIndexForm").submit()');
$this->Js->get("#ultima");
$this->Js->event('click', "$('#MultipleIrapag').val($ultima);$('#MultipleIndexForm').submit()");
$nmux = count($multiples);
?>
<h1><?php echo __('Múltiples TDT de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Multiple', array(
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
            array('controller' => 'multiples', 'action' => 'index'),
            array('title' => __('Limpiar Criterios'), 'escape' => false)
        );
        ?>
    </legend>
    <div class="form-group">
        <?php
        $ambitos = array ('NAC' => __('Nacional'), 'AUT' => __('Autonómico'), 'LOC' => __('Local'));
        echo $this->Form->label('Multiple.ambito', __('Ámbito'), array('class' => 'col-sm-3 control-label'));
        echo $this->Form->input('Multiple.ambito', array('options' => $ambitos, 'empty' => __('Seleccionar'), 'div' => 'col-sm-3', 'class' => 'form-control'));
        $opciones = array ('SI' => 'Sí', 'NO' => 'No');
        echo $this->Form->label('Multiple.soportado', __('Soportado'), array('class' => 'col-sm-3 control-label'));
        echo $this->Form->input('Multiple.soportado', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-sm-3', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend>
        <?php
        echo __('Resultados de la Búsqueda');
        if ($nmux > 0){
            echo ' &mdash; ' . __($this->Paginator->counter("Múltiples <b>{:start}</b> a <b>{:end}</b> de <b>{:count}</b>"));
        }
        ?>
    </legend>
    <div class="form-group">
        <?php
        $opciones = array(20 => 20, 50 => 50, 100 => 100, $this->Paginator->counter('{:count}') => 'Todos');
        echo $this->Form->label('Emplazamiento.regPag', __('Múltiples por página'), array('class' => 'col-md-2 control-label'));
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
                        '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &mdash; ' . __('Agregar Múltiple'),
                        array('controller' => 'multiples', 'action' => 'agregar'),
                        array('title' => __('Agregar Múltiple'), 'class' => 'btn btn-default', 'alt' => __('Agregar Múltiple'), 'escape' => false)
                    );
                }
                ?>
            </div>
        </div>
    </div>
</fieldset>
<?php
echo $this->Form->end();
if ($nmux > 0){
?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Acciones');?></th>
            <th><?php echo __('Múltiple');?></th>
            <th><?php echo __('Ámbito');?></th>
            <th><?php echo __('Soportado');?></th>
            <th><?php echo __('Programas');?></th>
        </tr>
        <?php
        foreach ($multiples as $multiple) {
        ?>
            <tr>
                <td class="text-center">
                    <?php
                    echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
                            array('controller' => 'multiples', 'action' => 'editar', $multiple['Multiple']['id']),
                            array('title' => __('Modificar Múltiple'), 'alt' => __('Modificar Múltiple'), 'escape' => false)
                    );
                    ?>
                     &mdash;
                    <?php
                    echo $this->Form->postLink(
                        '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
                        array('controller' => 'multiples', 'action' => 'borrar', $multiple['Multiple']['id']),
                        array('title' => __('Borrar Programa'), 'escape' => false),
                        __('¿Seguro que desea eliminar el múltiple') . ' ' . $multiple['Multiple']['nombre'] . "?\n" . 'NOTA: ' . __('Se borrará la asociación con los programas')
                    );
                    ?>
                </td>
                <td><?php echo $multiple['Multiple']['nombre'];?></td>
                <td>
                    <?php
                    echo $ambitos[$multiple['Multiple']['ambito']];
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    $ambito = 'glyphicon glyphicon-ok';
                    if ($multiple['Multiple']['soportado'] == 'NO'){
                        $ambito = 'glyphicon glyphicon-remove';
                    }
                    ?>
                    <span class="'. <?php echo $ambito;?> . '" aria-hidden="true"></span>
                </td>
                <td>
                    <div class="row-fluid">
                        <div class="col-md-1 text-center">
                            <span class="badge"><?php echo count($multiple['Programa']);?></span>
                        </div>
                        <div class="col-md-11">
                            <div class="row-fluid">
                                <?php
                                foreach ($multiple['Programa'] as $programa) {
                                ?>
                                    <div class="col-md-2 text-center">
                                        <?php
                                        echo $this->Html->image(
                                            $programa['logo'],
                                            array('alt' => $programa['nombre'], 'title' => $programa['nombre'])
                                        );
                                        ?>
                                        <br />
                                        <small><?php echo $programa['nombre'];?></small>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
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
            <h3 class="panel-title"><?php echo  __('No hay resultados'); ?></h3>
        </div>
        <div class="panel-body">
            <?php echo __('No se han econtrado múltiples con los criterios de búsqueda seleccionados'); ?>
        </div>
    </div>
<?php
}
?>
