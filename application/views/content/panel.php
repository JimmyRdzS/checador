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