<?php
// Dinamismo con JQuery
$next = $this->Paginator->counter('{:page}') + 1;
$prev = $this->Paginator->counter('{:page}') - 1;
$ultima = $this->Paginator->counter('{:pages}');
$this->Js->get("#anterior");
$this->Js->event('click', "$('#ProgramaIrapag').val($prev);$('#ProgramaIndexForm').submit()");
$this->Js->get("#siguiente");
$this->Js->event('click', "$('#ProgramaIrapag').val($next);$('#ProgramaIndexForm').submit()");
$this->Js->get("#primera");
$this->Js->event('click', "$('#ProgramaIrapag').val(1);$('#ProgramaIndexForm').submit()");
$this->Js->get("select");
$this->Js->event('change', '$("#ProgramaIndexForm").submit()');
$this->Js->get("#ultima");
$this->Js->event('click', "$('#ProgramaIrapag').val($ultima);$('#ProgramaIndexForm').submit()");
$nprog = count($programas);
?>
<h1><?php echo __('Programas TDT de la Comunitat'); ?></h1>
<?php
echo $this->Form->create('Programa', array(
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
            array('controller' => 'programas', 'action' => 'index'),
            array('title' => __('Limpiar Criterios'), 'escape' => false)
        );
        ?>
    </legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Programa.multiple', __('Múltiple'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Programa.multiple', array('options' => $multiples, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        $opciones = array ('SI' => 'Sí', 'NO' => 'No');
        echo $this->Form->label('Programa.altadef', __('Alta Definición'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Programa.altadef', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Programa.codificado', __('Codificado'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Programa.codificado', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-sm-2', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend>
        <?php
        echo __('Resultados de la Búsqueda');
        if ($nprog > 0){
            echo ' &mdash; ' . __($this->Paginator->counter("Programas <b>{:start}</b> a <b>{:end}</b> de <b>{:count}</b>"));
        }
        ?>
    </legend>
    <div class="form-group">
        <?php
        $opciones = array(20 => 20, 50 => 50, 100 => 100, $this->Paginator->counter('{:count}') => 'Todos');
        echo $this->Form->label('Programa.regPag', __('Programas por página'), array('class' => 'col-md-2 control-label'));
        echo $this->Form->input('Programa.regPag', array('options' => $opciones, 'empty' => __('Seleccionar'), 'div' => 'col-md-2', 'class' => 'form-control'));
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
                        '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &mdash; ' . __('Agregar Programa'),
                        array('controller' => 'programas', 'action' => 'agregar'),
                        array('title' => __('Agregar Programa'), 'class' => 'btn btn-default', 'alt' => __('Agregar Programa'), 'escape' => false)
                    );
                }
                ?>
            </div>
        </div>
    </div>
</fieldset>
<?php
echo $this->Form->end();
if ($nprog > 0){
?>
    <table class="table table-condensed table-hover table-striped table-bordered">
        <tr>
            <th><?php echo __('Acciones');?></th>
            <th><?php echo __('Programa');?></th>
            <th><?php echo __('HD');?></th>
            <th><?php echo __('Codificado');?></th>
            <th><?php echo __('Logo');?></th>
            <th><?php echo __('Múltiple(s)');?></th>
        </tr>
        <?php
        foreach ($programas as $programa) {
        ?>
            <tr>
                <td class="text-center">
                    <?php
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
                        array('controller' => 'programas', 'action' => 'editar', $programa['Programa']['id']),
                        array('title' => __('Modificar Programa'), 'alt' => __('Modificar Programa'), 'escape' => false)
                    );
                    ?>
                    &mdash;
                    <?php
                    echo $this->Form->postLink(
                        '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
                        array('controller' => 'programas', 'action' => 'borrar', $programa['Programa']['id']),
                        array('title' => __('Borrar Programa'), 'escape' => false),
                        __('¿Seguro que desea eliminar el programa') . ' ' . $programa['Programa']['nombre'] . "?\n" . 'NOTA: ' . __('Se borrará la asociación con los múltiples')
                    );
                    ?>
                </td>
                <td><?php echo $programa['Programa']['nombre'];?></td>
                <td><?php echo $programa['Programa']['altadef'];?></td>
                <td><?php echo $programa['Programa']['codificado'];?></td>
                <td class="text-center">
                    <?php
                    $alt = $programa['Programa']['nombre'];
                    if ($programa['Programa']['logo'] == 'logos/nologo.png'){
                        $alt = __('Sin logo');
                    }
                    echo $this->Html->image(
                        $programa['Programa']['logo'],
                        array('alt' => $alt, 'title' => $alt)
                    );
                    ?>
                </td>
                <td class="text-center">
                    <span class="badge"><?php echo count($programa['Multiple']);?></span>  &mdash;
                    <?php
                    foreach ($programa['Multiple'] as $multiple) {
                    ?>
                        <span class="label label-default"><?php echo $multiple['nombre'];?></span>
                    <?php
                    }
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
            <h3 class="panel-title"><?php echo  __('No hay resultados'); ?></h3>
        </div>
        <div class="panel-body">
            <?php echo __('No se han econtrado programas con los criterios de búsqueda seleccionados'); ?>
        </div>
    </div>
<?php
}
?>
