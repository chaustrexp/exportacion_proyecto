<?php
// Vista manejada por el controlador
// $registro, $vigente, etc. ya están disponibles
?>

<div class="main-content">
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Detalle de Competencia</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Información completa de la competencia asignada</p>
        </div>
        <div class="btn-group">
            <a href="editar.php?id=<?php echo safeHtml($registro, 'inscomp_id'); ?>" class="btn btn-primary">
                <i data-lucide="edit" style="width: 18px; height: 18px;"></i>
                Editar
            </a>
            <a href="index.php" class="btn btn-secondary">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                Volver
            </a>
        </div>
    </div>

    <div style="padding: 32px;">
        <!-- Estado Card -->
        <div style="background: <?php echo $vigente ? '#E8F5E8' : '#FEE2E2'; ?>; padding: 20px; border-radius: 12px; margin-bottom: 24px; border-left: 5px solid <?php echo $vigente ? '#39A900' : '#DC2626'; ?>;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="font-size: 32px;"><?php echo $vigente ? '✓' : '⚠️'; ?></div>
                <div>
                    <div style="font-size: 18px; font-weight: 700; color: <?php echo $vigente ? '#39A900' : '#DC2626'; ?>; margin-bottom: 4px;">
                        <?php echo $vigente ? 'Competencia Vigente' : 'Competencia Vencida'; ?>
                    </div>
                    <div style="font-size: 14px; color: #6b7280;">
                        <?php 
                        if ($vigente) {
                            $dias = (strtotime($vigencia) - strtotime($hoy)) / 86400;
                            echo "Válida por " . ceil($dias) . " días más";
                        } else {
                            $dias = (strtotime($hoy) - strtotime($vigencia)) / 86400;
                            echo "Vencida hace " . ceil($dias) . " días";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
            <!-- Instructor Card -->
            <div style="background: white; padding: 28px; border-radius: 12px; border: 1px solid #e5e7eb;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="user" style="width: 24px; height: 24px; color: white;"></i>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Instructor</div>
                        <div style="font-size: 20px; font-weight: 700; color: #1f2937;"><?php echo safeHtml($registro, 'instructor_nombre'); ?></div>
                    </div>
                </div>
            </div>

            <!-- Vigencia Card -->
            <div style="background: white; padding: 28px; border-radius: 12px; border: 1px solid #e5e7eb;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="calendar" style="width: 24px; height: 24px; color: white;"></i>
                    </div>
                    <div>
                        <div style="font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Vigencia</div>
                        <div style="font-size: 20px; font-weight: 700; color: #1f2937;">
                            <?php echo e(date('d/m/Y', strtotime($vigencia))); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programa y Competencia -->
        <div style="background: white; padding: 32px; border-radius: 12px; border: 1px solid #e5e7eb; margin-top: 24px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb;">
                Información de la Competencia
            </h3>

            <div style="display: grid; gap: 20px;">
                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 16px; padding: 16px 0; border-bottom: 1px solid #f3f4f6;">
                    <div style="font-weight: 700; color: #6b7280; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                        Programa
                    </div>
                    <div style="color: #1f2937; font-weight: 600; font-size: 15px;">
                        <?php echo safeHtml($registro, 'prog_denominacion'); ?>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 16px; padding: 16px 0; border-bottom: 1px solid #f3f4f6;">
                    <div style="font-weight: 700; color: #6b7280; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                        Código Competencia
                    </div>
                    <div style="color: #1f2937; font-weight: 600; font-size: 15px;">
                        <span style="background: #f3f4f6; padding: 4px 12px; border-radius: 6px; color: #8b5cf6; font-weight: 700;">
                            <?php echo safeHtml($registro, 'comp_nombre_corto'); ?>
                        </span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 16px; padding: 16px 0;">
                    <div style="font-weight: 700; color: #6b7280; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                        Unidad de Competencia
                    </div>
                    <div style="color: #1f2937; font-weight: 500; font-size: 15px; line-height: 1.6;">
                        <?php echo safeHtml($registro, 'comp_nombre_unidad_competencia'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
            <div class="btn-group">
                <a href="editar.php?id=<?php echo safeHtml($registro, 'inscomp_id'); ?>" class="btn btn-primary">
                    <i data-lucide="edit" style="width: 18px; height: 18px;"></i>
                    Editar
                </a>
                <button onclick="confirmarEliminacion(<?php echo safeHtml($registro, 'inscomp_id'); ?>, 'competencia de instructor')" class="btn btn-danger">
                    <i data-lucide="trash-2" style="width: 18px; height: 18px;"></i>
                    Eliminar
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                    Volver al Listado
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>

<?php // Footer incluido por BaseController ?>
