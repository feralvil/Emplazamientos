<?php
/**
 * Menú de Navegación
 */
$controlador = $this->request->controller;
$rol = AuthComponent::user('role');
$nomUser = AuthComponent::user('nombre');
if ($rol != 'admin'){
    $nomUser = substr($nomUser, 0, 1);
    $nomUser .= '. '.AuthComponent::user('apellido1');
}
?>

<div class="col-md-12">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="navbar-header">
                    <?php
                    echo $this->Html->image("minidgtic.png", array(
                        "alt" => __('Inicio'),
                        "title" => __('Inicio'),
                        'url' => array('controller' => 'emplazamientos', 'action' => 'index')
                    ));
                    ?>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php
                        if ($rol == 'admin'){
                            echo '<li';
                            if ($controlador == "users"){
                                echo ' class="active"';
                            }
                            echo '>';
                            echo $this->Html->Link(__('Usuarios'),array('controller' => 'users', 'action' => 'index'), array('title' => __('Usuarios')));
                            echo '</li>';
                        }
                        echo '<li class="dropdown"';
                        if ($controlador == "emplazamientos"){
                            echo ' class="active"';
                        }
                        echo '>';
                        echo $this->Html->Link(
                            __('Emplazamientos') . ' <span class="caret"></span>',
                            array('controller' => 'emplazamientos', 'action' => 'index'),
                            array('title' => __('Emplazamientos'), 'class' => "dropdown-toggle", 'data-toggle' => "dropdown", 'role' => "button", 'aria-haspopup' => "true",  'aria-expanded' => "false", 'escape' => false)
                        );
                        echo '<ul class="dropdown-menu">';
                        echo '<li>';
                        echo $this->Html->Link(__('Mapa'),array('controller' => 'emplazamientos', 'action' => 'mapa'), array('title' => __('Mapa')));
                        echo '</li>';
                        echo '</ul>';
                        echo '</li>';
                        echo '<li';
                        if ($controlador == "servicios"){
                            echo ' class="active"';
                        }
                        echo '>';
                        echo $this->Html->Link(__('Servicios'),array('controller' => 'servicios', 'action' => 'index'), array('title' => __('Servicios')));
                        echo '</li>';
                        ?>
                    </ul>
                    <p class="navbar-text navbar-right">
                        <?php
                        echo $nomUser . ' &nbsp; ';
                        echo $this->Html->Link(
                            '<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>',
                            array('controller' => 'users', 'action' => 'logout'),
                            array('title' => __('Cerrar Sesión'), 'alt' => __('Cerrar Sesión'), 'escape' => false)
                        );
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </nav>
</div>
