<div class="container">
  <form id="form_editar_registro" class="row center-align">
    <div class="col s12 mt50">
      <h4>Editar Registro</h4>
      <h5 id="nombre-empleado"></h5>
    </div>
    <div class="row">
      <div class="col s8 offset-s2 divider"></div>
    </div>
    <div class="row">
      <div class="col s12 center-align">
        <p id="edit_message" class="hide">Ha ocurrido un error, intente nuevamente.</p>
      </div>
    </div>
    <div class="row hide">
      <input id="id_registro" name="id_registro" type="hidden" value="<?php echo $id; ?>">
      <label for="id_registro">Id User</label>
    </div>
    <div class="row">
      <div class="input-field col m4 s12">
        <label for="entry-datepicker" class="">Fecha del Registro</label>
        <input id="entry-datepicker" name="entry-date" type="text" class="datepicker" required>
        <input type="hidden" name="prefix__entry-date">
      </div>
      <div class="input-field col m4 s12">
        <label for="entry-timepicker" class="">Hora de entrada</label>
        <input id="entry-timepicker" name="entry-time" type="text" class="timepicker" required>
        <input type="hidden" name="prefix__entry-time">
      </div>
      <div class="input-field col m4 s12">
        <label for="exit-timepicker" class="">Hora de salida</label>
        <input id="exit-timepicker" name="exit-time" type="text" class="timepicker" required>
        <input type="hidden" name="prefix__exit-time">
      </div>
    </div>
    <div class="row">
      <div class="input-field col m4 s12">
        <input id="admin_password" name="admin_password" type="password" class="validate" minlength="6" maxlength="6" required>
        <label for="admin_password">Clave Administrador</label>
      </div>
    </div>
    <div class="row col s12 center-align">
      <button class="btn waves-effect waves-light blue darken-4" type="submit">Actualizar
        <i class="material-icons right">send</i>
      </button>
    </div>
  </form>
</div>