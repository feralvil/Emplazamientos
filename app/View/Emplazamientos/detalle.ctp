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
<h1><?php echo __('Emplazamiento') . ' ' . $emplazamiento['Emplazamiento']['centro']; ?></h1>
<div id="principal">
    <ul class="nav nav-tabs">
      <li role="presentation" class="active">
          <a href="#" id="localiza">
              <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?php echo __('Localización');?>
          </a>
      </li>
      <li role="presentation">
          <a href="#" id="servicios">
              <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> <?php echo __('Servicios');?>
          </a>
      </li>
      <li role="presentation">
          <a href="#" id="titular">
              <span class="glyphicon glyphicon-record" aria-hidden="true"></span> <?php echo __('Titular');?>
          </a>
      </li>
    </ul>
    <div id="localiza" class="pestanya">
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
                        <td><?php echo $emplazamiento['Municipio']['provincia'];?></td>
                        <td><?php echo $emplazamiento['Comarca']['comarca'];?></td>
                        <td><?php echo $emplazamiento['Municipio']['nombre'];?></td>
                    </tr>
                </table>
                <h2><?php echo __('Coordenadas');?></h2>
                <table class="table table-condensed table-hover table-striped">
                    <tr>
                        <th><?php echo __('Latitud');?></th>
                        <th><?php echo __('Longitud');?></th>
                    </tr>
                    <tr>
                        <td><?php echo $emplazamiento['Emplazamiento']['latitud'];?></td>
                        <td><?php echo $emplazamiento['Emplazamiento']['longitud'];?></td>
                    </tr>
                </table>
            </div>
    </div>
    <div id="servicios" class="pestanya row hidden">
        <div class="col-md-12">
            <h2><?php echo __('Servicios');?></h2>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('COMDES');?></th>
                    <th><?php echo __('TDT de la Generalitat');?></th>
                    <th><?php echo __('TDT RTVV');?></th>
                </tr>
                <tr>
                    <?php
                    $servicios = array(1 => 'comdes', 2 => 'tdt-gva', 4 => 'rtvv');
                    $servtipos = array();
                    foreach ($emplazamiento['Servicio'] as $servemp) {
                        $servtipos[] = $servemp['servtipo_id'];
                    }
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
            </table>
        </div>
    </div>
    <div id="titular" class="pestanya row hidden">
        <div class="col-md-12">
            <h2><?php echo __('Titular del emplazamiento');?></h2>
            <p><?php echo $emplazamiento['Entidad']['nombre'];?></p>
        </div>
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
        [<?php echo $emplazamiento['Emplazamiento']['latitud']; ?>,
        <?php echo $emplazamiento['Emplazamiento']['longitud']; ?>],
        10
    );
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
        maxZoom: 18
    }).addTo(mapa);
    L.control.scale().addTo(mapa);
    var iconoAzul = new Iconos({iconUrl: '../../img/marca-azul.png'});
    var iconoVerde = new Iconos({iconUrl: '../../img/marca-verde.png'});
    var marcador = L.marker(
        [<?php echo $emplazamiento['Emplazamiento']['latitud']; ?>,
        <?php echo $emplazamiento['Emplazamiento']['longitud']; ?>],
        {icon: iconoAzul}
    ).addTo(mapa);
    marcador.bindTooltip("<b><?php echo $emplazamiento['Emplazamiento']['centro']; ?></b>");
</script>
