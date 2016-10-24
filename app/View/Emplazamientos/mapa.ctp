<h1><?php echo __('Emplazamientos de Telecomunicaciones de la Comunitat'); ?></h1>
<div id="mapa">

</div>
<script type="text/javascript">
    // Tipo de marcadores
    var Iconos = L.Icon.extend({
        options: {
            shadowUrl: '../img/marker-shadow.png',
            iconSize:     [25, 40], // Tamaño del Icono
            iconAnchor:   [12, 40], // Punto de anclaje del icono
            tooltipAnchor:  [5, -10],
            popupAnchor:  [5, -10]
        }
    });

    var mapa = L.map('mapa').setView([39.47, -0.38],10);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
        maxZoom: 18
    }).addTo(mapa);
    L.control.scale().addTo(mapa);
    var iconoAzul = new Iconos({iconUrl: '../img/marca-azul.png'});
    var iconoVerde = new Iconos({iconUrl: '../img/marca-verde.png'});
    var iconoRojo = new Iconos({iconUrl: '../img/marca-rojo.png'});
    var iconoNaranja = new Iconos({iconUrl: '../img/marca-naran.png'});
    var iconoAmarillo = new Iconos({iconUrl: '../img/marca-amar.png'});
    var iconoCian = new Iconos({iconUrl: '../img/marca-cian.png'});
    var iconoLila = new Iconos({iconUrl: '../img/marca-lila.png'});
    var iconoLima = new Iconos({iconUrl: '../img/marca-lima.png'});
    <?php
    foreach ($emplazamientos as $emplazamiento) {
        $comdes = substr($emplazamiento['Emplazamiento']['comdes'], 0, 1);
        $tdt = substr($emplazamiento['Emplazamiento']['tdt-gva'], 0, 1);
        $rtvv = substr($emplazamiento['Emplazamiento']['rtvv'], 0, 1);
        $servicios = $comdes . $rtvv . $tdt;
        switch ($servicios) {
            case 'SNN':
                $icono = 'iconoAzul';
                break;

            case 'NSN':
                $icono = 'iconoRojo';
                break;

            case 'NNS':
                $icono = 'iconoVerde';
                break;

            case 'SSN':
                $icono = 'iconoNaranja';
                break;

            case 'SNS':
                $icono = 'iconoAmarillo';
                break;

            case 'NSS':
                $icono = 'iconoLila';
                break;

            case 'SSS':
                $icono = 'iconoLima';
                break;

            default:
                $icono = 'iconoCian';
                break;
        }
    ?>
        var marcador = L.marker(
            [<?php echo $emplazamiento['Emplazamiento']['latitud']; ?>,
            <?php echo $emplazamiento['Emplazamiento']['longitud']; ?>],
            {icon: <?php echo $icono; ?>}
        ).addTo(mapa);
        var texto = "<b><?php echo $emplazamiento['Emplazamiento']['centro']; ?></b>";
        marcador.bindTooltip(texto);
        var textpopup = "<h4>";
        textpopup += "<?php echo $emplazamiento['Emplazamiento']['centro']; ?>";
        textpopup += " &mdash; ";
        textpopup += "<a href=detalle/<?php echo $emplazamiento['Emplazamiento']['id']; ?>>";
        textpopup += "<span class='glyphicon glyphicon-search' aria-hidden='true'></span>";
        textpopup += "</a></h4>";
        marcador.bindPopup(textpopup);
    <?php
    }
    ?>
    // Agregamos la leyenda:
    var leyenda = L.control({position: 'bottomright'});

    leyenda.onAdd = function (mapa) {
        var div = L.DomUtil.create('div', 'info legend'),
        colores = ['#002255', '#AA0000', '#008000', '#D45500', '#D4AA00', '#7137C8', '#00D400'],
        etiquetas = [
            'COMDES', 'RTVV', 'TDT-GVA', 'COMDES + RTVV', 'COMDES + TDT-GVA',
             'TDT-GVA + RTVV', 'COMDES, TDT-GVA + RTVV'
        ];
        div.innerHTML = '<h4><?php echo __("Emplazamientos por servicio");?></h4>';

        // Representamos los colores
        for (var i = 0; i < colores.length; i++) {
            div.innerHTML += '<i style="background:' + colores[i] + '"></i> ' + etiquetas[i] + '<br>';
        }
        return div;
    };
    leyenda.addTo(mapa);
</script>
