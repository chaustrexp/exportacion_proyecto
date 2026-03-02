/**
 * Funcionalidades del Header
 * Búsqueda, Notificaciones, Ayuda, Agregar
 */

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    initializeSearch();
    initializeNotifications();
    initializeAddButton();
    initializeHelpModal();
    initializeClickOutside();
});

// ============================================
// BÚSQUEDA GLOBAL
// ============================================
function initializeSearch() {
    const searchInput = document.getElementById('globalSearch');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchResults) return;

    let searchTimeout;

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            searchResults.classList.remove('active');
            return;
        }

        // Debounce: esperar 300ms después de que el usuario deje de escribir
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    // Cerrar resultados al hacer clic fuera
    searchInput.addEventListener('blur', function () {
        setTimeout(() => {
            searchResults.classList.remove('active');
        }, 200);
    });
}

function performSearch(query) {
    const searchResults = document.getElementById('searchResults');

    // Mostrar loading
    searchResults.innerHTML = '<div style="padding: 20px; text-align: center; color: #6b7280;">Buscando...</div>';
    searchResults.classList.add('active');

    // Realizar búsqueda AJAX
    fetch(`${window.BASE_PATH}api/search.php?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            displaySearchResults(data);
        })
        .catch(error => {
            console.error('Error en búsqueda:', error);
            // Mostrar resultados de ejemplo si falla la API
            displaySearchResults(getMockSearchResults(query));
        });
}

function displaySearchResults(results) {
    const searchResults = document.getElementById('searchResults');

    if (!results || results.length === 0) {
        searchResults.innerHTML = `
            <div class="no-results">
                <i data-lucide="search-x"></i>
                <p>No se encontraron resultados</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }

    let html = '';
    results.forEach(result => {
        html += `
            <a href="${result.url}" class="search-result-item">
                <div class="search-result-icon">
                    <i data-lucide="${result.icon}"></i>
                </div>
                <div class="search-result-content">
                    <div class="search-result-title">${result.title}</div>
                    <div class="search-result-subtitle">${result.subtitle}</div>
                </div>
            </a>
        `;
    });

    searchResults.innerHTML = html;
    lucide.createIcons();
}

function getMockSearchResults(query) {
    // Resultados de ejemplo para demostración
    return [
        {
            title: 'Asignación #2024-001',
            subtitle: 'Ficha 2024-01 - Instructor Juan Pérez',
            url: '${window.BASE_PATH}views/asignacion/ver.php?id=1',
            icon: 'calendar'
        },
        {
            title: 'Instructor: María García',
            subtitle: 'Especialidad: Programación',
            url: '${window.BASE_PATH}views/instructor/ver.php?id=1',
            icon: 'user'
        },
        {
            title: 'Ficha 2024-01',
            subtitle: 'Programa: Desarrollo de Software',
            url: '${window.BASE_PATH}views/ficha/ver.php?id=1',
            icon: 'file-text'
        }
    ];
}

// ============================================
// NOTIFICACIONES
// ============================================
function initializeNotifications() {
    const notificationsBtn = document.getElementById('notificationsBtn');
    const notificationsDropdown = document.getElementById('notificationsDropdown');
    const markAllRead = document.getElementById('markAllRead');

    if (!notificationsBtn || !notificationsDropdown) return;

    // Toggle dropdown
    notificationsBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        notificationsDropdown.classList.toggle('active');

        // Cargar notificaciones si el dropdown se abre
        if (notificationsDropdown.classList.contains('active')) {
            loadNotifications();
        }
    });

    // Marcar todas como leídas
    if (markAllRead) {
        markAllRead.addEventListener('click', function (e) {
            e.preventDefault();
            markAllNotificationsAsRead();
        });
    }
}

function loadNotifications() {
    const notificationsList = document.getElementById('notificationsList');

    // Mostrar loading
    notificationsList.innerHTML = '<div style="padding: 20px; text-align: center; color: #6b7280;">Cargando...</div>';

    // Cargar notificaciones desde el servidor
    fetch('${window.BASE_PATH}api/notifications.php')
        .then(response => response.json())
        .then(data => {
            displayNotifications(data);
        })
        .catch(error => {
            console.error('Error cargando notificaciones:', error);
            // Mostrar notificaciones de ejemplo
            displayNotifications(getMockNotifications());
        });
}

function displayNotifications(notifications) {
    const notificationsList = document.getElementById('notificationsList');

    if (!notifications || notifications.length === 0) {
        notificationsList.innerHTML = `
            <div class="empty-notifications">
                <i data-lucide="bell-off"></i>
                <p>No tienes notificaciones</p>
            </div>
        `;
        lucide.createIcons();
        updateNotificationBadge(0);
        return;
    }

    let html = '';
    let unreadCount = 0;

    notifications.forEach(notification => {
        const unreadClass = notification.read ? '' : 'unread';
        if (!notification.read) unreadCount++;

        html += `
            <div class="notification-item ${unreadClass}" data-id="${notification.id}">
                <div class="notification-title">${notification.title}</div>
                <div class="notification-message">${notification.message}</div>
                <div class="notification-time">${notification.time}</div>
            </div>
        `;
    });

    notificationsList.innerHTML = html;
    updateNotificationBadge(unreadCount);

    // Agregar event listeners para marcar como leída al hacer clic
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function () {
            markNotificationAsRead(this.dataset.id);
            this.classList.remove('unread');
        });
    });
}

