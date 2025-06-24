<!-- Modal Detail Barang Keluar -->
<div class="modal fade" id="detailBarang" tabindex="-1" aria-labelledby="detailBarangLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="detailBarangLabel">Detail Barang Keluar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <th>Kode Transaksi</th>
              <td id="detail_kode_transaksi"></td>
            </tr>
            <tr>
              <th>Nama Barang</th>
              <td id="detail_nama_barang"></td>
            </tr>
            <tr>
              <th>Kode Barang</th>
              <td id="detail_kode_barang"></td>
            </tr>
            <tr>
              <th>Serial Number</th>
              <td id="detail_serial_number"></td>
            </tr>
            <tr>
              <th>Jumlah</th>
              <td id="detail_jumlah"></td>
            </tr>
            <tr>
              <th>Nama Penerima</th>
              <td id="detail_nama_penerima"></td>
            </tr>
            <tr>
              <th>Jenis</th>
              <td id="detail_jenis"></td>
            </tr>
            <tr>
              <th>Staff Input</th>
              <td id="detail_staff"></td>
            </tr>
            <tr id="foto_penerima_row" style="display: none;">
              <th>Foto Penerima</th>
              <td><img id="detail_foto_penerima" src="" alt="Foto Penerima" width="100" class="rounded shadow"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
