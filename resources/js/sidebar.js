// Sidebar Responsive Management
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarClose = document.getElementById('sidebar-close');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (!sidebarToggle || !sidebar || !overlay) {
        console.warn('Sidebar elements not found');
        return;
    }
    
    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        
        // Prevent body scroll when sidebar is open on mobile
        if (window.innerWidth < 1024) {
            document.body.style.overflow = sidebar.classList.contains('-translate-x-full') ? 'auto' : 'hidden';
        }
    }
    
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        if (window.innerWidth < 1024) {
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Event listeners
    sidebarToggle.addEventListener('click', toggleSidebar);
    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }
    overlay.addEventListener('click', closeSidebar);
    
    // Close sidebar when clicking on menu items on mobile
    const menuItems = sidebar.querySelectorAll('a');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });
    });
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 1024) {
                // Desktop: always show sidebar
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            } else {
                // Mobile: hide sidebar by default
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }, 250);
    });
    
    // Handle escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && window.innerWidth < 1024) {
            closeSidebar();
        }
    });
    
    // Initialize sidebar state based on screen size
    if (window.innerWidth >= 1024) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.add('hidden');
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
}); 