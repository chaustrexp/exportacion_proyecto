<?php
// Vista de index instructor
// Los datos vienen del controlador: $pageTitle, $registros, $totalInstructores, $mensaje
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Instructores</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona los instructores del centro de formación</p>
        </div>
        <a href="<?php echo BASE_PATH; ?>instructor/crear" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nuevo Instructor
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            ✓ <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error" style="margin: 24px 32px;">
            ✗ <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            ✓ <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Instructores</div>
            <div style="font-size: 32px; font-weight: 700; color: #8b5cf6;"><?php echo $totalInstructores ?? count($registros ?? []); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Activos</div>
            <div style="font-size: 32px; font-weight: 700; color: #3b82f6;">
                <?php echo $totalInstructores ?? count($registros ?? []); ?>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Nombre Completo</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Email</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Teléfono</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Centro</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 250px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">👨‍🏫</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay instructores registrados</p>
                            <a href="<?php echo BASE_PATH; ?>instructor/crear" class="btn btn-primary btn-sm">Crear Primer Instructor</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;">
                                    <?php echo htmlspecialchars(($registro['inst_nombres'] ?? '') . ' ' . ($registro['inst_apellidos'] ?? '')); ?>
                                </div>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo htmlspecialchars($registro['inst_correo'] ?? ''); ?>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo htmlspecialchars($registro['inst_telefono'] ?? 'N/A'); ?>
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: #F5F3FF; color: #8b5cf6; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                    <?php echo htmlspecialchars($registro['cent_nombre'] ?? 'Sin centro'); ?>
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="<?php echo BASE_PATH; ?>instructor/ver?id=<?php echo $registro['inst_id']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="<?php echo BASE_PATH; ?>instructor/editar?id=<?php echo $registro['inst_id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion(<?php echo $registro['inst_id']; ?>)" class="btn btn-danger btn-sm">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    document.querySelectorAll('tbody tr').forEach(row => {
        if (row.cells.length > 1) {
            row.addEventListener('mouseenter', function() {
                this.style.background = '#f9fafb';
            });
            row.addEventListener('mouseleave', function() {
                this.style.background = 'white';
            });
        }
    });
    
    function confirmarEliminacion(id) {
        if (confirm('¿Está seguro de eliminar este instructor?')) {
            window.location.href = `<?php echo BASE_PATH; ?>instructor/eliminar?id=${id}`;
        }
    }
</script>

