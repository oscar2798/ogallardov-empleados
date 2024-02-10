<div id="formEmpleado" class="container is-max-desktop" style="margin-top: 80px; display: none;">
    <div class="notification is-link">
        <strong>Agregar Empleado</strong>
    </div>
    <div class="card">
        <div class="card-content">
            <div class="content">
                <form id="formEmpleado" method="post">
                    <div class="field">
                        <label class="label">Clave</label>
                        <div class="control">
                            <input class="input" type="text" id="inputClave" name="clave" placeholder="Text input">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Nombre</label>
                        <div class="control">
                            <input class="input" type="text" id="inputNombre" name="nombre" placeholder="Text input">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Edad</label>
                        <div class="control">
                            <input class="input" type="number" id="inputEdad" name="edad" placeholder="Text input">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Fecha de Nacimiento</label>
                        <div class="control">
                            <input class="input" type="date" id="inputFecha" name="fecha_nacimiento">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Genero</label>
                        <div class="control">
                            <div class="select">
                                <select id="inputGenero" name="genero">
                                    <option>Hombre</option>
                                    <option>Mujer</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Sueldo Base</label>
                        <div class="control">
                            <input class="input" type="text" id="inputSueldo" name="sueldo_base">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Puesto</label>
                        <div class="control">
                            <input class="input" type="text" id="inputPuesto" name="puesto">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Experiencia Profesional</label>
                        <div class="control">
                            <textarea class="textarea" id="inputExperiencia" name="experiencia_profesional"></textarea>
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button id="btnGuardarEmpleado" class="button is-link">Registrar</button>
                        </div>
                        <div class="control">
                            <button id="btnCancelarEmpleado" class="button is-link is-light">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>