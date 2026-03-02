<?php
// Vista de listado de fichas
// Los datos vienen del controlador: $pageTitle, $registros, $totalFichas, $fichasActivas
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Fichas de Formación</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona las fichas de los programas</p>
        </div>
        <a href="<?php echo BASE_PATH; ?>ficha/create" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nueva Ficha
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

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Fichas</div>
            <div style="font-size: 32px; font-weight: 700; color: #3b82f6;"><?php echo $totalFichas ?? count($registros); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Fichas Activas</div>
            <div style="font-size: 32px; font-weight: 700; color: #39A900;">
                <?php echo $fichasActivas ?? 0; ?>
            </div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Fichas Finalizadas</div>
            <div style="font-size: 32px; font-weight: 700; color: #6b7280;">
                <?php echo ($totalFichas ?? 0) - ($fichasActivas ?? 0); ?>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Número Ficha</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Programa</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Jornada</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Fecha Inicio</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Fecha Fin</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Estado</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">📄</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay fichas registradas</p>
                            <a href="<?php echo BASE_PATH; ?>ficha/create" class="btn btn-primary btn-sm">Crear Primera Ficha</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php 
                        $hoy = date('Y-m-d');
                        foreach ($registros as $registro): 
                            // Determinar estado
                            $estado = 'Pendiente';
                            $estadoColor = '#f59e0b';
                            $estadoBg = '#FEF3C7';
                            
                            if ($registro['fich_fecha_ini_lectiva'] && $registro['fich_fecha_fin_lectiva']) {
                                if ($registro['fich_fecha_ini_lectiva'] <= $hoy && $registro['fich_fecha_fin_lectiva'] >= $hoy) {
                                    $estado = 'Activa';
                                    $estadoColor = '#39A900';
                                    $estadoBg = '#E8F5E8';
                                } elseif ($registro['fich_fecha_fin_lectiva'] < $hoy) {
                                    $estado = 'Finalizada';
                                    $estadoColor = '#6b7280';
                                    $estadoBg = '#f3f4f6';
                                }
                            }
                        ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <strong style="color: #3b82f6; font-size: 16px;">
                                    <?php echo htmlspecialchars(str_pad($registro['fich_numero'] ?? $registro['fich_id'], 8, '0', STR_PAD_LEFT)); ?>
                                </strong>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['prog_denominacion'] ?? 'Sin programa'); ?></div>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo htmlspecialchars($registro['fich_jornada'] ?? 'No especificada'); ?>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo $registro['fich_fecha_ini_lectiva'] ? date('d/m/Y', strtotime($registro['fich_fecha_ini_lectiva'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo $registro['fich_fecha_fin_lectiva'] ? date('d/m/Y', strtotime($registro['fich_fecha_fin_lectiva'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 16px;">
                                <span style="background: <?php echo $estadoBg; ?>; color: <?php echo $estadoColor; ?>; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                    <?php echo $estado; ?>
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="<?php echo BASE_PATH; ?>ficha/show/<?php echo $registro['fich_id']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="<?php echo BASE_PATH; ?>ficha/edit/<?php echo $registro['fich_id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion(<?php echo $registro['fich_id']; ?>, 'ficha')" class="btn btn-danger btn-sm">Eliminar</button>
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
    
    // Función para confirmar eliminación
    function confirmarEliminacion(id, tipo) {
        if (confirm(`¿Está seguro de eliminar esta ${tipo}?`)) {
            window.location.href = window.BASE_PATH + `ficha/delete/${id}`;
        }
    }
</script>
