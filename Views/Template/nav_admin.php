  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../../index3.html" class="brand-link">
          <img src="<?= media(); ?>/images/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light"><?php echo $_SESSION['userData']['nombrerol']; ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="<?= media(); ?>/images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block"><?php echo $_SESSION['userData']['nombres'] . ' ' . $_SESSION['userData']['apellidos']; ?></a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
                      <li class="nav-item">
                          <a href="<?= base_url(); ?>/dashboard" class="nav-link active">
                              <i class="nav-icon fa-brands fa-dashcube"></i>
                              <p>
                                  Dashboard
                              </p>
                          </a>
                      </li>
                  <?php } ?>

                  <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class="nav-icon fa-regular fa-users"></i>
                              <p>
                                  Usuarios
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="<?= base_url(); ?>/usuarios" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Usuarios</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="<?= base_url(); ?>/roles" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Roles</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  <?php } ?>

                  <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class="nav-icon fa-regular fa-folder-gear"></i>
                              <p>
                                  Mantenimiento
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="<?= base_url(); ?>/marcas" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Marcas</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="<?= base_url(); ?>/tipos" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Tipos</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  <?php } ?>

                  <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>

                      <li class="nav-item">
                          <a href="<?= base_url(); ?>/clientes" class="nav-link">
                              <i class="nav-icon fa-regular fa-user-plus"></i>
                              <p>
                                  Clientes
                              </p>
                          </a>
                      </li>
                  <?php } ?>

                  <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>

                      <li class="nav-item">
                          <a href="<?= base_url(); ?>/productos" class="nav-link">
                              <i class="nav-icon fa-regular fa-box-circle-check"></i>
                              <p>
                                  Productos
                              </p>
                          </a>
                      </li>
                  <?php } ?>

                  <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class="nav-icon fa-regular fa-shop"></i>
                              <p>
                                  Compras
                                  <i class="fas fa-angle-left right"></i>

                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="<?= base_url(); ?>/compras" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Nueva compra</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="<?= base_url(); ?>/compras/historial" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Historial compras</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  <?php } ?>

                  <li class="nav-item">
                      <a href="<?= base_url(); ?>/logout" class="nav-link">
                          <i class="nav-icon fas fa-sign-out-alt icon-logout"></i>
                          <p>
                              Salir
                          </p>
                      </a>
                  </li>
              </ul>
          </nav>
      </div>
  </aside>