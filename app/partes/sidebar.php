<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link d-flex align-items-center">
        <i class="fas fa-paw nav-icon brand-image text-success me-2"></i>
        <span class="brand-text font-weight-bold">Hora Pet</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <?php echo montaMenu($_SESSION['menu-n1'], $_SESSION['menu-n2']); ?>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>