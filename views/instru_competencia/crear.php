<?php
// Vista manejada por el controlador
// $instructores, $competenciasPorPrograma ya están disponibles
?>

<div class="main-content">
    <div style="max-width: 700px; margin: 0 auto; padding: 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #e5e7eb;">
                <a href="<?php echo BASE_PATH; ?>instru_competencia/index" style="display: inline-flex; align-items: center; gap: 8px; color: #6b7280; text-decoration: none; margin-bottom: 16px; font-size: 14px;">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                    Volver a Competencias de Instructores
                </a>
                <h1 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Asignar Competencia a Instructor</h1>
                <p style="font-size: 14px; color: #6b7280; margin: 0;">Crea una nueva asignación de competencia</p>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error" style="margin-bottom: 24px;">
                    ✗ <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert alert-error" style="margin-bottom: 24px;">
                    <strong>Por favor corrija los siguientes errores:</strong>
                    <ul style="margin: 8px 0 0; padding-left: 20px;">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>
            
            <?php if (empty($competenciasPorPrograma ?? [])): ?>
                <div class="alert alert-error" style="margin-bottom: 24px;">
                    <strong>⚠️ Configuración Requerida:</strong> No hay competencias asociadas a programas. 
                    Primero debes crear asociaciones en la sección 
                    <a href="<?php echo BASE_PATH; ?>competencia_programa/index" style="color: #39A900; font-weight: 600;">Competencias por Programa</a>.
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo BASE_PATH; ?>instru_competencia/crear" id="formCrear">
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Instructor <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="INSTRUCTOR_inst_id" 
                            class="form-control" 
                            required
                            style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Seleccione un instructor...</option>
                        <?php if (isset($instructores) && is_array($instructores)): ?>
                            <?php foreach ($instructores as $instructor): ?>
                                <option value="<?php echo htmlspecialchars($instructor['inst_id'] ?? ''); ?>"
                                        <?php echo (isset($_SESSION['old_input']['INSTRUCTOR_inst_id']) && $_SESSION['old_input']['INSTRUCTOR_inst_id'] == $instructor['inst_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars(($instructor['inst_nombres'] ?? '') . ' ' . ($instructor['inst_apellidos'] ?? '')); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Programa y Competencia <span style="color: #ef4444;">*</span>
                    </label>
                    <select id="programa_competencia_combo" 
                            class="form-control" 
                            required
                            onchange="separarProgramaCompetencia()"
                            style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                        <option value="">Seleccione una combinación Programa + Competencia...</option>
                        <?php if (isset($competenciasPorPrograma) && is_array($competenciasPorPrograma)): ?>
                            <?php foreach ($competenciasPorPrograma as $cp): ?>
                                <?php 
                                $valor = ($cp['PROGRAMA_prog_id'] ?? '') . '|' . ($cp['COMPETENCIA_comp_id'] ?? '');
                                $texto = ($cp['prog_denominacion'] ?? 'N/A') . ' → ' . ($cp['comp_nombre_corto'] ?? 'N/A');
                                $selected = '';
                                if (isset($_SESSION['old_input']['COMPETxPROGRAMA_PROGRAMA_prog_id']) && 
                                    isset($_SESSION['old_input']['COMPETxPROGRAMA_COMPETENCIA_comp_id'])) {
                                    $oldValor = $_SESSION['old_input']['COMPETxPROGRAMA_PROGRAMA_prog_id'] . '|' . $_SESSION['old_input']['COMPETxPROGRAMA_COMPETENCIA_comp_id'];
                                    $selected = ($valor == $oldValor) ? 'selected' : '';
                                }
                                ?>
                                <option value="<?php echo htmlspecialchars($valor); ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($texto); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                        Solo se muestran combinaciones válidas ya asociadas en Competencias por Programa
                    </small>
                    
                    <input type="hidden" name="COMPETxPROGRAMA_PROGRAMA_prog_id" id="programa_id_hidden" 
                           value="<?php echo isset($_SESSION['old_input']['COMPETxPROGRAMA_PROGRAMA_prog_id']) ? htmlspecialchars($_SESSION['old_input']['COMPETxPROGRAMA_PROGRAMA_prog_id']) : ''; ?>">
                    <input type="hidden" name="COMPETxPROGRAMA_COMPETENCIA_comp_id" id="competencia_id_hidden"
                           value="<?php echo isset($_SESSION['old_input']['COMPETxPROGRAMA_COMPETENCIA_comp_id']) ? htmlspecialchars($_SESSION['old_input']['COMPETxPROGRAMA_COMPETENCIA_comp_id']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Fecha de Vigencia <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="date" 
                           name="inscomp_vigencia" 
                           class="form-control" 
                           required
                           value="<?php echo isset($_SESSION['old_input']['inscomp_vigencia']) ? htmlspecialchars($_SESSION['old_input']['inscomp_vigencia']) : date('Y-m-d'); ?>"
                           style="width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                        Fecha hasta la cual la competencia es válida
                    </small>
                </div>
                
                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="<?php echo BASE_PATH; ?>instru_competencia/index" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Asignación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
// Limpiar old_input después de mostrar
if (isset($_SESSION['old_input'])) {
    unset($_SESSION['old_input']);
}
?>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    function separarProgramaCompetencia() {
        const combo = document.getElementById('programa_competencia_combo');
        const valor = combo.value;
        if (valor) {
            const partes = valor.split('|');
            document.getElementById('programa_id_hidden').value = partes[0];
            document.getElementById('competencia_id_hidden').value = partes[1];
        }
    }
    
    // Si hay valores previos, separarlos al cargar
    window.addEventListener('DOMContentLoaded', function() {
        const combo = document.getElementById('programa_competencia_combo');
        if (combo.value) {
            separarProgramaCompetencia();
        }
    });
    
    // Validar antes de enviar
    document.getElementById('formCrear').addEventListener('submit', function(e) {
        const programaId = document.getElementById('programa_id_hidden').value;
        const competenciaId = document.getElementById('competencia_id_hidden').value;
        
        if (!programaId || !competenciaId) {
            e.preventDefault();
            alert('Por favor seleccione una combinación de Programa y Competencia');
            return false;
        }
    });
</script>
