<?php
/**
 * Sistema de Títulos Dinámicos para el Dashboard
 * Detecta automáticamente la sección actual y retorna el título apropiado
 */

function getPageTitle() {
    // Obtener la ruta actual
    $currentFile = basename($_SERVER['PHP_SELF']);
    $currentPath = $_SERVER['REQUEST_URI'];
    
    // Detectar el módulo desde la ruta
    $module = '';
    if (preg_match('/\/(asignacion|ficha|instructor|ambiente|programa|competencia|centro_formacion|coordinacion|sede|competencia_programa|instru_competencia|detalle_asignacion|perfil)\//', $currentPath, $matches)) {
        $module = $matches[1];
    }
    
    // Mapeo de módulos a títulos
    $moduleTitles = [
        'asignacion' => 'Asignaciones',
        'ficha' => 'Fichas',
        'instructor' => 'Instructores',
        'ambiente' => 'Ambientes',
        'programa' => 'Programas',
        'competencia' => 'Competencias',
        'centro_formacion' => 'Centros de Formación',
        'coordinacion' => 'Coordinaciones',
        'sede' => 'Sedes',
        'competencia_programa' => 'Competencias por Programa',
        'instru_competencia' => 'Instructor - Competencias',
        'detalle_asignacion' => 'Detalle de Asignaciones',
        'perfil' => 'Mi Perfil'
    ];
    
    // Determinar el título base
    $baseTitle = 'Dashboard Principal';
    if ($module && isset($moduleTitles[$module])) {
        $baseTitle = $moduleTitles[$module];
    }
    
    // Ajustar según el archivo actual
    switch ($currentFile) {
        case 'index.php':
            if ($module) {
                return 'Gestión de ' . $baseTitle;
            }
            return 'Dashboard Principal';
            
        case 'crear.php':
            return 'Crear ' . $baseTitle;
            
        case 'editar.php':
            return 'Editar ' . $baseTitle;
            
        case 'ver.php':
            return 'Ver Detalle de ' . $baseTitle;
            
        default:
            return $baseTitle;
    }
}

/**
 * Obtener el título de la página para el tag <title>
 */
function getDocumentTitle() {
    return getPageTitle() . ' - Dashboard SENA';
}

/**
 * Obtener breadcrumbs automáticamente
 */
function getAutoBreadcrumbs() {
    $currentPath = $_SERVER['REQUEST_URI'];
    $breadcrumbs = [];
    
    // Detectar módulo
    if (preg_match('/\/(asignacion|ficha|instructor|ambiente|programa|competencia|centro_formacion|coordinacion|sede|competencia_programa|instru_competencia|detalle_asignacion)\//', $currentPath, $matches)) {
        $module = $matches[1];
        
        $moduleTitles = [
            'asignacion' => 'Asignaciones',
            'ficha' => 'Fichas',
            'instructor' => 'Instructores',
            'ambiente' => 'Ambientes',
            'programa' => 'Programas',
            'competencia' => 'Competencias',
            'centro_formacion' => 'Centros de Formación',
            'coordinacion' => 'Coordinaciones',
            'sede' => 'Sedes',
            'competencia_programa' => 'Competencias por Programa',
            'instru_competencia' => 'Instructor - Competencias',
            'detalle_asignacion' => 'Detalle de Asignaciones'
        ];
        
        if (isset($moduleTitles[$module])) {
            $breadcrumbs[] = [
                'label' => $moduleTitles[$module],
                'url' => BASE_PATH . 'views/' . $module . '/index.php'
            ];
            
            // Agregar acción si existe
            $currentFile = basename($_SERVER['PHP_SELF']);
            if ($currentFile === 'crear.php') {
                $breadcrumbs[] = ['label' => 'Crear Nuevo', 'url' => ''];
            } elseif ($currentFile === 'editar.php') {
                $breadcrumbs[] = ['label' => 'Editar', 'url' => ''];
            } elseif ($currentFile === 'ver.php') {
                $breadcrumbs[] = ['label' => 'Ver Detalle', 'url' => ''];
            }
        }
    }
    
    return $breadcrumbs;
}
?>
