<?php
// Vista de index competencias
// Los datos vienen del controlador: $pageTitle, $registros, $mensaje
?>

<div class="main-content">
    <!-- Header -->
    <div style="padding: 32px 32px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #1f2937; margin: 0 0 4px;">Competencias</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Gestiona las competencias de formación</p>
        </div>
        <a href="<?php echo BASE_PATH; ?>competencia/crear" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <i data-lucide="plus" style="width: 18px; height: 18px;"></i>
            Nueva Competencia
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

    <!-- Filtros -->
    <div style="padding: 0 32px 24px;">
        <?php include __DIR__ . '/../components/filtros.php'; ?>
        
        <div class="filtros-container">
            <div class="filtros-header">
                <h3>
                    <i data-lucide="filter" style="width: 18px; height: 18px;"></i>
                    Filtros
                </h3>
                <button onclick="limpiarFiltros('form-filtros-competencia')" class="btn-limpiar-filtros">
                    Limpiar Filtros
                </button>
            </div>
            
            <form id="form-filtros-competencia">
                <div class="filtros-grid">
                    <div class="filtro-group">
                        <label for="filtro-nombre-corto">Nombre Corto</label>
                        <input type="text" id="filtro-nombre-corto" name="nombre_corto" placeholder="Buscar por código..." />
                    </div>
                    
                    <div class="filtro-group">
                        <label for="filtro-unidad">Unidad de Competencia</label>
                        <input type="text" id="filtro-unidad" name="unidad" placeholder="Buscar por nombre..." />
                    </div>
                    
                    <div class="filtro-group">
                        <label for="filtro-horas-min">Horas Mínimas</label>
                        <input type="number" id="filtro-horas-min" name="horas_min" placeholder="0" min="0" />
                    </div>
                    
                    <div class="filtro-group">
                        <label for="filtro-horas-max">Horas Máximas</label>
                        <input type="number" id="filtro-horas-max" name="horas_max" placeholder="1000" min="0" />
                    </div>
                </div>
                
                <div id="filtros-activos-form-filtros-competencia" class="filtros-activos"></div>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; padding: 24px 32px;">
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Total Competencias</div>
            <div style="font-size: 32px; font-weight: 700; color: #10b981;"><?php echo count($registros ?? []); ?></div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
            <div style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">Registradas</div>
            <div style="font-size: 32px; font-weight: 700; color: #3b82f6;"><?php echo count($registros ?? []); ?></div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0 32px 32px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden;">
            <table id="tabla-datos" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 150px;">Código</th>
                        <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Unidad de Competencia</th>
                        <th style="padding: 16px; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 100px;">Horas</th>
                        <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase; width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <div style="font-size: 48px; margin-bottom: 16px;">🎯</div>
                            <p style="margin: 0 0 16px; font-size: 16px;">No hay competencias registradas</p>
                            <a href="<?php echo BASE_PATH; ?>competencia/crear" class="btn btn-primary btn-sm">Crear Primera Competencia</a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $registro): ?>
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 16px;" data-filtro="nombre_corto">
                                <strong style="color: #10b981; font-size: 14px;"><?php echo htmlspecialchars($registro['comp_nombre_corto'] ?? ''); ?></strong>
                            </td>
                            <td style="padding: 16px;" data-filtro="unidad">
                                <div style="font-weight: 600; color: #1f2937;">
                                    <?php 
                                    $unidad = $registro['comp_nombre_unidad_competencia'] ?? '';
                                    echo strlen($unidad) > 80 ? htmlspecialchars(substr($unidad, 0, 80)) . '...' : htmlspecialchars($unidad); 
                                    ?>
                                </div>
                            </td>
                            <td style="padding: 16px; text-align: center;" data-filtro="horas" data-horas="<?php echo htmlspecialchars($registro['comp_horas'] ?? '0'); ?>">
                                <span style="background: #E8F5E8; color: #39A900; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                    <?php echo htmlspecialchars($registro['comp_horas'] ?? '0'); ?> h
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div class="btn-group" style="justify-content: flex-end;">
                                    <a href="<?php echo BASE_PATH; ?>competencia/ver/<?php echo htmlspecialchars($registro['comp_id'] ?? ''); ?>" class="btn btn-secondary btn-sm">Ver</a>
                                    <a href="<?php echo BASE_PATH; ?>competencia/editar/<?php echo htmlspecialchars($registro['comp_id'] ?? ''); ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <button onclick="confirmarEliminacion('<?php echo htmlspecialchars($registro['comp_id'] ?? ''); ?>', 'competencia')" class="btn btn-danger btn-sm">Eliminar</button>
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
    
    function confirmarEliminacion(id, tipo) {
        if (confirm(`¿Está seguro de eliminar esta ${tipo}?`)) {
            window.location.href = `<?php echo BASE_PATH; ?>competencia/eliminar/${id}`;
        }
    }
    
    // Filtros en tiempo real con rango de horas
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('form-filtros-competencia');
        const inputs = form.querySelectorAll('input, select');
        
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                aplicarFiltros();
            });
        });
    });
    
    function aplicarFiltros() {
        const nombreCorto = document.getElementById('filtro-nombre-corto').value.toLowerCase().trim();
        const unidad = document.getElementById('filtro-unidad').value.toLowerCase().trim();
        const horasMin = document.getElementById('filtro-horas-min').value;
        const horasMax = document.getElementById('filtro-horas-max').value;
        
        const tabla = document.getElementById('tabla-datos');
        const filas = tabla.querySelectorAll('tbody tr');
        let visibles = 0;
        
        filas.forEach(fila => {
            if (fila.cells.length === 1 && fila.cells[0].colSpan > 1) return;
            
            let mostrar = true;
            
            // Filtro por nombre corto
            if (nombreCorto) {
                const celda = fila.querySelector('[data-filtro="nombre_corto"]');
                if (celda && !celda.textContent.toLowerCase().includes(nombreCorto)) {
                    mostrar = false;
                }
            }
            
            // Filtro por unidad
            if (unidad) {
                const celda = fila.querySelector('[data-filtro="unidad"]');
                if (celda && !celda.textContent.toLowerCase().includes(unidad)) {
                    mostrar = false;
                }
            }
            
            // Filtro por rango de horas
            if (horasMin || horasMax) {
                const celda = fila.querySelector('[data-filtro="horas"]');
                if (celda) {
                    const horas = parseInt(celda.dataset.horas);
                    if (horasMin && horas < parseInt(horasMin)) mostrar = false;
                    if (horasMax && horas > parseInt(horasMax)) mostrar = false;
                }
            }
            
            fila.style.display = mostrar ? '' : 'none';
            if (mostrar) visibles++;
        });
        
        // Actualizar mensaje de no resultados
        actualizarMensajeNoResultados(tabla, visibles);
        
        // Actualizar filtros activos
        const filtros = {};
        if (nombreCorto) filtros['Nombre Corto'] = nombreCorto;
        if (unidad) filtros['Unidad'] = unidad;
        if (horasMin) filtros['Horas Min'] = horasMin;
        if (horasMax) filtros['Horas Max'] = horasMax;
        actualizarFiltrosActivos(filtros, 'form-filtros-competencia');
    }
</script>
