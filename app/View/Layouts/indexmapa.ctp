<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('leaflet');
		echo $this->Html->script('jquery');
		echo $this->Html->script('bootstrap');
		echo $this->Html->script('leaflet');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<style type="text/css">
		#mapa{
			width: 100%;
			height: 500px;
			background-color: #EEEEEE;
		}
		.info {
		    padding: 6px 8px;
		    font: 14px/16px Arial, Helvetica, sans-serif;
		    background: white;
		    background: rgba(255,255,255,0.8);
		    box-shadow: 0 0 15px rgba(0,0,0,0.2);
		    border-radius: 5px;
		}
		.info h4 {
		    margin: 0 0 5px;
		    color: #777;
		}
		.legend {
			line-height: 18px;
			color: #555;
		}
		.legend i {
		    width: 18px;
		    height: 18px;
		    float: left;
		    margin-right: 8px;
		    opacity: 0.7;
		}
	</style>
</head>
<body>
	<div id="contenidos" class="container-fluid">
		<div id="header" class="row">
			<?php echo $this->element('menu'); ?>
		</div>
		<div id="content" class="row">
			<div class="col-md-12">
				<?php echo $this->Flash->render(); ?>
				<?php echo $this->Flash->render('auth'); ?>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<div id="footer" class="row">
			<p class="text-center">
				DGTIC &mdash; Servei de Telecomunicacions i Societat Digital
			</p>
		</div>
	</div>
	<?php
	//echo $this->element('sql_dump');
	echo $this->Js->writeBuffer();
	?>
</body>
</html>
