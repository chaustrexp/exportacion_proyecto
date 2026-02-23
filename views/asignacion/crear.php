<?php
// Vista manejada por el controlador
// $fichas, $instructores, $ambientes, $competencias ya están disponibles
?>

<div class="main-content">
    <div class="form-container">
        <h2>Crear Nueva Asignación</h2>
        <form method="POST">
            <div class="form-group">
                <label>Ficha *</label>
                <select name="ficha_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($fichas as $ficha): ?>
                        <option value="<?php echo safeHtml($ficha, 'fich_id'); ?>">
                            Ficha <?php echo str_pad(safeHtml($ficha, 'fich_numero'), 8, '0', STR_PAD_LEFT); ?> - <?php echo safeHtml($ficha, 'prog_denominacion'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Instructor *</label>
                <select name="instructor_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($instructores as $instructor): ?>
                        <option value="<?php echo safeHtml($instructor, 'inst_id'); ?>">
                            <?php echo safeHtml($instructor, 'inst_nombres') . ' ' . safeHtml($instructor, 'inst_apellidos'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Ambiente</label>
                <select name="ambiente_id" class="form-control">
                    <option value="">Seleccione...</option>
                    <?php foreach ($ambientes as $ambiente): ?>
                        <option value="<?php echo safeHtml($ambiente, 'amb_id'); ?>"><?php echo safeHtml($ambiente, 'amb_nombre'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Competencia</label>
                <select name="competencia_id" class="form-control">
                    <option value="">Seleccione...</option>
                    <?php foreach ($competencias as $competencia): ?>
                        <option value="<?php echo safeHtml($competencia, 'comp_id'); ?>"><?php echo safeHtml($competencia, 'comp_nombre_corto'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Fecha Inicio *</label>
                <input type="date" name="fecha_inicio" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Fecha Fin *</label>
                <input type="date" name="fecha_fin" class="form-control" required>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" onclick="mostrarVistaPrevia()" class="btn btn-secondary">Vista Previa</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
function mostrarVistaPrevia() {
    // Obtener valores del formulario
    const fichaSelect = document.querySelector('select[name="ficha_id"]');
    const instructorSelect = document.querySelector('select[name="instructor_id"]');
    const ambienteSelect = document.querySelector('select[name="ambiente_id"]');
    const competenciaSelect = document.querySelector('select[name="competencia_id"]');
    const fechaInicio = document.querySelector('input[name="fecha_inicio"]').value;
    const fechaFin = document.querySelector('input[name="fecha_fin"]').value;
    
    const fichaTexto = fichaSelect.options[fichaSelect.selectedIndex]?.text || 'No seleccionado';
    const instructorTexto = instructorSelect.options[instructorSelect.selectedIndex]?.text || 'No seleccionado';
    const ambienteTexto = ambienteSelect.options[ambienteSelect.selectedIndex]?.text || 'No seleccionado';
    const competenciaTexto = competenciaSelect.options[competenciaSelect.selectedIndex]?.text || 'No seleccionado';
    const fichaId = fichaSelect.value || '1';
    
    // Validar que al menos ficha e instructor estén seleccionados
    if (!fichaSelect.value || !instructorSelect.value) {
        alert('Por favor selecciona al menos Ficha e Instructor para ver la vista previa');
        return;
    }
    
    const modal = `
        <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999; padding: 20px;" onclick="this.remove()">
            <div style="background: white; border-radius: 12px; max-width: 700px; width: 100%; box-shadow: 0 25px 70px rgba(0,0,0,0.4); overflow: hidden; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
                
                <!-- Header -->
                <div style="background: white; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 32px; height: 32px; background: #39A900; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                            <span style="font-size: 18px;">📋</span>
                        </div>
                        <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">Detalles de la Solicitud: ${fichaTexto}</h3>
                    </div>
                    <button onclick="this.closest('div[style*=fixed]').remove()" style="background: transparent; border: none; width: 28px; height: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 24px; line-height: 1;">×</button>
                </div>

                <!-- Contenido -->
                <div style="padding: 24px;">
                    
                    <!-- Sección: Información de la Ficha -->
                    <div style="margin-bottom: 24px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; padding: 8px 12px; background: white; border-left: 4px solid #39A900;">
                            <span style="font-size: 14px; font-weight: 700; color: #1f2937;">Información de la Ficha</span>
                        </div>
                        
                        <!-- Tabla de información -->
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb;">
                            <thead>
                                <tr style="background: #39A900;">
                                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">CAMPO</th>
                                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">VALOR</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase; border-right: 1px solid rgba(255,255,255,0.3);">ESTADO</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 700; color: white; text-transform: uppercase;">VERIFICADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">ID Ficha</td>
                                    <td style="padding: 12px 16px; font-size: 13px; color: #1f2937;">${fichaId}</td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">ACTIVO</span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="color: #39A900; font-size: 18px;">✓</span>
                                    </td>
                                </tr>
                                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Instructor</td>
                                    <td style="padding: 12px 16px; font-size: 13px; color: #1f2937;">${instructorTexto}</td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">VÁLIDO</span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="color: #39A900; font-size: 18px;">✓</span>
                                    </td>
                                </tr>
                                <tr style="background: white; border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #374151;">Ambiente</td>
                                    <td style="padding: 12px 16px; font-size: 13px; color: #1f2937;">${ambienteTexto}</td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase;">VÁLIDO</span>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <span style="color: #39A900; font-size: 18px;">✓</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Información adicional -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #e5e7eb;">
                            <div style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">COMPETENCIA</div>
                            <div style="font-size: 16px; font-weight: 700; color: #1f2937;">${competenciaTexto}</div>
                        </div>
                        <div style="background: white; padding: 16px; border-radius: 8px; border: 2px solid #e5e7eb;">
                            <div style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">PERÍODO</div>
                            <div style="font-size: 14px; font-weight: 700; color: #1f2937;">${fechaInicio ? new Date(fechaInicio).toLocaleDateString('es-ES') : 'No definido'} - ${fechaFin ? new Date(fechaFin).toLocaleDateString('es-ES') : 'No definido'}</div>
                        </div>
                    </div>

                    <!-- Botón cerrar -->
                    <div style="display: flex; gap: 12px;">
                        <button onclick="this.closest('div[style*=fixed]').remove()" style="flex: 1; padding: 12px; background: #6b7280; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modal);
}
</script>

<?php // Footer incluido por BaseController ?>
