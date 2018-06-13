<div class="container">
  <div class="row mt50">
    <h4 id="reporte-registros" >Reporte de Registros</h4>
  </div>
  <div class="row">
    <div class="input-field col m4 s12">
      <select id="usuarios_reporte" name="usuarios_reporte">
        <option value="0">Todos los usuarios</option>
      </select>
      <label>Usuario</label>
    </div>
    <div class="input-field col m4 s12">
      <select id="fecha_periodo" name="fecha_periodo">
        <option value="0" disabled selected>Escoge una opción:</option>
        <option value="1" disabled>Enero</option>
        <option value="2" disabled>Febrero</option>
        <option value="3" disabled>Marzo</option>
        <option value="4" disabled>Abril</option>
        <option value="5" disabled>Mayo</option>
        <option value="6" disabled>Junio</option>
        <option value="7" disabled>Julio</option>
        <option value="8" disabled>Agosto</option>
        <option value="9" disabled>Septiembre</option>
        <option value="10" disabled>Octubre</option>
        <option value="11" disabled>Noviembre</option>
        <option value="12" disabled>Diciembre</option>
      </select>
      <label>Periodo</label>
    </div>
  </div>
  <div id="graficas-acumuladas" class="row">
    <div class="col s12">
      <div class="row full-width">
        <div class="col s12">
          <h5 class="pd15">Registros por día</h5>
          <div class="divider"></div>
          <canvas id="registros-dia" width="100%" height="30"></canvas>
        </div>
      </div>
      <div class="row full-width">
        <div class="col s12">
          <h5 class="pd15">Horas trabajadas por día</h5>
          <div class="divider"></div>
          <canvas id="horas-dia" width="100%" height="30"></canvas>
        </div>
      </div>
      <div class="row full-width">
        <div class="col s12">
          <h5 class="pd15">Horas trabajadas por usuario</h5>
          <div class="divider"></div>
          <canvas id="horas-usuario" width="100%" height="30"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div id="graficas-individuales" class="row hide">
    <div class="col s12">
      <div class="row full-width">
        <div class="col s12">
          <h5 class="pd15">Horas trabajadas por día</h5>
          <div class="divider"></div>
          <canvas id="horas-dia-usuario" width="100%" height="30"></canvas>
        </div>
      </div>
<!--       <div class="row full-width">
        <div class="col s12">
          <h5 class="pd15">Horario de asistencia</h5>
          <div class="divider"></div>
          <div id="horario_usuario" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div> -->
      <div class="row full-width">
        <div class="col s4 center-align">
          <h5 class="average-title">Horas trabajadas</h5>
          <div class="divider"></div>
          <p id="total-horas-trabajadas" class="average-text">15 horas</p>
        </div>
<!--         <div class="col s4 center-align">
          <h5 class="average-title">Hora de llegada (promedio).</h5>
          <div class="divider"></div>
          <p id="promedio-hora-llegada" class="average-text">09:00</p>
        </div>
        <div class="col s4 center-align">
          <h5 class="average-title">Hora de salida (promedio).</h5>
          <div class="divider"></div>
          <p id="promedio-hora-salida" class="average-text">19:00</p>
        </div> -->
      </div>
    </div>
  </div>
</div>