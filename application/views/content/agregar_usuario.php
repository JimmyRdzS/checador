<div class="container">
  <form id="form_agregar_usuario" class="row center-align">
    <div class="col s12 mt50">
      <h4>Nuevo Usuario</h4>
    </div>
    <div class="row">
      <div class="col s8 offset-s2 divider"></div>
    </div>
    <div class="row">
      <div class="col s12 center-align">
        <p id="contact_submit_message" class="hide">Ha ocurrido un error, intente nuevamente.</p>
      </div>
    </div>
    <div class="row">
      <div class="input-field col m4 s12">
        <select id="type" name="type" required>
          <option value="" disabled>Escoge una opción:</option>
          <option value="1">Administrador</option>
          <option value="2" selected>Empleado</option>
        </select>
        <label>Tipo de Usuario</label>
      </div>
      <div class="input-field col m8 s12">
        <input id="name" name="name" type="text" class="validate" minlength="3" autocomplete="off" required>
        <label for="name">Nombre Completo</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col m4 s12">
        <input id="password1" name="password1" type="password" class="validate" minlength="6" maxlength="6" required>
        <label for="password1">Clave</label>
      </div>
      <div class="input-field col m4 s12">
        <input id="password2" name="password2" type="password" class="validate" minlength="6" maxlength="6" required>
        <label for="password2">Confirme Clave</label>
      </div>
      <div class="input-field col m4 s12">
        <input id="admin_password" name="admin_password" type="password" class="validate" minlength="6" maxlength="6" required>
        <label for="admin_password">Clave Administrador</label>
      </div>
    </div>
    <div class="row col s12 center-align">
      <button class="btn waves-effect waves-light blue darken-4" type="submit">Guardar
        <i class="material-icons right">send</i>
      </button>
    </div>
  </form>
</div>