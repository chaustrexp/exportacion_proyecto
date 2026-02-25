<?php
// Vista manejada por el controlador
// $asignaciones ya están disponibles
?>

<div class="main-content">
    <div class="form-container">
        <h2>Crear Nuevo Detalle de Asignación</h2>
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
                        ?>
                        <option value="<?php echo $asig_id; ?>">
                            ID: <?php echo $asig_id; ?> - Ficha: <?php echo $ficha; ?> - Instructor: <?php echo $instructor; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Hora Inicio *</label>
                <input type="datetime-local" name="hora_inicio" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Hora Fin *</label>
                <input type="datetime-local" name="hora_fin" class="form-control" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php // Footer incluido por BaseController ?>
