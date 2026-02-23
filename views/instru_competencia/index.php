<?php
// Vista de index instru_competencia
// Los datos vienen del controlador: $pageTitle, $registros, $instructores, $competenciasPorPrograma, etc.
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Competencias de Instructores</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona las competencias asignadas a cada instructor</p>
        </div>
        <a href="<?php echo BASE_PATH; ?>instru_competencia/crear" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nueva Asignación
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
    
    <?php if (empty($competenciasPorPrograma ?? [])): ?>
        <div style="margin: 24px 32px; padding: 16px; background: #FEF3C7; border-left: 4px solid #F59E0B; border-radius: 8px; color: #92400E;">
            <strong>⚠️ Configuración Requerida:</strong> No hay competencias asociadas a programas. 
            Primero debes crear asociaciones en la sección 
            <a href="<?php echo BASE_PATH; ?>competencia_programa/index" style="color: #39A900; font-weight: 600;">Competencias por Programa</a>.
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Asignaciones</div>
            <div style="font-size: 32px; font-weight: 700; color: #8b5cf6;"><?php echo $totalAsignaciones ?? count($registros ?? []); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Vigentes</div>
            <div style="font-size: 32px; font-weight: 700; color: #10b981;">
                <?php echo $totalVigentes ?? 0; ?>
            </div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Vencidas</div>
            <div style="font-size: 32px; font-weight: 700; color: #ef4444;">
                <?php echo $totalVencidas ?? 0; ?>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Instructor</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Programa</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Competencia</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Vigencia</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Estado</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 250px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">🎯</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay competencias asignadas</p>
                            <a href="<?php echo BASE_PATH; ?>instru_competencia/crear" class="btn btn-primary btn-sm">Crear Primera Asignación</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <?php 
                        $hoy = date('Y-m-d');
                        $esVigente = ($registro['inscomp_vigencia'] ?? '') >= $hoy;
                        ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; color: #1f2937;"><?php echo htmlspecialchars($registro['instructor_nombre'] ?? 'N/A'); ?></div>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo htmlspecialchars($registro['prog_denominacion'] ?? 'N/A'); ?>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <strong style="color: #8b5cf6;"><?php echo htmlspecialchars($registro['comp_nombre_corto'] ?? 'N/A'); ?></strong>
                            </td>
                            <td style="padding: 16px; color: #6b7280;">
                                <?php echo isset($registro['inscomp_vigencia']) ? date('d/m/Y', strtotime($registro['inscomp_vigencia'])) : 'N/A'; ?>
                            </td>
                            <td style="padding: 16px;">
                                <?php if ($esVigente): ?>
                                    <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Vigente</span>
                                <?php else: ?>
                                    <span style="background: #FEE2E2; color: #DC2626; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">Vencida</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="<?php echo BASE_PATH; ?>instru_competencia/ver?id=<?php echo $registro['inscomp_id']; ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="<?php echo BASE_PATH; ?>instru_competencia/editar?id=<?php echo $registro['inscomp_id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion(<?php echo $registro['inscomp_id']; ?>)" class="btn btn-danger btn-sm">Eliminar</button>
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
        if (confirm('¿Está seguro de eliminar esta asignación de competencia?')) {
            window.location.href = `<?php echo BASE_PATH; ?>instru_competencia/eliminar?id=${id}`;
        }
    }
</script>
