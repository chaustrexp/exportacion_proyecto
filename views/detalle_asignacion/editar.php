<?php
// Vista de edición de detalle de asignación
// Los datos vienen del controlador: $registro, $asignaciones
?>

<div class="main-content">
    <div class="form-container">
        <h2>Editar Detalle de Asignación</h2>
        <form method="POST">
            <div class="form-group">
                <label>Asignación *</label>
                <select name="asignacion_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($asignaciones as $asignacion): ?>
                        <?php 
                        $asig_id = $asignacion['asig_id'] ?? $asignacion['ASIG_ID'] ?? '';
                        $ficha = $asignacion['ficha_numero'] ?? 'N/A';
                        $instructor = $asignacion['instructor_nombre'] ?? 'N/A';
                        $selected = (($registro['asignacion_asig_id'] ?? '') == $asig_id) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $asig_id; ?>" <?php echo $selected; ?>>
                            ID: <?php echo $asig_id; ?> - Ficha: <?php echo $ficha; ?> - Instructor: <?php echo $instructor; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Hora Inicio *</label>
                <input type="datetime-local" name="hora_inicio" class="form-control" 
                       value="<?php echo isset($registro['detasig_hora_ini']) ? date('Y-m-d\TH:i', strtotime($registro['detasig_hora_ini'])) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Hora Fin *</label>
                <input type="datetime-local" name="hora_fin" class="form-control" 
                       value="<?php echo isset($registro['detasig_hora_fin']) ? date('Y-m-d\TH:i', strtotime($registro['detasig_hora_fin'])) : ''; ?>" required>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="<?php echo BASE_PATH; ?>detalle_asignacion" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
