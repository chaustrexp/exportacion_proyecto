<?php
// Esta vista es renderizada por el controlador
$registro = $data['registro'] ?? null;
$centros = $data['centros'] ?? [];
?>

<div class="main-content">
    <div style="max-width: 800px; margin: 0 auto; padding: 32px;">
        <!-- Header -->
        <div style="margin-bottom: 32px;">
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 8px;">Editar Coordinación</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Actualiza la información de la coordinación</p>
        </div>

        <!-- Alert de Error -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" style="margin-bottom: 24px;">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 32px;">
            <form method="POST" action="<?php echo BASE_PATH; ?>coordinacion/editar/<?php echo $registro['coord_id']; ?>">
                <input type="hidden" name="_action" value="update">
                
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        ID de la Coordinación
                    </label>
                    <input 
                        type="text" 
                        value="<?php echo htmlspecialchars($registro['coord_id']); ?>" 
                        disabled
                        style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: #f9fafb; color: #6b7280;"
                    >
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Nombre de la Coordinación <span style="color: #ef4444;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="coord_nombre" 
                        class="form-control" 
                        value="<?php echo htmlspecialchars($registro['coord_nombre']); ?>"
                        required
                        style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;"
                    >
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Centro de Formación <span style="color: #ef4444;">*</span>
                    </label>
                    <select 
                        name="centro_formacion_cent_id" 
                        class="form-control" 
                        required
                        style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;"
                    >
                        <option value="">Seleccione un centro</option>
                        <?php foreach ($centros as $centro): ?>
                            <option value="<?php echo $centro['cent_id']; ?>" 
                                <?php echo ($registro['centro_formacion_cent_id'] == $centro['cent_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($centro['cent_nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <a href="<?php echo BASE_PATH; ?>coordinacion/index" class="btn btn-secondary">
                        <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                        Actualizar Coordinación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
