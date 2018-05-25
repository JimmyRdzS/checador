  <?php if(!defined('BASEPATH')) exit('No direct script access allowed.');

  $plugins = base_url('assets/plugins').'/';
  $jsPath = base_url('assets/js').'/';
  ?>
  
  <script src="<?php echo $jsPath; ?>jquery-3.2.1.js"></script>
  <script src="<?php echo $jsPath; ?>jquery.validate.js"></script>
  <script src="<?php echo $jsPath; ?>wNumb.js"></script>
  <script src="<?php echo $jsPath; ?>nouislider.js"></script>
  <script src="<?php echo $plugins; ?>data_tables/datatables.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/highcharts-more.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="<?php echo $jsPath; ?>materialize.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
  <script>
  	var base_url = '<?php echo base_url(); ?>';
  </script>

  <?php
  if(isset($view_controller))
  {
  	if( ! is_array($view_controller))
  	{
  		?>
  		<script type="text/javascript" src="<?php echo $jsPath.'view_controllers/'.$view_controller; ?>"></script>
  		<?php
  	}
  	else
  	{
  		foreach($view_controller as $vc)
  		{
  			?>
  			<script type="text/javascript" src="<?php echo $jsPath.'view_controllers/'.$vc; ?>"></script>
  			<?php
  		}
  	}
  }
  ?>
</div>
</body>
</html>