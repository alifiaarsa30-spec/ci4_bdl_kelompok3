
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h2>Input Transaksi Penjualan</h2>
        <p>Masukkan informasi transaksi dan produk yang dijual.</p>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('penjualan/store') ?>" method="post">
    <?= csrf_field() ?>

    <div class="card" style="padding: 24px; margin-bottom: 20px;">
        <h3>Informasi Penjualan</h3>

        <div class="form-group">
            <label>Nomor Penjualan</label>
            <input
                type="text"
                name="no_penjualan"
                maxlength="15"
                placeholder="Contoh: J20261110"
                value="<?= esc(old('no_penjualan')) ?>"
                required
            >
            <small>Maksimal 15 karakter.</small>
        </div>

        <div class="form-group">
            <label>Tanggal Penjualan</label>
            <input
                type="date"
                name="tgl_penjualan"
                value="<?= esc(old('tgl_penjualan') ?? date('Y-m-d')) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Pelanggan</label>
            <select name="kode_pelanggan" required>
                <option value="">-- Pilih Pelanggan --</option>
                <?php foreach ($pelanggan as $p): ?>
                    <option
                        value="<?= esc($p['kode_pelanggan']) ?>"
                        <?= old('kode_pelanggan') == $p['kode_pelanggan'] ? 'selected' : '' ?>
                    >
                        <?= esc($p['nama_pelanggan']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="card" style="padding: 24px; margin-bottom: 20px;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
            <div>
                <h3>Produk yang Dijual</h3>
                <p>Pilih minimal dua jenis produk untuk transaksi.</p>
            </div>
            <button type="button" class="btn btn-primary" onclick="tambahBaris()">
                + Tambah Produk
            </button>
        </div>

        <div id="daftar-produk">
            <div class="produk-row" style="display:flex; gap:12px; align-items:end; margin-top:20px; flex-wrap:wrap;">
                <div style="flex:2; min-width:200px;">
                    <label>Produk</label>
                    <select name="items[0][kode_produk]" required>
                        <option value="">-- Pilih Produk --</option>
                        <?php foreach ($produk as $pr): ?>
                            <option value="<?= esc($pr['kode_produk']) ?>">
                                <?= esc($pr['kode_produk']) ?> -
                                <?= esc($pr['nama_produk']) ?>
                                (Stok: <?= esc($pr['stok']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="flex:1; min-width:100px;">
                    <label>Jumlah</label>
                    <input type="number" name="items[0][jumlah]" min="1" value="1" required>
                </div>

                <button type="button" class="btn btn-danger btn-hapus" onclick="hapusBaris(this)">
                    Hapus
                </button>
            </div>

            <div class="produk-row" style="display:flex; gap:12px; align-items:end; margin-top:16px; flex-wrap:wrap;">
                <div style="flex:2; min-width:200px;">
                    <label>Produk</label>
                    <select name="items[1][kode_produk]" required>
                        <option value="">-- Pilih Produk --</option>
                        <?php foreach ($produk as $pr): ?>
                            <option value="<?= esc($pr['kode_produk']) ?>">
                                <?= esc($pr['kode_produk']) ?> -
                                <?= esc($pr['nama_produk']) ?>
                                (Stok: <?= esc($pr['stok']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="flex:1; min-width:100px;">
                    <label>Jumlah</label>
                    <input type="number" name="items[1][jumlah]" min="1" value="1" required>
                </div>

                <button type="button" class="btn btn-danger btn-hapus" onclick="hapusBaris(this)">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 24px; margin-bottom: 20px;">
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" rows="3" placeholder="Keterangan tambahan (opsional)"><?= esc(old('keterangan')) ?></textarea>
        </div>

        <div style="display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap;">
            <a href="<?= base_url('penjualan') ?>" class="btn btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                Simpan Transaksi Penjualan
            </button>
        </div>
    </div>
</form>

<script>
let nomorBaris = 2;

function tambahBaris() {
    const daftar = document.getElementById('daftar-produk');

    const baris = document.createElement('div');
    baris.className = 'produk-row';
    baris.style.cssText = 'display:flex; gap:12px; align-items:end; margin-top:16px; flex-wrap:wrap;';

    baris.innerHTML = `
        <div style="flex:2; min-width:200px;">
            <label>Produk</label>
            <select name="items[${nomorBaris}][kode_produk]" required>
                <option value="">-- Pilih Produk --</option>
                <?php foreach ($produk as $pr): ?>
                    <option value="<?= esc($pr['kode_produk']) ?>">
                        <?= esc($pr['kode_produk']) ?> -
                        <?= esc($pr['nama_produk']) ?>
                        (Stok: <?= esc($pr['stok']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="flex:1; min-width:100px;">
            <label>Jumlah</label>
            <input type="number" name="items[${nomorBaris}][jumlah]" min="1" value="1" required>
        </div>

        <button type="button" class="btn btn-danger btn-hapus" onclick="hapusBaris(this)">
            Hapus
        </button>
    `;

    daftar.appendChild(baris);
    nomorBaris++;
}

function hapusBaris(button) {
    const daftar = document.getElementById('daftar-produk');

    if (daftar.querySelectorAll('.produk-row').length <= 2) {
        alert('Transaksi harus memiliki minimal 2 jenis produk.');
        return;
    }

    button.closest('.produk-row').remove();
}
</script>

<?= $this->endSection() ?>
