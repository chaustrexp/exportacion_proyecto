<?php
// Vista de listado de programas
// Los datos vienen del controlador: $pageTitle, $registros
?>

<div class="main-content">
    <!-- Header Elegante pero Simple -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Programas de Formación</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona los programas académicos del SENA</p>
        </div>
        <a href="<?php echo BASE_PATH; ?>programa/create" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nuevo Programa
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" style="margin: 24px 32px;">
            ✓ <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error" style="margin: 24px 32px;">
            ✗ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Stats Minimalistas (solo 2 cards) -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Programas</div>
            <div style="font-size: 32px; font-weight: 700; color: #39A900;"><?php echo count($registros); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Programas Activos</div>
            <div style="font-size: 32px; font-weight: 700; color: #3b82f6;">
                <?php echo count($registros); ?> <span style="font-size: 16px; color: #6b7280;">programas</span>
            </div>
        </div>
    </div>

    <!-- Table Limpia -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Código</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Nombre del Programa</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Tipo</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Título</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">📚</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay programas registrados</p>
                            <a href="<?php echo BASE_PATH; ?>programa/create" class="btn btn-primary btn-sm">Crear Primer Programa</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;">
                            <td style="padding: 16px;">
                                <strong style="color: #39A900; font-size: 14px;"><?php echo $registro['prog_codigo']; ?></strong>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['prog_denominacion']); ?></div>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo htmlspecialchars($registro['prog_tipo'] ?? 'No especificado'); ?>
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                    <?php echo htmlspecialchars($registro['titpro_nombre'] ?? 'Sin título'); ?>
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="<?php echo BASE_PATH; ?>programa/show/<?php echo $registro['prog_codigo']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="<?php echo BASE_PATH; ?>programa/edit/<?php echo $registro['prog_codigo']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion(<?php echo $registro['prog_codigo']; ?>, 'programa')" class="btn btn-danger btn-sm">Eliminar</button>
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
    
    // Hover effect en filas
    document.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.background = '#f9fafb';
        });
        row.addEventListener('mouseleave', function() {
            this.style.background = 'white';
        });
    });
    
    // Función para confirmar eliminación
    function confirmarEliminacion(id, tipo) {
        if (confirm(`¿Está seguro de eliminar este ${tipo}?`)) {
            window.location.href = `<?php echo BASE_PATH; ?>programa/delete/${id}`;
        }
    }
</script>
