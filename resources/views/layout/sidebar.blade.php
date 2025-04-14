<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo" style="display: flex; flex-direction: column; justify-content: flex-start; align-items: center;">
        <span class="ms-1 font-weight-bold text-white" style="font-size: 18px; margin-top: 20px;">WIN'S MART</span>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <!-- Dashboard Link -->
                <li class="nav-item active">
                    <a href="/home">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
              @if(Auth::check() && Auth::user()->role == 'admin')
              <!-- Components Section -->
              <li class="nav-section">
                  <span class="sidebar-mini-icon">
                      <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">Master Data</h4>
              </li>

              <!-- Master Data Links -->
              <li class="nav-item">
                  <a href="/pelanggans">
                      <i class="fas fa-users"></i>
                      <p>Pelanggan</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="/produks">
                      <i class="fas fa-cogs"></i>
                      <p>Produk</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="/kategoris">
                      <i class="fas fa-th"></i>
                      <p>Kategori</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="/units">
                      <i class="fas fa-tachometer-alt"></i>
                      <p>Satuan</p>
                  </a>
              </li>

              <!-- Transactions Section -->
              <li class="nav-section">
                  <span class="sidebar-mini-icon">
                      <i class="fa fa-ellipsis-h"></i>
                  </span>
                  <h4 class="text-section">Transaksi</h4>
              </li>

              <!-- Transactions Links -->
              <li class="nav-item">
                  <a href="/suppliers">
                      <i class="fas fa-truck"></i>
                      <p>Pemasok</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="/stock_ins">
                      <i class="fas fa-arrow-down"></i>
                      <p>Stock Masuk</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="/stock_outs">
                      <i class="fas fa-arrow-up"></i>
                      <p>Stock Keluar</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="/penjualans">
                      <i class="fas fa-shopping-cart"></i>
                      <p>Penjualan</p>
                  </a>
              </li>

                <!-- Laporan Section -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Laporan</h4>
                </li>

                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}"> <!-- Menggunakan route untuk laporan -->
                        <i class="fas fa-file-alt"></i>
                        <p>Laporan</p>
                    </a>
                </li>

              <!-- Documentation Link -->
              <li class="nav-item">
                  <a href="../../documentation/index.html">
                      <i class="fas fa-file"></i>
                      <p>Documentation</p>
                      <span class="badge badge-secondary">1</span>
                  </a>
              </li>
              @endif

              @if(Auth::check() && Auth::user()->role == 'kasir')
            <li class="nav-item">
                <a href="/pelanggans">
                    <i class="fas fa-users"></i>
                    <p>Pelanggan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/produks">
                    <i class="fas fa-cogs"></i>
                    <p>Produk</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/penjualans">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Penjualan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('laporan.index') }}"> <!-- Menggunakan route untuk laporan -->
                    <i class="fas fa-file-alt"></i>
                    <p>Laporan</p>
                </a>
            </li>
            @endif
          </ul>
      </div>
  </div>
</div>
