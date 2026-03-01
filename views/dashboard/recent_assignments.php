<div style="padding: 0 32px 32px;">
    <div style="background: white; border-radius: 20px; border: 1px solid #e5e7eb; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        
        <!-- Header de la tabla -->
        <div style="padding: 24px 32px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="layout-list" style="width: 20px; height: 20px; color: #374151;"></i>
                </div>
                <div>
                    <?php 
                    $esInstructor = (($_SESSION['usuario_rol'] ?? $_SESSION['rol'] ?? '') === 'Instructor');
                    ?>
                    <h2 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0;">
                        <?php echo $esInstructor ? 'Seguimiento de Asignaciones' : 'Seguimiento de Asignaciones'; ?>
                    </h2>
                    <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0;">
                        Últimas actividades registradas en el sistema
                    </p>
                </div>
            </div>
            <a href="<?php echo BASE_PATH . ($esInstructor ? 'instructor_dashboard/misAsignaciones' : 'asignacion/index'); ?>" style="font-size: 14px; font-weight: 600; color: #39A900; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                Ver todas <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
            </a>
        </div>

        <!-- Tabla -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #39A900;">
                        <th style="padding: 16px 32px; text-align: left; font-size: 11px; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.5px;">Ficha</th>
                        <?php if (!$esInstructor): ?>
                        <th style="padding: 16px 32px; text-align: left; font-size: 11px; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.5px;">Instructor</th>
                        <?php endif; ?>
                        <th style="padding: 16px 32px; text-align: left; font-size: 11px; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.5px;">Ambiente</th>
                        <th style="padding: 16px 32px; text-align: left; font-size: 11px; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.5px;">Inicio</th>
                        <th style="padding: 16px 32px; text-align: left; font-size: 11px; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.5px;">Fin</th>
                        <th style="padding: 16px 32px; text-align: right; font-size: 11px; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 0.5px;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ultimasAsignaciones)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">📋</div>
                            <p style="margin: 0; font-size: 16px;">No hay asignaciones registradas</p>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($ultimasAsignaciones as $asignacion): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;">
                            <td style="padding: 16px 32px;">
                                <strong style="color: #1f2937; font-size: 14px;"><?php echo safeHtml($asignacion, 'ficha_numero'); ?></strong>
                            </td>
                            <?php if (!$esInstructor): ?>
                            <td style="padding: 16px 32px; color: #6b7280; font-size: 14px; font-weight: 500;">
                                <?php echo safeHtml($asignacion, 'instructor_nombre'); ?>
                            </td>
                            <?php endif; ?>
                            <td style="padding: 16px 32px; color: #6b7280; font-size: 14px; font-weight: 500;">
                                <?php echo safeHtml($asignacion, 'ambiente_nombre'); ?>
                            </td>
                            <td style="padding: 16px 32px; color: #6b7280; font-size: 14px; font-weight: 500;">
                                <?php echo isset($asignacion['fecha_inicio']) ? date('d/m/Y', strtotime($asignacion['fecha_inicio'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 16px 32px; color: #6b7280; font-size: 14px; font-weight: 500;">
                                <?php echo isset($asignacion['fecha_fin']) ? date('d/m/Y', strtotime($asignacion['fecha_fin'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 16px 32px; text-align: right;">
                                <?php 
                                $hoy = date('Y-m-d');
                                $fecha_inicio = $asignacion['fecha_inicio'] ?? '';
                                $fecha_fin = $asignacion['fecha_fin'] ?? '';
                                
                                if ($fecha_fin && $fecha_fin < $hoy) {
                                    echo '<span style="background: #FEE2E2; color: #b91c1c; padding: 6px 16px; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Finalizada</span>';
                                } elseif ($fecha_inicio && $fecha_inicio > $hoy) {
                                    echo '<span style="background: #FEF3C7; color: #b45309; padding: 6px 16px; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Pendiente</span>';
                                } else {
                                    echo '<span style="background: #DCFCE7; color: #15803d; padding: 6px 16px; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Activa</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pie de tabla: Cargar más -->
        <div style="padding: 16px; border-top: 1px solid #f3f4f6; display: flex; justify-content: center; background: #fafafa;">
            <button style="background: none; border: none; font-size: 13px; font-weight: 600; color: #667085; display: flex; align-items: center; gap: 6px; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#1f2937'" onmouseout="this.style.color='#667085'">
                Cargar más resultados <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
            </button>
        </div>
    </div>
</div>
