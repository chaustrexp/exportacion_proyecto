<?php
/**
 * Componente de Filtros Reutilizable
 * Uso: include 'views/components/filtros.php';
 */
?>
<style>
.filtros-container {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 20px;
    margin-bottom: 24px;
}

.filtros-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.filtros-header h3 {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.filtros-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.filtro-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filtro-group label {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
}

.filtro-group input,
.filtro-group select {
    padding: 10px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s;
}

.filtro-group input:focus,
.filtro-group select:focus {
    outline: none;
    border-color: #39a900;
    box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.1);
}

.btn-limpiar-filtros {
    padding: 8px 16px;
    background: #f3f4f6;
    color: #6b7280;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-limpiar-filtros:hover {
    background: #e5e7eb;
    color: #1f2937;
}

.filtros-activos {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}

.filtro-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #e8f5e8;
    color: #39a900;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.filtro-tag button {
    background: none;
    border: none;
    color: #39a900;
    cursor: pointer;
    padding: 0;
    font-size: 16px;
    line-height: 1;
}

.filtro-tag button:hover {
    color: #2d8500;
}
</style>

<script>
// Función para filtrar tabla en tiempo real
function filtrarTabla(filtros, tablaId = 'tabla-datos') {
    const tabla = document.getElementById(tablaId);
    if (!tabla) return;
    
    const filas = tabla.querySelectorAll('tbody tr');
    let visibles = 0;
    
    filas.forEach(fila => {
        // Saltar fila de "no hay datos"
        if (fila.cells.length === 1 && fila.cells[0].colSpan > 1) {
            return;
        }
        
        let mostrar = true;
        
        // Aplicar cada filtro
        Object.keys(filtros).forEach(key => {
            const valor = filtros[key].toLowerCase().trim();
            if (valor === '' || valor === 'todos') return;
            
            const celda = fila.querySelector(`[data-filtro="${key}"]`);
            if (celda) {
                const textoCelda = celda.textContent.toLowerCase().trim();
                if (!textoCelda.includes(valor)) {
                    mostrar = false;
                }
            }
        });
        
        fila.style.display = mostrar ? '' : 'none';
        if (mostrar) visibles++;
    });
    
    // Mostrar mensaje si no hay resultados
    actualizarMensajeNoResultados(tabla, visibles);
}

function actualizarMensajeNoResultados(tabla, visibles) {
    let mensajeRow = tabla.querySelector('.no-resultados-filtro');
    
    if (visibles === 0) {
        if (!mensajeRow) {
            const tbody = tabla.querySelector('tbody');
            const colspan = tabla.querySelectorAll('thead th').length;
            mensajeRow = document.createElement('tr');
            mensajeRow.className = 'no-resultados-filtro';
            mensajeRow.innerHTML = `
                <td colspan="${colspan}" style="text-align: center; padding: 40px 20px; color: #6b7280;">
                    <div style="font-size: 48px; margin-bottom: 16px;">🔍</div>
                    <p style="margin: 0; font-size: 16px;">No se encontraron resultados con los filtros aplicados</p>
                </td>
            `;
            tbody.appendChild(mensajeRow);
        }
        mensajeRow.style.display = '';
    } else if (mensajeRow) {
        mensajeRow.style.display = 'none';
    }
}

function limpiarFiltros(formId) {
    const form = document.getElementById(formId);
    if (!form) return;
    
    form.reset();
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.value = '';
        if (input.tagName === 'SELECT') {
            input.selectedIndex = 0;
        }
    });
    
    // Disparar evento de cambio para actualizar la tabla
    inputs[0]?.dispatchEvent(new Event('input'));
    
    // Limpiar tags de filtros activos
    actualizarFiltrosActivos({}, formId);
}

function actualizarFiltrosActivos(filtros, formId) {
    const container = document.getElementById(`filtros-activos-${formId}`);
    if (!container) return;
    
    container.innerHTML = '';
    
    Object.keys(filtros).forEach(key => {
        if (filtros[key] && filtros[key] !== '' && filtros[key] !== 'todos') {
            const tag = document.createElement('div');
            tag.className = 'filtro-tag';
            tag.innerHTML = `
                <span>${key}: ${filtros[key]}</span>
                <button onclick="eliminarFiltro('${key}', '${formId}')" title="Eliminar filtro">×</button>
            `;
            container.appendChild(tag);
        }
    });
}

function eliminarFiltro(key, formId) {
    const form = document.getElementById(formId);
    if (!form) return;
    
    const input = form.querySelector(`[name="${key}"]`);
    if (input) {
        input.value = '';
        if (input.tagName === 'SELECT') {
            input.selectedIndex = 0;
        }
        input.dispatchEvent(new Event('input'));
    }
}
</script>
