<?php
require_once __DIR__ . '/../../auth/check_auth.php';
require_once __DIR__ . '/../../helpers/page_titles.php';

$pageTitle = 'Mi Dashboard - Instructor';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/theme-enhanced.css">
    <style>
        .instructor-header {
            background: linear-gradient(135deg, #39a900 0%, #2d8500 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .instructor-header h1 {
            margin: 0 0 10px 0;
            font-size: 2em;
        }
        
        .instructor-header p {
            margin: 0;
            opacity: 0.9;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #39a900;
        }
        
        .stat-card h3 {
            color: #666;
            font-size: 0.9em;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        
        .stat-card .number {
            font-size: 2.5em;
            font-weight: bold;
            color: #39a900;
            margin: 0;
        }
        
        .section-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .section-card h2 {
            margin: 0 0 20px 0;
            color: #333;
            border-bottom: 2px solid #39a900;
            padding-bottom: 10px;
        }
        
        .ficha-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 3px solid #39a900;
        }
        
        .ficha-item h4 {
            margin: 0 0 5px 0;
            color: #333;
        }
        
        .ficha-item p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9em;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        
        .badge-primary {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .badge-success {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .asignacion-item {
            background: #fff;
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        
        .asignacion-item .fecha {
            font-weight: bold;
            color: #39a900;
            margin-bottom: 5px;
        }
        
        .asignacion-item .detalles {
            color: #666;
            font-size: 0.9em;
        }
        
        .btn-ver-mas {
            display: inline-block;
            padding: 10px 20px;
            background: #39a900;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            transition: background 0.3s;
        }
        
        .btn-ver-mas:hover {
            background: #2d8500;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../layout/header.php'; ?>
    <?php include __DIR__ . '/../layout/sidebar.php'; ?>
    
    <div class="main-content">
        <div class="instructor-header">
            <h1>👋 Bienvenido, <?php echo htmlspecialchars($instructor['inst_nombres'] ?? 'Instructor'); ?></h1>
            <p>Este es tu panel de control personal. Aquí puedes ver tus fichas y asignaciones.</p>
        </div>
        
        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Mis Fichas</h3>
                <p class="number"><?php echo $estadisticas['total_fichas']; ?></p>
            </div>
            
            <div class="stat-card">
                <h3>Total Asignaciones</h3>
                <p class="number"><?php echo $estadisticas['total_asignaciones']; ?></p>
            </div>
            
            <div class="stat-card">
                <h3>Asignaciones Hoy</h3>
                <p class="number"><?php echo $estadisticas['asignaciones_hoy']; ?></p>
            </div>
            
            <div class="stat-card">
                <h3>Esta Semana</h3>
                <p class="number"><?php echo $estadisticas['asignaciones_semana']; ?></p>
            </div>
        </div>
        
        <!-- Mis Fichas -->
        <div class="section-card">
            <h2>📚 Mis Fichas Asignadas</h2>
            
            <?php if (count($fichas) > 0): ?>
                <?php foreach (array_slice($fichas, 0, 5) as $ficha): ?>
                    <div class="ficha-item">
                        <h4>Ficha <?php echo htmlspecialchars($ficha['fich_numero']); ?></h4>
                        <p><strong>Programa:</strong> <?php echo htmlspecialchars($ficha['prog_denominacion']); ?></p>
                        <p>
                            <span class="badge badge-primary"><?php echo htmlspecialchars($ficha['fich_jornada']); ?></span>
                            <span class="badge badge-success"><?php echo htmlspecialchars($ficha['prog_tipo']); ?></span>
                        </p>
                        <p><strong>Coordinación:</strong> <?php echo htmlspecialchars($ficha['coord_nombre']); ?></p>
                        <p><strong>Asignaciones:</strong> <?php echo $ficha['total_asignaciones']; ?></p>
                    </div>
                <?php endforeach; ?>
                
                <?php if (count($fichas) > 5): ?>
                    <a href="<?php echo BASE_PATH; ?>?controller=instructor_dashboard&action=misFichas" class="btn-ver-mas">
                        Ver todas mis fichas (<?php echo count($fichas); ?>)
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>No tienes fichas asignadas actualmente.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Próximas Asignaciones -->
        <div class="section-card">
            <h2>📅 Próximas Asignaciones</h2>
            
            <?php if (count($asignaciones) > 0): ?>
                <?php foreach ($asignaciones as $asig): ?>
                    <div class="asignacion-item">
                        <div class="fecha">
                            <?php 
                            $fecha = new DateTime($asig['asig_fecha_ini']);
                            echo $fecha->format('d/m/Y H:i'); 
                            ?> - 
                            <?php 
                            $fechaFin = new DateTime($asig['asig_fecha_fin']);
                            echo $fechaFin->format('H:i'); 
                            ?>
                        </div>
                        <div class="detalles">
                            <strong>Ficha:</strong> <?php echo htmlspecialchars($asig['fich_numero']); ?> | 
                            <strong>Ambiente:</strong> <?php echo htmlspecialchars($asig['amb_nombre']); ?> | 
                            <strong>Competencia:</strong> <?php echo htmlspecialchars($asig['comp_nombre_corto']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <a href="<?php echo BASE_PATH; ?>?controller=instructor_dashboard&action=misAsignaciones" class="btn-ver-mas">
                    Ver todas mis asignaciones
                </a>
            <?php else: ?>
                <div class="empty-state">
                    <p>No tienes asignaciones próximas.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>
