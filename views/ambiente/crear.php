<?php
// Vista manejada por el controlador
?>

<div class="main-content">
    <div class="form-container">
        <h2>Crear Nuevo Ambiente</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php 
                echo htmlspecialchars($_SESSION['error']); 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo BASE_PATH; ?>ambiente/crear">
            <div class="form-group">
                <label>Código del Ambiente * (Ej: A101, B205)</label>
                <input type="text" 
                       name="codigo" 
                       class="form-control" 
                       maxlength="5" 
                       placeholder="A101" 
                       value="<?php echo isset($_SESSION['old_input']['codigo']) ? htmlspecialchars($_SESSION['old_input']['codigo']) : ''; ?>"
                       required>
                <small style="color: #6b7280;">Máximo 5 caracteres</small>
            </div>
            
            <div class="form-group">
                <label>Nombre del Ambiente *</label>
                <input type="text" 
                       name="nombre" 
                       class="form-control" 
                       maxlength="45" 
                       value="<?php echo isset($_SESSION['old_input']['nombre']) ? htmlspecialchars($_SESSION['old_input']['nombre']) : ''; ?>"
                       required>
            </div>
            
            <div class="form-group">
                <label>Sede *</label>
                <select name="sede_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php if (isset($sedes) && is_array($sedes)): ?>
                        <?php foreach ($sedes as $sede): ?>
                            <option value="<?php echo htmlspecialchars($sede['sede_id'] ?? ''); ?>"
                                    <?php echo (isset($_SESSION['old_input']['sede_id']) && $_SESSION['old_input']['sede_id'] == $sede['sede_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($sede['sede_nombre'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="<?php echo BASE_PATH; ?>ambiente/index" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php 
// Limpiar old_input después de mostrar
if (isset($_SESSION['old_input'])) {
    unset($_SESSION['old_input']);
}
// Footer incluido por BaseController
?>
