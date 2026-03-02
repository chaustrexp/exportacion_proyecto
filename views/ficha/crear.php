<?php
// Vista manejada por el controlador
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; border-bottom: 1px solid #e5e7eb;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 4px;">
            <a href="<?php echo BASE_PATH; ?>ficha/index" style="color: #6b7280; hover:color: #39A900;">
                <i data-lucide="arrow-left" style="width: 20px; height: 20px;"></i>
            </a>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0;">Nueva Ficha</h1>
        </div>
        <p style="font-size: 14px; color: #6b7280; margin: 0 0 0 36px;">Registra una nueva ficha de formación</p>
    </div>

    <!-- Errores generales -->
    <?php if (!empty($errors['general'])): ?>
        <div style="margin: 24px 32px; padding: 16px; background: #FEE2E2; border-left: 4px solid #DC2626; border-radius: 8px; color: #991B1B;">
            <strong>Error:</strong> <?php echo htmlspecialchars($errors['general']); ?>
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <div style="padding: 32px;">
        <form method="POST" action="<?php echo BASE_PATH; ?>ficha/create" style="max-width: 800px; margin: 0 auto;">
            <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
                
                <!-- Número de Ficha -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Número de Ficha <span style="color: #DC2626;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="fich_numero" 
                        value="<?php echo htmlspecialchars($old_input['fich_numero'] ?? ''); ?>"
                        placeholder="Ej: 3115418"
                        required
                        style="width: 100%; padding: 12px; border: 2px solid <?php echo isset($errors['fich_numero']) ? '#DC2626' : '#e5e7eb'; ?>; border-radius: 8px; font-size: 14px;"
                    >
                    <?php if (isset($errors['fich_numero'])): ?>
                        <p style="color: #DC2626; font-size: 12px; margin: 4px 0 0;"><?php echo $errors['fich_numero']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Programa -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Programa <span style="color: #DC2626;">*</span>
                    </label>
                    <select 
                        name="PROGRAMA_prog_id" 
                        required
                        style="width: 100%; padding: 12px; border: 2px solid <?php echo isset($errors['PROGRAMA_prog_id']) ? '#DC2626' : '#e5e7eb'; ?>; border-radius: 8px; font-size: 14px; background: white;"
                    >
                        <option value="">Seleccione un programa</option>
                        <?php foreach ($programas as $programa): ?>
                            <option value="<?php echo $programa['prog_codigo']; ?>" <?php echo ($old_input['PROGRAMA_prog_id'] ?? '') == $programa['prog_codigo'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($programa['prog_denominacion']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['PROGRAMA_prog_id'])): ?>
                        <p style="color: #DC2626; font-size: 12px; margin: 4px 0 0;"><?php echo $errors['PROGRAMA_prog_id']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Instructor Líder -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Instructor Líder
                    </label>
                    <select 
                        name="INSTRUCTOR_inst_id_lider" 
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; background: white;"
                    >
                        <option value="">Seleccione un instructor (opcional)</option>
                        <?php foreach ($instructores as $instructor): ?>
                            <option value="<?php echo $instructor['inst_id']; ?>" <?php echo ($old_input['INSTRUCTOR_inst_id_lider'] ?? '') == $instructor['inst_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($instructor['inst_nombres'] . ' ' . $instructor['inst_apellidos']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Jornada -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Jornada <span style="color: #DC2626;">*</span>
                    </label>
                    <select 
                        name="fich_jornada" 
                        required
                        style="width: 100%; padding: 12px; border: 2px solid <?php echo isset($errors['fich_jornada']) ? '#DC2626' : '#e5e7eb'; ?>; border-radius: 8px; font-size: 14px; background: white;"
                    >
                        <option value="">Seleccione una jornada</option>
                        <option value="Diurna" <?php echo ($old_input['fich_jornada'] ?? '') == 'Diurna' ? 'selected' : ''; ?>>Diurna</option>
                        <option value="Nocturna" <?php echo ($old_input['fich_jornada'] ?? '') == 'Nocturna' ? 'selected' : ''; ?>>Nocturna</option>
                        <option value="Mixta" <?php echo ($old_input['fich_jornada'] ?? '') == 'Mixta' ? 'selected' : ''; ?>>Mixta</option>
                        <option value="Fin de Semana" <?php echo ($old_input['fich_jornada'] ?? '') == 'Fin de Semana' ? 'selected' : ''; ?>>Fin de Semana</option>
                    </select>
                    <?php if (isset($errors['fich_jornada'])): ?>
                        <p style="color: #DC2626; font-size: 12px; margin: 4px 0 0;"><?php echo $errors['fich_jornada']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Coordinación -->
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Coordinación
                    </label>
                    <select 
                        name="COORDINACION_coord_id" 
                        style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; background: white;"
                    >
                        <option value="">Seleccione una coordinación (opcional)</option>
                        <?php foreach ($coordinaciones as $coord): ?>
                            <option value="<?php echo $coord['coord_id']; ?>" <?php echo ($old_input['COORDINACION_coord_id'] ?? '') == $coord['coord_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($coord['coord_nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Fechas -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Fecha Inicio Lectiva <span style="color: #DC2626;">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="fich_fecha_ini_lectiva" 
                            value="<?php echo htmlspecialchars($old_input['fich_fecha_ini_lectiva'] ?? ''); ?>"
                            required
                            style="width: 100%; padding: 12px; border: 2px solid <?php echo isset($errors['fich_fecha_ini_lectiva']) ? '#DC2626' : '#e5e7eb'; ?>; border-radius: 8px; font-size: 14px;"
                        >
                        <?php if (isset($errors['fich_fecha_ini_lectiva'])): ?>
                            <p style="color: #DC2626; font-size: 12px; margin: 4px 0 0;"><?php echo $errors['fich_fecha_ini_lectiva']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                            Fecha Fin Lectiva <span style="color: #DC2626;">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="fich_fecha_fin_lectiva" 
                            value="<?php echo htmlspecialchars($old_input['fich_fecha_fin_lectiva'] ?? ''); ?>"
                            required
                            style="width: 100%; padding: 12px; border: 2px solid <?php echo isset($errors['fich_fecha_fin_lectiva']) ? '#DC2626' : '#e5e7eb'; ?>; border-radius: 8px; font-size: 14px;"
                        >
                        <?php if (isset($errors['fich_fecha_fin_lectiva'])): ?>
                            <p style="color: #DC2626; font-size: 12px; margin: 4px 0 0;"><?php echo $errors['fich_fecha_fin_lectiva']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="<?php echo BASE_PATH; ?>ficha/index" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                        Guardar Ficha
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>

<?php // Footer incluido por BaseController ?>
