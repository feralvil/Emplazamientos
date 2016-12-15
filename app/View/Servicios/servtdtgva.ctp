<?php
// Funciones JQuery:
$functab = "$('div[class*=\"pestanya\"]').addClass('hidden');";
$functab .= "$('ul li').removeClass('active');";
$functab .= "$(this).parent().addClass('active');";
$functab .= "var divshow = $(this).attr('id');";
$functab .= "$('div#' + $(this).attr('id')).removeClass('hidden');";
$this->Js->get("div#principal ul li a");
$this->Js->event('click', $functab);
?>
<h1><?php echo __('Centro TDT') . ' ' . $servicio['Emplazamiento']['centro']; ?></h1>
<div id="principal">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="#" id="localiza">
                <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?php echo __('Emplazamiento');?>
            </a>
        </li>
        <li role="presentation">
            <a href="#" id="multiples">
                <span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span> <?php echo __('Múltiples');?>
            </a>

        </li>
        <li role="presentation">
            <a href="#" id="cobertura">
                <span class="glyphicon glyphicon-signal" aria-hidden="true"></span> <?php echo __('Cobertura');?>
            </a>

        </li>
    </ul>
    <div id="localiza" class="pestanya">
        <div class="row">
            <div class="col-md-6">
                <h2><?php echo __('Mapa');?></h2>
                <div id="map">
                </div>
            </div>
            <div class="col-md-6">
                <h2><?php echo __('Datos de Localización');?></h2>
                <table class="table table-condensed table-hover table-striped">
                    <tr>
                        <th><?php echo __('Provincia');?></th>
                        <th><?php echo __('Comarca');?></th>
                        <th><?php echo __('Municipio');?></th>
                    </tr>
                    <tr>
                        <td><?php echo $servicio['Municipio']['provincia'];?></td>
                        <td><?php echo $servicio['Municipio']['Comarca']['comarca'];?></td>
                        <td><?php echo $servicio['Municipio']['nombre'];?></td>
                    </tr>
                </table>
                <h2><?php echo __('Coordenadas');?></h2>
                <table class="table table-condensed table-hover table-striped">
                    <tr>
                        <th><?php echo __('Latitud');?></th>
                        <th><?php echo __('Longitud');?></th>
                    </tr>
                    <tr>
                        <td><?php echo $servicio['Emplazamiento']['latitud'];?></td>
                        <td><?php echo $servicio['Emplazamiento']['longitud'];?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="form-group text-center">
                <div class="btn-group" role="group" aria-label="...">
                    <?php
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>' . ' ' . __('Ir a emplazamiento'),
                        array('controller' => 'emplazamientos', 'action' => 'detalle', $servicio['Emplazamiento']['id']),
                        array('class' => 'btn btn-default', 'title' => __('Ir a emplazamiento'), 'alt' => __('Ir a emplazamiento'), 'escape' => false)
                    );
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>' . ' ' . __('Modificar emplazamiento'),
                        array('controller' => 'emplazamientos', 'action' => 'editar', $servicio['Emplazamiento']['id']),
                        array('class' => 'btn btn-default', 'title' => __('Modificar emplazamiento'), 'alt' => __('Modificar emplazamiento'), 'escape' => false)
                    );
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
                        array('controller' => 'servicios', 'action' => 'centrostdt'),
                        array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div id="multiples" class="pestanya hidden">
        <h2><?php echo __('Múltiples emitidos');?> &mdash; <?php echo count($servicio['Emision']) . ' ' . __('Múltiples');?></h2>
        <?php
        if (count($servicio['Cobertura']) > 0){
        ?>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('Múltiple');?></th>
                    <th><?php echo __('Canal');?>  &mdash; <?php echo __('Frecuencia');?></th>
                    <th><?php echo __('Tipo');?></th>
                    <th><?php echo __('Retardo');?></th>
                    <th><?php echo __('Programas');?> &mdash; <span class="badge">nº</span></th>
                </tr>
                <?php
                foreach ($servicio['Emision'] as $emision) {
                ?>
                    <tr>
                        <td><?php echo $emision['nommux'];?></td>
                        <td>
                            <?php echo $emision['canal'];?> &mdash;
                            <?php
                            $canal = $emision['canal'];
                            $frecuencia = ($canal - 21) * 8 + 474;
                            echo '[' . ($frecuencia - 4) . '-'  . ($frecuencia + 4) . ']' . ' MHz';
                            ?>

                        </td>
                        <td>
                            <?php
                            $tipos = array('E' => 'Emisor', 'GF' => 'Gap-Filler');
                            echo $tipos[$emision['tipo']];
                            ?>
                        </td>
                        <td><?php echo $emision['retardo'];?></td>
                        <td>
                            <div class="row-fluid">
                                <div class="col-md-1 text-center">
                                    <span class="badge"><?php echo count($emision['programas']);?></span>
                                </div>
                                <div class="col-md-11">
                                    <div class="row-fluid">
                                        <?php
                                        foreach ($emision['programas'] as $programa) {
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
                    <?php echo __('No se han econtrado múltiples emitidos por este centro'); ?>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="form-group text-center">
            <div class="btn-group" role="group" aria-label="...">
                <?php
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>' . ' ' . __('Modificar emisiones'),
                    array('controller' => 'emisions', 'action' => 'servicio', $servicio['Servicio']['id']),
                    array('class' => 'btn btn-default', 'title' => __('Modificar emisiones'), 'alt' => __('Modificar emisiones'), 'escape' => false)
                );
                echo $this->Form->postLink(
                    '<span class="glyphicon glyphicon-off" aria-hidden="true"></span>' . ' ' . __('Apagar Emisiones'),
                    array('controller' => 'emisions', 'action' => 'apagar', $servicio['Servicio']['id']),
                    array('class' => 'btn btn-default', 'title' => __('Apagar Emisiones'), 'escape' => false),
                    __('¿Seguro que desea apagar las emisiones del') . ' ' .$servicio['Servicio']['descripcion'] . "?\n"
                );
                echo $this->Html->Link(
                    '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
                    array('controller' => 'servicios', 'action' => 'centrostdt'),
                    array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
                );
                ?>
            </div>
        </div>
    </div>
    <div id="cobertura" class="pestanya hidden">
        <h2><?php echo __('Cobertura del Centro TDT');?> </h2>
        <?php
        if (count($servicio['Cobertura']) > 0){
            $totHabitantes = 0;
            $totCubiertos = 0;
        ?>
            <h3><?php echo __('Municipios Cubiertos');?> &mdash; <?php echo count($servicio['Cobertura']);?></h3>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('Provincia');?></th>
                    <th><?php echo __('Municipio');?></th>
                    <th><?php echo __('Población');?></th>
                    <th><?php echo __('Hab. Cubiertos (%)');?></th>
                </tr>
                <?php
                foreach ($servicio['Cobertura'] as $cobertura) {
                    $totHabitantes += $cobertura['poblacion'];
                    $totCubiertos += $cobertura['habCubiertos'];
                ?>
                    <tr>
                        <td><?php echo $cobertura['provincia'];?></td>
                        <td><?php echo $cobertura['municipio'];?></td>
                        <td><?php echo $cobertura['poblacion'];?></td>
                        <td>
                            <?php
                            echo $cobertura['habCubiertos'] . ' (' . $cobertura['porcentaje'] . ' %)';
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <th colspan="2"><?php echo __('Totales');?></th>
                    <th><?php echo $totHabitantes;?></th>
                    <th>
                        <?php
                        $porcentaje = round(100 * $totCubiertos / $totHabitantes);
                        echo $totCubiertos . ' (' . $porcentaje . ' %)';
                        ?>
                    </th>
                </tr>
            </table>
            <h3><?php echo __('Tipología de incidencias del centro');?></h3>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('Tipología del Centro');?></th>
                    <th><?php echo __('Tiempo de respuesta A1');?></th>
                    <th><?php echo __('Tiempo de respuesta A2');?></th>
                </tr>
                <tr>
                    <?php
                    $tipo = 'C1';
                    $ta1 = '6 h.';
                    $ta2 = '12 h.';
                    if ($totCubiertos < 1000){
                        $tipo = 'C2';
                        $ta1 = '12 h.';
                        $ta2 = '24 h.';
                    }
                    ?>
                    <td><?php echo $tipo;?></td>
                    <td><?php echo $ta1;?></td>
                    <td><?php echo $ta2;?></td>
                </tr>
            </table>
            <div class="form-group text-center">
                <div class="btn-group" role="group" aria-label="...">
                    <?php
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>' . ' ' . __('Modificar cobertura'),
                        array('controller' => 'coberturas', 'action' => 'servicio', $servicio['Servicio']['id']),
                        array('class' => 'btn btn-default', 'title' => __('Modificar cobertura'), 'alt' => __('Modificar cobertura'), 'escape' => false)
                    );
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
                        array('controller' => 'servicios', 'action' => 'centrostdt'),
                        array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
                    );
                    ?>
                </div>
            </div>
        <?php
        }
        else{
        ?>
            <div class='panel panel-warning'>
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo  __('No hay resultados'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo __('No se han econtrado municipios cubiertos por este centro'); ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    // Tipo de marcadores
    var Iconos = L.Icon.extend({
        options: {
            shadowUrl: '../../img/marker-shadow.png',
            iconSize:     [25, 40], // Tamaño del Icono
            iconAnchor:   [12, 40], // Punto de anclaje del icono
            tooltipAnchor:  [5, -10],
            popupAnchor:  [5, -10]
        }
    });

    var mapa = L.map('map').setView(
        [<?php echo $servicio['Emplazamiento']['latitud']; ?>,
        <?php echo $servicio['Emplazamiento']['longitud']; ?>],
        10
    );
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
        maxZoom: 18
    }).addTo(mapa);
    L.control.scale().addTo(mapa)
    var iconoAzul = new Iconos({iconUrl: '../../img/marca-azul.png'});
    var iconoVerde = new Iconos({iconUrl: '../../img/marca-verde.png'});
    var marcador = L.marker(
        [<?php echo $servicio['Emplazamiento']['latitud']; ?>,
        <?php echo $servicio['Emplazamiento']['longitud']; ?>],
        {icon: iconoAzul}
    ).addTo(mapa);
    marcador.bindTooltip("<b><?php echo $servicio['Emplazamiento']['centro']; ?></b>");
</script>