function getMockNotifications() {
    return [
        {
            id: 1,
            title: 'Nueva asignación creada',
            message: 'Se ha creado una nueva asignación para la ficha 2024-01',
            time: 'Hace 5 minutos',
            read: false
        },
        {
            id: 2,
            title: 'Instructor actualizado',
            message: 'Los datos del instructor Juan Pérez han sido actualizados',
            time: 'Hace 1 hora',
            read: false
        },
        {
            id: 3,
            title: 'Ficha completada',
            message: 'La ficha 2023-12 ha completado su programa',
            time: 'Hace 2 horas',
            read: false
        },
        {
            id: 4,
            title: 'Nuevo ambiente disponible',
            message: 'El ambiente LAB-301 está ahora disponible para asignaciones',
            time: 'Ayer',
            read: true
        }
    ];
}

function updateNotificationBadge(count) {
    const badge = document.getElementById('notificationBadge');
    if (!badge) return;

    if (count > 0) {
        badge.textContent = count > 9 ? '9+' : count;
        badge.style.display = 'block';
    } else {
        badge.style.display = 'none';
    }
}

function markNotificationAsRead(notificationId) {
    // Enviar petición al servidor para marcar como leída
    fetch('${window.BASE_PATH}api/notifications.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'mark_read',
            id: notificationId
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log('Notificación marcada como leída');
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function markAllNotificationsAsRead() {
    // Marcar todas como leídas
    fetch('${window.BASE_PATH}api/notifications.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'mark_all_read'
        })
    })
        .then(response => response.json())
        .then(data => {
            // Recargar notificaciones
            loadNotifications();
        })
        .catch(error => {
            console.error('Error:', error);
            // Simular marcado local
            document.querySelectorAll('.notification-item').forEach(item => {
                item.classList.remove('unread');
            });
            updateNotificationBadge(0);
        });
}

// ============================================
// BOTÓN AGREGAR
// ============================================
function initializeAddButton() {
    const addBtn = document.getElementById('addBtn');
    const addDropdown = document.getElementById('addDropdown');

    if (!addBtn || !addDropdown) return;

    addBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        addDropdown.classList.toggle('active');
    });
}

// ============================================
// MODAL DE AYUDA
// ============================================
function initializeHelpModal() {
    const helpBtn = document.getElementById('helpBtn');
    const helpModal = document.getElementById('helpModal');
    const helpModalClose = document.getElementById('helpModalClose');

    if (!helpBtn || !helpModal) return;

    // Abrir modal
    helpBtn.addEventListener('click', function () {
        helpModal.classList.add('active');
        lucide.createIcons();
    });

    // Cerrar modal
    if (helpModalClose) {
        helpModalClose.addEventListener('click', function () {
            helpModal.classList.remove('active');
        });
    }

    // Cerrar al hacer clic fuera del modal
    helpModal.addEventListener('click', function (e) {
        if (e.target === helpModal) {
            helpModal.classList.remove('active');
        }
    });

    // Cerrar con tecla ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && helpModal.classList.contains('active')) {
            helpModal.classList.remove('active');
        }
    });
}

// ============================================
// CERRAR DROPDOWNS AL HACER CLIC FUERA
// ============================================
function initializeClickOutside() {
    document.addEventListener('click', function (e) {
        // Cerrar dropdown de notificaciones
        const notificationsDropdown = document.getElementById('notificationsDropdown');
        const notificationsBtn = document.getElementById('notificationsBtn');
        if (notificationsDropdown && !notificationsBtn.contains(e.target)) {
            notificationsDropdown.classList.remove('active');
        }

        // Cerrar dropdown de agregar
        const addDropdown = document.getElementById('addDropdown');
        const addBtn = document.getElementById('addBtn');
        if (addDropdown && !addBtn.contains(e.target)) {
            addDropdown.classList.remove('active');
        }
    });
}

// ============================================
// UTILIDADES
// ============================================

// Formatear tiempo relativo
function formatRelativeTime(date) {
    const now = new Date();
    const diff = now - new Date(date);
    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (seconds < 60) return 'Hace un momento';
    if (minutes < 60) return `Hace ${minutes} minuto${minutes > 1 ? 's' : ''}`;
    if (hours < 24) return `Hace ${hours} hora${hours > 1 ? 's' : ''}`;
    if (days < 7) return `Hace ${days} día${days > 1 ? 's' : ''}`;
    return new Date(date).toLocaleDateString();
}
