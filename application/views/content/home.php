<div id="home">
  <div id="clock">
    <div class="container">
      <div class="row">
        <div class="col s12 center-align">
          <p class="fecha"><span id="fecha"><?php echo $date; ?></span></p>
          <h2 id="hora">00:00:00</h2>
        </div>
      </div>
    </div>
  </div>
  <div id="login" class="valign-wrapper">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-margin">
        <div class="col s12 center-align">
          <form id="register_form" name="register_form">
            <div class="row no-margin">
              <div class="col s12">
                <p id="register_submit_message" class="center-align hide"></p>
              </div>
            </div>
            <div class="row form-width">
              <div class="input-field col s12 form-label">
                <input id="clave" name="clave" type="password" class="validate" required minlength="6" maxlength="6" style="font-size: 2rem; padding-top: 5px;">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="options">
  <div class="row">
    <div class="col s12 center-align">
      <button onclick="show_login()" class="btn-floating btn-extra-large waves-effect waves-light grey darken-1"><i class="material-icons">vpn_key</i></button>
    </div>
  </div>
</div>

<div id="last-insert" class="hide">
  <div class="col s12 m7">
    <div class="card horizontal hoverable" style="background-color: rgba(255,255,255,0.6);">
      <div class="card-stacked">
        <div id="last-insert-data" class="card-content">

        </div>
      </div>
    </div>
  </div>
</div>

<div id="checkout_activity" class="modal">
  <div class="modal-content">
    <div class="row">
      <div class="col s12 center-align">
        <h5 id="nombre_trabajador"></h5>
        <div class="divider"></div>
        <p style="margin: 5px 0px;font-size: 18px;font-weight: 700;">Registro de actividades.</p>   
      </div>
      <div class="col s12">
        <form id="agregar_actividad_form" name="agregar_actividad_form" class="col s12">
          <div class="row">
            <div class="input-field">
              <textarea id="actividad" name="actividad" class="materialize-textarea activity-textarea" required></textarea>
              <label for="actividad">Descripción de las actividades.</label>
            </div>
          </div>

          <input id="clave_trabajador" type="hidden" name="clave_trabajador">

          <div class="input-field right-align">
            <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" type="reset">Cancelar</button>
            <button type="submit" class="btn waves-effect btn-block waves-light green">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="login_modal" class="modal">
  <div class="modal-content">
    <div class="row">
      <div class="col s12 center-align">
        <h5>Plataforma Administrativa</h5>
        <div class="divider"></div>
        <p id="login_message" class="center-align hide" style="color: red;">Ha ocurrido un error en el servidor, por favor intente nuevamente.</p>
      </div>
      <div class="col s12">
        <form id="login_form" name="login_form" class="col s12">
          <div class="row">
            <div class="input-field">
              <input id="admin_password" name="admin_password" type="password" class="validate" required minlength="6" maxlength="6" style="font-size: 2rem; padding-top: 5px;">
              <label for="admin_password">Clave de Administrador</label>
            </div>
          </div>

          <div class="input-field right-align">
            <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" type="reset">Cancelar</button>
            <button type="submit" class="btn waves-effect btn-block waves-light green">Entrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>