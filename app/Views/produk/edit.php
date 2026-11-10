
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    .form-page {
        max-width: 780px;
        margin: 0 auto;
        color: #303B32;
    }

    .form-heading {
        margin-bottom: 22px;
    }

    .form-heading h2 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .form-heading p {
        color: #777D75;
        font-size: 14px;
        margin: 0;
    }

    .form-card {
        background: #FFFFFF;
        border: 1px solid #EAE9E2;
        border-radius: 10px;
        padding: 26px;
    }

    .form-card-title {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 22px;
        padding-bottom: 15px;
        border-bottom: 1px solid #EAE9E2;
    }

    .form-field {
        margin-bottom: 18px;
    }

    .form-field label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 7px;
        color: #465047;
    }

    .form-field input,
    .form-field textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #EAE9E2;
        border-radius: 7px;
        background: #FFFFFF;
        color: #303B32;
        font-family: inherit;
        font-size: 14px;
    }

    .form-field input:focus,
    .form-field textarea:focus {
        outline: none;
        border-color: #465748;
        box-shadow: 0 0 0 2px rgba(70, 87, 72, .10);
    }

    .form-field input:disabled {
        background: #F5F4EF;
        color: #858B82;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-help {
        display: block;
        color: #858B82;
        font-size: 12px;
        margin-top: 6px;
    }

    .form-footer {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #EAE9E2;
    }

    .form-button {
        display: inline-block;
        border: none;
        border-radius: 7px;
        padding: 10px 17px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .form-button-back {
        background: #EAE9E2;
        color: #303B32;
    }

    .form-button-save {
        background: #465748;
        color: #FFFFFF;
    }

    .form-button-save:hover {
        background: #303B32;
        color: #FFFFFF;
    }

    @media (max-width: 600px) {
        .form-card {
            padding: 18px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>

<div class="form-page">

    <div class="form-heading">
        <h2>Edit Produk</h2>
        <p>Perbarui informasi produk yang tersimpan dalam sistem.</p>
    </div>

    <div class="form-card">

        <div class="form-card-title">
            <i class="fa-solid fa-pen-to-square me-2"></i>
            Informasi Produk
        </div>

        <form action="<?= base_url('/produk/update/' . $produk['kode_produk']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-field">
                <label>Kode Produk</label>
                <input
                    type="text"
                    value="<?= esc($produk['kode_produk']) ?>"
                    disabled
                >
                <span class="form-help">Kode produk tidak dapat diubah.</span>
            </div>

            <div class="form-field">
                <label>Nama Produk</label>
                <input
                    type="text"
                    name="nama_produk"
                    value="<?= esc(old('nama_produk', $produk['nama_produk'])) ?>"
                    required
                >
            </div>

            <div class="form-grid">
                <div class="form-field">
                    <label>Satuan</label>
                    <input
                        type="text"
                        name="satuan"
                        value="<?= esc(old('satuan', $produk['satuan'])) ?>"
                        required
                    >
                </div>

                <div class="form-field">
                    <label>Stok</label>
                    <input
                        type="number"
                        name="stok"
                        min="0"
                        value="<?= esc(old('stok', $produk['stok'])) ?>"
                        required
                    >
                </div>
            </div>

            <div class="form-grid">
                <div class="form-field">
                    <label>Harga Beli (Rp)</label>
                    <input
                        type="number"
                        name="harga_beli"
                        min="0"
                        value="<?= esc(old('harga_beli', $produk['harga_beli'])) ?>"
                        required
                    >
                </div>

                <div class="form-field">
                    <label>Harga Jual (Rp)</label>
                    <input
                        type="number"
                        name="harga_jual"
                        min="0"
                        value="<?= esc(old('harga_jual', $produk['harga_jual'])) ?>"
                        required
                    >
                </div>
            </div>

            <div class="form-field">
                <label>Deskripsi</label>
                <textarea
                    name="deskripsi"
                    rows="3"
                ><?= esc(old('deskripsi', $produk['deskripsi'])) ?></textarea>
            </div>

            <div class="form-footer">
                <a href="<?= base_url('/produk') ?>" class="form-button form-button-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>

                <button type="submit" class="form-button form-button-save">
                    <i class="fa-solid fa-save me-1"></i> Perbarui Produk
                </button>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection() ?>
