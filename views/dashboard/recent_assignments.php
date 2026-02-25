<div style="padding: 0 32px 32px;">
    <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
        
        <!-- Header de la tabla -->
        <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <?php 
                $esInstructor = (($_SESSION['usuario_rol'] ?? $_SESSION['rol'] ?? '') === 'Instructor');
                ?>
                <h2 style="font-size: 18px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">
                    <?php echo $esInstructor ? 'Asignaciones' : 'Últimas Asignaciones'; ?>
                </h2>
                <p style="font-size: 13px; color: #6b7280; margin: 0;">
                    <?php echo $esInstructor ? 'Listado de tus asignaciones' : 'Asignaciones recientes del sistema'; ?>
                </p>
            </div>
            <a href="<?php echo BASE_PATH . ($esInstructor ? 'instructor_dashboard/misAsignaciones' : 'asignacion/index'); ?>" class="btn btn-secondary btn-sm">
                Ver todas
            </a>
        </div>

        <!-- Tabla -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Ficha</th>
                        <?php if (!$esInstructor): ?>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Instructor</th>
                        <?php else: ?>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Competencia</th>
                        <?php endif; ?>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Ambiente</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Fecha Inicio</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Fecha Fin</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Estado</th>
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
                        <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s;" class="table-row">
                            <td style="padding: 16px 24px;">
                                <strong style="color: #1f2937;"><?php echo safeHtml($asignacion, 'ficha_numero'); ?></strong>
                            </td>
                            <td style="padding: 16px 24px; color: #6b7280;">
                                <?php if (!$esInstructor): ?>
                                    <?php echo safeHtml($asignacion, 'instructor_nombre'); ?>
                                <?php else: ?>
                                    <span title="<?php echo safeHtml($asignacion, 'competencia_nombre'); ?>">
                                        <?php echo safeHtml($asignacion, 'competencia_nombre'); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px 24px; color: #6b7280;">
                                <?php echo safeHtml($asignacion, 'ambiente_nombre'); ?>
                            </td>
                            <td style="padding: 16px 24px; color: #6b7280;">
                                <?php echo isset($asignacion['fecha_inicio']) ? date('d/m/Y', strtotime($asignacion['fecha_inicio'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 16px 24px; color: #6b7280;">
                                <?php echo isset($asignacion['fecha_fin']) ? date('d/m/Y', strtotime($asignacion['fecha_fin'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 16px 24px;">
                                <?php 
                                $hoy = date('Y-m-d');
                                $fecha_inicio = $asignacion['fecha_inicio'] ?? '';
                                $fecha_fin = $asignacion['fecha_fin'] ?? '';
                                
                                if ($fecha_fin && $fecha_fin < $hoy) {
                                    echo '<span style="background: #FEE2E2; color: #DC2626; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Finalizada</span>';
                                } elseif ($fecha_inicio && $fecha_inicio > $hoy) {
                                    echo '<span style="background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Pendiente</span>';
                                } else {
                                    echo '<span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Activa</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
