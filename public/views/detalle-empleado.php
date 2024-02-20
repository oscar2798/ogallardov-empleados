<div id="contenedorDetalleEmpleado" class="container is-max-desktop" style="margin-top: 80px; display: none;">
    <div class="notification is-link">
        <strong>Detalle del empleado</strong>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="content">

                <label class="label">Clave</label>
                <div class="control">
                    <input class="input" type="text" id="inputDetalleClave" readonly>
                </div>

                <label class="label">Nombre</label>
                <div class="control">
                    <input class="input" type="text" id="inputDetalleNombre" readonly>
                </div>

                <label class="label">Edad</label>
                <div class="control">
                    <input class="input" type="number" id="inputDetalleEdad" readonly>
                </div>

                <label class="label">Fecha de Nacimiento</label>
                <div class="control">
                    <input class="input" type="date" id="inputDetalleFecha" readonly>
                </div>

                <label class="label">Genero</label>
                <div class="control">
                    <input class="input" type="text" id="inputDetalleGenero" readonly>
                </div>

                <label class="label">Activo/Inactivo</label>
                <div class="control">
                    <input class="input" type="text" id="inputDetalleActivoInactivo" readonly>
                </div>

                <label class="label">Sueldo Base</label>
                <div class="control">
                    <input class="input" type="text" id="inputDetalleSueldo" readonly>
                </div>

                <label class="label">Puesto</label>
                <div class="control">
                    <input class="input" type="text" id="inputDetallePuesto" readonly>
                </div>

                <label class="label">Experiencia Profesional</label>
                <div class="control">
                    <textarea class="textarea" id="inputDetalleExperiencia" readonly></textarea>
                </div>

                <div>
                    <canvas id="graficaPesos" width="400" height="400"></canvas>
                </div>
                <div>
                    <canvas id="graficaDolares" width="400" height="400"></canvas>
                </div>
                <div class="field is-grouped">

                    <div class="control">
                        <button type="button" id="btnRegresar" class="button is-link is-light">Regesar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>