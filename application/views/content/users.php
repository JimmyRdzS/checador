<div class="container">
  <div class="row mt25">
    <div class="col push-s1 s10 center-align">
      <h4>Usuarios</h4>
    </div>
    <div class="col pull-s1 s1">
      <a href="<?=base_url('/agregar_usuario');?>" class="btn-floating btn-large waves-effect waves-light pulse green tooltipped" data-position="right" data-delay="50" data-tooltip="Nuevo Usuario"><i class="material-icons right">add</i></a>
    </div>
  </div>
  <div class="row">
    <div class="col s8 offset-s2 divider"></div>
  </div>

  <div id="data_table_error" class="row hide">
    <div class="col s12 center-align">
      <p class="data_table_error">No se ha encontrado ningun registro.</p>
    </div>
  </div>

  <div id="users_submit_message" class="row hide">
    <div class="col s12">
      <p class="users_submit_message" id="submit_message"></p>
    </div>
  </div>

  <div id="users_table" class="row">
    <table id="users_dataTable" class="highlight row-border">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Estatus</th>
          <th class="center-align">Opciones</th>
        </tr>
      </thead>

      <tbody id="users_data">

      </tbody>
    </table>
  </div>
</div>

<div id="eliminar_usuario" class="modal">
  <div class="modal-content">
    <div class="row">
      <div class="col l12 center">
        <h5>Está seguro que desea eliminar al usuario <span id="eliminar_nombre"></span>?</h5>
        <div class="divider"></div>     
      </div>
      <div class="col s12 center-align">
        <p id="delete_message" class="hide"></p>
      </div>
      <div class="col l12">
        <form id="delete_user_form" name="delete_user_form" class="col s12">

          <div class="input-field">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password_admin" type="password" class="validate" name="password_admin" required>
            <label for="password_admin">Ingrese su clave</label>
          </div>

          <input id="id_eliminar" type="hidden" name="id_eliminar">

          <div class="input-field right-align">
            <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" type="reset">Cancelar</button>
            <button type="submit" class="btn waves-effect btn-block waves-light green">Eliminar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="change_password" class="modal plr-10">
  <div class="modal-content">
    <div class="row">
      <div class="col s12 center-align">
        <p id="change_message" class="hide"></p>
      </div>
      <div class="col l5 center">
        <h5>Cambiar clave para <br><span id="cp_nombre"></span></h5>
        <div class="divider"></div>     
      </div>
      <div class="col l7">
        <form class="col s12" id="form_changep" name="form_changep">

          <div class="input-field">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password" type="password" class="validate" name="password" minlength="6" maxlength="6" required>
            <label for="password">Nueva clave</label>
          </div>

          <div class="input-field">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password_confirmation" type="password" class="validate" minlength="6" maxlength="6" name="password_confirmation" required>
            <label for="password_confirmation">Confirme la nueva clave</label>
          </div>

          <input id="id" type="hidden" class="validate" name="id">

          <div class="input-field right-align">
            <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" type="reset">Cerrar</button>
            <button type="submit" class="btn waves-effect btn-block waves-light green">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>