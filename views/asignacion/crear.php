<?php
/**
 * Vista: Crear Nueva Asignación
 * Incluye validaciones en tiempo real CU-01/02/03 para el rol Coordinador.
 *
 * Datos disponibles: $fichas, $instructores, $ambientes, $competencias
 */

$old = $_SESSION['old_input'] ?? [];
unset($_SESSION['old_input']);
$errorMsg   = $_SESSION['error']   ?? '';   unset($_SESSION['error']);
$warningMsg = $_SESSION['warning'] ?? '';   unset($_SESSION['warning']);
$errors     = $_SESSION['errors']  ?? [];   unset($_SESSION['errors']);
?>

<div class="main-content" style="padding: 24px;">
    <?php if ($errorMsg): ?>
        <div class="alert alert-error" style="margin-bottom: 20px;">
            ❌ <?= htmlspecialchars($errorMsg) ?>
        </div>
    <?php endif; ?>
    <?php if ($warningMsg): ?>
        <div class="alert alert-warning" style="margin-bottom: 20px;">
            ⚠️ <?= htmlspecialchars($warningMsg) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error" style="margin-bottom: 20px;">
            ❌
            <ul style="margin:0;padding-left:16px;">
                <?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-container" style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 32px; max-width: 800px; margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="margin-bottom: 24px; border-bottom: 1px solid #e5e7eb; padding-bottom: 16px;">
            <h2 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 8px;">Nueva Asignación</h2>
            <p style="color: #6b7280; font-size: 14px; margin: 0;">Complete los campos para asignar una competencia a un instructor.</p>
        </div>

        <form method="POST" id="asigForm" action="<?= BASE_PATH ?>asignacion/crear">
            <input type="hidden" name="instructor_inst_id" id="hidden_inst_id">

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="ficha_id" style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Ficha de Formación *</label>
                <select name="ficha_id" id="ficha_id" class="form-control" required onchange="onFichaChange(this.value)" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                    <option value="">— Seleccione una ficha —</option>
                    <?php foreach ($fichas as $f): ?>
                        <option value="<?= htmlspecialchars($f['fich_id']) ?>"
                                data-programa="<?= htmlspecialchars($f['prog_denominacion'] ?? '') ?>"
                                <?= ($old['ficha_id'] ?? '') == $f['fich_id'] ? 'selected' : '' ?>>
                            Ficha <?= str_pad(htmlspecialchars($f['fich_id']), 7, '0', STR_PAD_LEFT) ?>
                            — <?= htmlspecialchars($f['prog_denominacion'] ?? 'Sin programa') ?>
                            (<?= htmlspecialchars($f['fich_jornada'] ?? '') ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="ficha-info" style="font-size:12px;color:#6b7280;margin-top:6px;" hidden>
                    📚 Programa: <strong id="ficha-programa"></strong>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="competencia_id" style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Competencia a Asignar *</label>
                <select name="competencia_id" id="competencia_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                    <option value="">— Primero seleccione una ficha —</option>
                    <?php foreach ($competencias as $c): ?>
                        <option value="<?= htmlspecialchars($c['comp_id']) ?>"
                                <?= ($old['competencia_id'] ?? '') == $c['comp_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['comp_nombre_corto']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="comp-status" style="margin-top:8px;"></div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="instructor_id" style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Instructor *</label>
                <select name="instructor_id" id="instructor_id" class="form-control" required onchange="onInstructorChange(this)" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                    <option value="">— Seleccione un instructor —</option>
                    <?php foreach ($instructores as $i): ?>
                        <?php
                            $estado  = $i['inst_estado'] ?? 'Activo';
                            $activo  = $estado === 'Activo';
                        ?>
                        <option value="<?= htmlspecialchars($i['inst_id']) ?>"
                                data-estado="<?= htmlspecialchars($estado) ?>"
                                <?= ($old['instructor_id'] ?? '') == $i['inst_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($i['inst_nombres'] . ' ' . $i['inst_apellidos']) ?> (<?= htmlspecialchars($estado) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="inst-status" style="margin-top:8px;"></div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Fecha Inicio *</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required
                           value="<?= htmlspecialchars($old['fecha_inicio'] ?? '') ?>"
                           onchange="onFechaChange()" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Fecha Fin *</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required
                           value="<?= htmlspecialchars($old['fecha_fin'] ?? '') ?>"
                           onchange="onFechaChange()" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Hora Inicio</label>
                    <input type="time" name="hora_inicio" id="hora_inicio" class="form-control"
                           value="<?= htmlspecialchars($old['hora_inicio'] ?? '07:00') ?>"
                           onchange="onFechaChange()" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Hora Fin</label>
                    <input type="time" name="hora_fin" id="hora_fin" class="form-control"
                           value="<?= htmlspecialchars($old['hora_fin'] ?? '22:00') ?>"
                           onchange="onFechaChange()" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 28px;">
                <label for="ambiente_id" style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Ambiente de Formación</label>
                <select name="ambiente_id" id="ambiente_id" class="form-control" onchange="onAmbienteChange(this.value)" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                    <option value="">— Sin ambiente específico —</option>
                    <?php foreach ($ambientes as $a): ?>
                        <option value="<?= htmlspecialchars($a['amb_id']) ?>"
                                <?= ($old['ambiente_id'] ?? '') == $a['amb_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['amb_nombre']) ?>
                            <?php if (!empty($a['sede_nombre'])): ?>(<?= htmlspecialchars($a['sede_nombre']) ?>)<?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="amb-status" style="margin-top:8px;"></div>
            </div>

            <div class="btn-group" style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary" id="btnGuardar" style="padding: 10px 24px; background: #39A900; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Guardar Asignación
                </button>
                <a href="<?= BASE_PATH ?>asignacion/index" class="btn btn-secondary" style="padding: 10px 24px; background: #f3f4f6; color: #374151; text-decoration: none; border: 1px solid #d1d5db; border-radius: 8px; font-weight: 600;">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
const BASE_PATH = '<?= BASE_PATH ?>';
let instTimer = null, ambTimer = null;

/* ──────────────────────────────────────────────────────────────────────────
   CU-04 / CU-02: Al cambiar la ficha, cargar competencias pendientes
────────────────────────────────────────────────────────────────────────── */
function onFichaChange(fichaId) {
    const fichaSelect = document.getElementById('ficha_id');
    const opt       = fichaSelect.options[fichaSelect.selectedIndex];
    const programa  = opt?.dataset?.programa || '';
    const infoEl    = document.getElementById('ficha-info');
    const progEl    = document.getElementById('ficha-programa');
    const compSel   = document.getElementById('competencia_id');
    const compStatus = document.getElementById('comp-status');

    if (programa) { progEl.textContent = programa; infoEl.hidden = false; }
    else          { infoEl.hidden = true; }

    if (!fichaId) {
        compSel.innerHTML = '<option value="">— Primero seleccione una ficha —</option>';
        compStatus.innerHTML = '';
        return;
    }

    compStatus.innerHTML = '<span class="val-spinner"></span> Cargando competencias...';
    compSel.disabled = true;

    fetch(`${BASE_PATH}asignacion/getCompetenciasPendientes?ficha_id=${fichaId}`)
        .then(r => r.json())
        .then(data => {
            if (!data.ok) { compStatus.innerHTML = renderAlert('danger','❌',data.error||'Error al cargar competencias.'); return; }
            const items = data.competencias || [];
            compSel.innerHTML = '<option value="">— Seleccione competencia —</option>';
            items.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.comp_id;
                const tag = c.ya_asignada == 1
                    ? '<span class="pending-tag cubierta">Ya asignada</span>'
                    : '<span class="pending-tag pendiente">Pendiente</span>';
                opt.text = (c.ya_asignada == 1 ? '🔒 ' : '✅ ') + c.comp_nombre_corto + (c.comp_norma ? ' [Norma: ' + c.comp_norma + ']' : '');
                opt.dataset.asignada = c.ya_asignada;
                if (c.ya_asignada == 1) opt.style.color = '#9ca3af';
                compSel.appendChild(opt);
            });
            compSel.disabled = false;
            const pendientes = items.filter(c => c.ya_asignada == 0).length;
            const cubiertas  = items.filter(c => c.ya_asignada == 1).length;
            compStatus.innerHTML = renderAlert('success', '📚',
                `CU-02: ${pendientes} competencia(s) pendiente(s), ${cubiertas} ya asignada(s) para esta ficha.`);
        })
        .catch(() => compStatus.innerHTML = renderAlert('danger','❌','Error de conexión al cargar competencias.'))
        .finally(() => compSel.disabled = false);
}

/* ──────────────────────────────────────────────────────────────────────────
   CU-01: Al cambiar el instructor, validar estado y cruces
────────────────────────────────────────────────────────────────────────── */
function onInstructorChange(sel) {
    const instId  = sel.value;
    const estado  = sel.options[sel.selectedIndex]?.dataset?.estado || '';
    const statusEl = document.getElementById('inst-status');
    document.getElementById('hidden_inst_id').value = instId;

    if (!instId) { statusEl.innerHTML = ''; return; }

    // Feedback inmediato por estado en el dataset
    if (estado && estado !== 'Activo') {
        statusEl.innerHTML = renderAlert('danger','🔴',`CU-01: Este instructor está <strong>${estado}</strong> y no puede recibir asignaciones.`);
        document.getElementById('competencia_id').closest('.cu-card').querySelector('.cu-badge').style.background = '#ef4444';
        return;
    }

    validarInstructor();
}

function onFechaChange() {
    validarInstructor();
    onAmbienteChange(document.getElementById('ambiente_id').value);
}

function validarInstructor() {
    const instId     = document.getElementById('instructor_id').value;
    const statusEl   = document.getElementById('inst-status');
    if (!instId) return;

    const params = buildFechaParams();
    clearTimeout(instTimer);
    instTimer = setTimeout(() => {
        statusEl.innerHTML = '<span class="val-spinner"></span> Verificando CU-01...';
        fetch(`${BASE_PATH}asignacion/validarInstructor?instructor_id=${instId}&${params}`)
            .then(r => r.json())
            .then(data => {
                if (!data.activo) {
                    statusEl.innerHTML = renderAlert('danger','🔴','CU-01: ' + (data.mensaje || 'Instructor inactivo.'));
                } else if (data.cruces && data.cruces.length > 0) {
                    const c = data.cruces[0];
                    statusEl.innerHTML = renderAlert('warning','⚠️',
                        `CU-01: Cruce de horario detectado — Ficha ${c.ficha_numero||'?'}, `
                        + `${c.fecha_inicio||''} ${c.hora_inicio||''} – ${c.hora_fin||''}.`);
                } else {
                    statusEl.innerHTML = renderAlert('success','✅','CU-01: Instructor <strong>' + (data.nombre||'') + '</strong> disponible y activo.');
                }
            })
            .catch(() => statusEl.innerHTML = '');
    }, 500);
}

/* ──────────────────────────────────────────────────────────────────────────
   CU-03: Al cambiar el ambiente o fechas, verificar disponibilidad
────────────────────────────────────────────────────────────────────────── */
function onAmbienteChange(ambId) {
    const statusEl = document.getElementById('amb-status');
    if (!ambId) { statusEl.innerHTML = ''; return; }

    const params = buildFechaParams();
    clearTimeout(ambTimer);
    ambTimer = setTimeout(() => {
        statusEl.innerHTML = '<span class="val-spinner"></span> Verificando disponibilidad (CU-03)...';
        fetch(`${BASE_PATH}asignacion/checkAmbiente?ambiente_id=${encodeURIComponent(ambId)}&${params}`)
            .then(r => r.json())
            .then(data => {
                if (data.disponible) {
                    statusEl.innerHTML = renderAlert('success','✅','CU-03: Ambiente disponible en la franja seleccionada.');
                } else {
                    const c = data.conflictos ? data.conflictos[0] : null;
                    statusEl.innerHTML = renderAlert('danger','🔴',
                        `CU-03: ${data.mensaje}` +
                        (c ? ` (Instructor: ${c.instructor_nombre||'?'}, ${c.hora_inicio||''}–${c.hora_fin||''})` : ''));
                }
            })
            .catch(() => statusEl.innerHTML = '');
    }, 500);
}

/* ──────────────────────────────────────────────────────────────────────────
   Helpers
────────────────────────────────────────────────────────────────────────── */
function buildFechaParams() {
    const fi = document.getElementById('fecha_inicio').value;
    const ff = document.getElementById('fecha_fin').value;
    const hi = document.getElementById('hora_inicio').value;
    const hf = document.getElementById('hora_fin').value;
    return `fecha_inicio=${fi}&fecha_fin=${ff}&hora_inicio=${hi}&hora_fin=${hf}`;
}

function renderAlert(type, icon, msg) {
    return `<div class="val-alert ${type}"><span class="val-icon">${icon}</span><span>${msg}</span></div>`;
}

// Si hay old_input, dispara las validaciones al cargar
document.addEventListener('DOMContentLoaded', () => {
    const fichaVal = document.getElementById('ficha_id').value;
    if (fichaVal) onFichaChange(fichaVal);
    const instVal = document.getElementById('instructor_id').value;
    if (instVal) validarInstructor();
    const ambVal = document.getElementById('ambiente_id').value;
    if (ambVal) onAmbienteChange(ambVal);
});
</script>

<?php // Footer incluido por BaseController ?>
