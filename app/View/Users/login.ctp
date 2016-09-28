<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php
        echo $this->Form->create('User', array(
            'inputDefaults' => array('label' => false,'div' => false),
            'class' => 'form-horizontal'
        ));
        ?>
        <fieldset>
            <legend><?php echo __('Inicio de Sesión');?></legend>
            <div class="form-group">
                <?php
                echo $this->Form->label('User.username', __('Usuario'), array('class' => 'col-sm-4 control-label'));
                echo $this->Form->input('User.username', array('div' => 'col-sm-8'));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->label('User.password', __('Contraseña'), array('class' => 'col-sm-4 control-label'));
                echo $this->Form->input('User.password', array('div' => 'col-sm-8'));
                ?>
            </div>
            <div class="form-group text-center">
                <div class="btn-group" role="group" aria-label="...">
                    <?php
                    echo $this->Form->button(
                    '<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> &nbsp;' . __('Iniciar Sesión'),
                    array('class' => 'btn btn-default', 'title' => __('Iniciar Sesión'), 'alt' => __('Iniciar Sesión'), 'escape' => false)
                    );
                    echo $this->Form->button(
                    '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>  &nbsp;'.__('Cancelar Cambios'),
                    array('type' => 'reset', 'class' => 'btn btn-default', 'title' => __('Cancelar Cambios'), 'alt' => __('Cancelar Cambios'), 'escape' => false)
                    );
                    ?>
                </div>
            </div>
        </fieldset>
        <?php
        echo $this->Form->end();
        ?>
    </div>
</div>
