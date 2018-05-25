<ul id="dropdown1" class="dropdown-content">
	<li><a href="<?=base_url('/logout');?>">Salir</a></li>
</ul>
<div class="navbar-fixed">
	<nav>
		<div class="nav-wrapper grey darken-3">
			<div class="container">
				<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
				<a href="<?=base_url('/logout');?>" class="brand-logo" id="logo-title">Reloj Checador</a>
				<ul class="right hide-on-med-and-down">
					<li><a href="<?=base_url('/panel');?>">Historial</a></li>
					<li><a href="<?=base_url('/users');?>">Usuarios</a></li>
					<li><a href="<?=base_url('/reporte');?>">Reporte</a></li>
					<li><a class="dropdown-button" href="#!" data-activates="dropdown1"><?php echo $name; ?><i class="material-icons right">arrow_drop_down</i></a></li>
				</ul>
			</div>
			<ul class="side-nav" id="mobile-demo">
				<li><a href="<?=base_url('/logout');?>">Reloj Checador</a></li>
				<li><a href="<?=base_url('/panel');?>">Historial</a></li>
				<li><a href="<?=base_url('/users');?>">Usuarios</a></li>
				<li><a href="<?=base_url('/reporte');?>">Reporte</a></li>
				<li><a href="<?=base_url('/logout');?>">Salir</a></li>
			</ul>
		</div>
	</nav>
</div>