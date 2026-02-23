    <!-- Script para Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Funcionalidades del Header -->
    <script src="<?php echo BASE_PATH; ?>assets/js/header-functions.js"></script>
    
    <script>
        // Inicializar iconos de Lucide
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Confirmación de eliminación
        function confirmarEliminacion(id, modulo) {
            if (confirm('¿Está seguro de eliminar este registro?')) {
                window.location.href = window.BASE_PATH + 'views/' + modulo + '/index.php?eliminar=' + id;
            }
        }

        // User Dropdown Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const userProfileToggle = document.getElementById('userProfileToggle');
            const userDropdown = document.getElementById('userDropdown');
            
            if (userProfileToggle && userDropdown) {
                userProfileToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userProfileToggle.classList.toggle('active');
                    userDropdown.classList.toggle('active');
                });
                
                // Cerrar dropdown al hacer clic fuera
                document.addEventListener('click', function(e) {
                    if (!userProfileToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                        userProfileToggle.classList.remove('active');
                        userDropdown.classList.remove('active');
                    }
                });
                
                // Reiniciar iconos de Lucide después de toggle
                userProfileToggle.addEventListener('click', function() {
                    setTimeout(function() {
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    }, 100);
                });
            }
        });
    </script>
</body>
</html>