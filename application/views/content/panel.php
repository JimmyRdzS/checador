<div class="container">
  <div class="row mt25">
    <div class="col s12 center-align">
      <h4>Historial de Actividades</h4>
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

  <div id="home_submit_message" class="row hide">
    <div class="col s12">
      <p class="home_submit_message" id="submit_message"></p>
    </div>
  </div>

  <div class="row" style="margin-bottom: 0px;">
    <div class="input-field col m4 s12  offset-m8">
      <select id="fecha_home_datatable" name="fecha_home_datatable">
        <option value="0" selected>Todos</option>
        <option value="1">Enero</option>
        <option value="2">Febrero</option>
        <option value="3">Marzo</option>
        <option value="4">Abril</option>
        <option value="5">Mayo</option>
        <option value="6">Junio</option>
        <option value="7">Julio</option>
        <option value="8">Agosto</option>
        <option value="9">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
      </select>
      <label>Periodo de Registro</label>
    </div>
  </div>

  <div id="home_table" class="row">
    <table id="dataTable" class="highlight row-border">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Fecha de entrada</th>
          <th>Hora de entrada</th>
          <th>Fecha de salida</th>
          <th>Hora de salida</th>
          <th class="center-align">Opciones</th>
        </tr>
      </thead>

      <tbody id="home_data">

      </tbody>
    </table>
  </div>
</div>

<div id="eliminar_registro" class="modal">
  <div class="modal-content">
    <div class="row">
      <div class="col l12 center">
        <h5>Está seguro que desea eliminar el registro?:</h5>
        <div class="divider"></div>     
      </div>
      <div class="col s12 center-align">
        <p id="delete_message" class="hide"></p>
      </div>
      <div id="datos-registro" class="col s12 center-align">
        
      </div>
      <div class="col l12">
        <form id="delete_register_form" name="delete_register_form" class="col s12">

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