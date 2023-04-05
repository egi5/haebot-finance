<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu div-menu">
            <div class="nav">
                <br>

                <?php if (has_permission('Dashboard') || has_permission('Keuangan')) : ?>
                    <small class="mt-0 ms-3 text-secondary"></small>
                <?php endif; ?>

                <?php if (has_permission('Dashboard')) : ?>
                    <a class="nav-link py-2" href="<?= base_url() ?>/dashboard">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-solid fa-gauge"></i>
                        </div>
                        Dashboard
                    </a>
                <?php endif; ?>

                <br>

                <!-- <?php if (has_permission('Keuangan')) : ?>
                    <small class="mt-4 ms-3 text-secondary">Jurnal Umum</small>
                <?php endif; ?> -->

                <?php if (has_permission('Keuangan')) : ?>
                    <a class="nav-link py-2" href="<?= base_url() ?>/tagihan">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-regular fa-calendar-check"></i>
                        </div>
                        Tagihan
                    </a>
                <?php endif; ?>

                <?php if (has_permission('Keuangan')) : ?>
                    <a class="nav-link py-2" href="<?= base_url() ?>/jurnalumum">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-regular fa-regular fa-clipboard"></i>
                        </div>
                        Jurnal Umum
                    </a>
                <?php endif; ?>



                <!-- <?php if (has_permission('Keuangan')) : ?>
                    <small class="mt-4 ms-3 text-secondary">Akun</small>
                <?php endif; ?> -->

                <?php if (has_permission('Keuangan')) : ?>
                    <a class="nav-link py-2" href="<?= base_url() ?>/listakun">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-solid fa-list-ol"></i>
                        </div>
                        Akun
                    </a>
                <?php endif; ?>

                <?php if (has_permission('Keuangan')) : ?>
                    <a class="nav-link py-2" href="<?= base_url() ?>/kas_bank">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-regular fa-folder-open"></i>
                        </div>
                        Kas & Bank
                    </a>
                <?php endif; ?>

                <br>

                <!-- <?php if (has_permission('Keuangan')) : ?>
                    <small class="mt-4 ms-3 text-secondary">Laporan</small>
                <?php endif; ?> -->

                <?php if (has_permission('Keuangan')) : ?>
                    <a class="nav-link py-2" href="<?= base_url() ?>/laporan">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-solid fa-chart-simple"></i>
                        </div>
                        Laporan
                    </a>
                <?php endif; ?>


            </div>
        </div>
        <div class="sb-sidenav-footer py-1">
            <div class="small">Masuk sebagai :</div>
            <?= user()->name ?>
        </div>
    </nav>
</div>