<?php
if (!defined('ROOT_PATH')) {
    exit('Direct access not allowed');
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Media Sosial</h3>
                <p class="text-subtitle text-muted">Kelola platform media sosial untuk share berita</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="index.php?action=berita_list">Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Media Sosial</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <?php echo getFlashMessage(); ?>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Platform Media Sosial</h5>
            </div>
            <div class="card-body">
                <form action="index.php?action=social_media_update" method="POST">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="50">Order</th>
                                    <th>Platform</th>
                                    <th width="100">Aktif</th>
                                    <th>Icon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $platformNames = [
                                    'facebook' => 'Facebook',
                                    'twitter' => 'Twitter',
                                    'whatsapp' => 'WhatsApp',
                                    'telegram' => 'Telegram',
                                    'linkedin' => 'LinkedIn',
                                    'copy' => 'Salin Link'
                                ];

                                $platformIcons = [
                                    'facebook' => 'bi-facebook',
                                    'twitter' => 'bi-twitter',
                                    'whatsapp' => 'bi-whatsapp',
                                    'telegram' => 'bi-telegram',
                                    'linkedin' => 'bi-linkedin',
                                    'copy' => 'bi-link-45deg'
                                ];

                                foreach ($platforms as $platform):
                                ?>
                                    <tr>
                                        <td>
                                            <input type="number"
                                                name="platforms[<?= $platform['platform'] ?>][order]"
                                                class="form-control form-control-sm"
                                                value="<?= $platform['display_order'] ?>"
                                                min="0"
                                                style="width: 70px;">
                                        </td>
                                        <td>
                                            <strong><?= $platformNames[$platform['platform']] ?? ucfirst($platform['platform']) ?></strong>
                                            <input type="hidden" name="platforms[<?= $platform['platform'] ?>][platform]" value="<?= $platform['platform'] ?>">
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    name="platforms[<?= $platform['platform'] ?>][enabled]"
                                                    value="1"
                                                    id="switch_<?= $platform['platform'] ?>"
                                                    <?= ($platform['enabled'] === true || $platform['enabled'] === 't' || $platform['enabled'] == 1) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="switch_<?= $platform['platform'] ?>"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="bi <?= $platformIcons[$platform['platform']] ?? 'bi-circle' ?> fs-4"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Pengaturan
                        </button>
                        <a href="index.php?action=berita_list" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title">Informasi</h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li><strong>Order:</strong> Urutan tampil platform media sosial (angka lebih kecil = tampil lebih awal)</li>
                    <li><strong>Aktif:</strong> Centang untuk mengaktifkan platform, uncheck untuk menyembunyikan</li>
                    <li><strong>Preview:</strong> Platform yang aktif akan muncul di halaman detail berita</li>
                </ul>
            </div>
        </div>
    </section>
</div>