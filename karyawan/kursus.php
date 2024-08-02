<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #EAFAF1;
    margin: 0;
    padding: 0;


    h1,
    h3,
    h4 {
      color: #333;
    }

    form {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .section {
      flex: 1 1 45%;
      min-width: 45%;
    }

    .two-columns {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    td {
      padding: 10px;
      vertical-align: top;
    }

    td input[type="text"],
    td input[type="date"],
    td input[type="email"] {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    td input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    td input[type="submit"]:hover {
      background-color: #45a049;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:nth-child(odd) {
      background-color: #fff;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    h1 {
      margin-top: 2rem;
      text-align: center;
    }

    .full-width {
      flex: 1 1 100%;
    }

    body {
      margin: 0;
      font-family: "Montserrat", sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    .form-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .form-table th,
    .form-table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    .form-table th {
      background-color: yellowgreen;
      color: white;
    }

    .form-table td {
      background-color: #ffffff;
    }

    .form-table input,
    .form-table select {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }

    .form-container {
      background-color: white;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .foto-box {
      width: 3cm;
      height: 3cm;
      border: 1px solid #000;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      box-sizing: border-box;
      text-align: center;
    }

    .foto-input {
      width: 100%;
      height: 100%;
      opacity: 0;
      position: absolute;
      top: 0;
      left: 0;
      cursor: pointer;
    }

    .foto-label {
      pointer-events: none;
    }

  }
</style>
<!--DATA ORANG TUA-->
<h4 style="margin-top: -20px;">Susunan Keluarga (ayah/ibu/saudara kandung)</h4>
<table class="form-table" id="formTableFamily" style="margin-top: -30px;">
  <thead>
    <tr>
      <th>Kursus Pelatihan<button type="button" id="addPt" onclick="showModalKursus()" style="margin-left: 10px;">+</button></th>
      <th>Nama Institusi</th>
      <th>Lama Kursus / Pelatihan</th>
    </tr>
  </thead>
  <tbody id="familyTableKursus">
    <style>
      .modal-kursus {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
      }

      .modal-content-kursus {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 20%;
        height: 30%;
      }

      .close-kursus {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
      }

      .close-kursus:hover,
      .close-kursus:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
      }
    </style>

    <!-- Modal -->
    <div id="myModalKursus" class="modal-kursus">
      <div class="modal-content-kursus">
        <span class="close-kursus" onclick="closeModalKursus()">&times;</span>
        <h2 style="margin-top: -3px;">Pilih Status Keluarga</h2>
        <select id="statusKeluargaKursusSelect">
          <option value="Ayah">Ayah</option>
          <option value="Ibu">Ibu</option>
          <option value="Anak ke-1">Anak ke-1</option>
          <option value="Anak ke-2">Anak ke-2</option>
          <option value="Anak ke-3">Anak ke-3</option>
          <option value="Anak ke-4">Anak ke-4</option>
          <option value="Anak ke-5">Anak ke-5</option>
        </select>
        <button type="button" onclick="addRowKursus()">Tambah</button>
      </div>
    </div>


    <script>
      // JavaScript untuk membuka dan menutup modal
      function showModalKursus() {
        document.getElementById('myModalKursus').style.display = 'block';
      }

      function closeModalKursus() {
        document.getElementById('myModalKursus').style.display = 'none';
      }

      // JavaScript untuk menambahkan baris baru ke tabel berdasarkan pilihan
      function addRowKursus() {
        const table = document.getElementById('familyTableKursus');
        const select = document.getElementById('statusKeluargaKursusSelect');
        const statusKursus = select.value;

        let rowHtml = '';
        switch (statusKursus) {
          case 'Ayah':
            rowHtml = `
                            <tr>
                                <td>
                                    <input type="text" id="status_keluarga_sub" name="status_keluarga_sub" value="Ayah" readonly>
                                </td>
                                <td><input type="text" id="nama" name="nama_ayah"></td>
                                <td>
                                    <input type="text" id="jk_ayah" name="jk_ayah" value="Laki-laki" readonly>
                                </td>
                                <td><input type="text" id="tempat_lahir_ayah" name="tempat_lahir_ayah"></td>
                                <td><input type="date" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah"></td>
                                <td><input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah"></td>
                             </tr>
                    `;
            break;
          case 'Ibu':
            rowHtml = `
                            <tr>
                                <td>
                                    <input type="text" id="status_keluarga_sub" name="status_keluarga_sub" value="Ibu" readonly>
                                </td>
                                <td><input type="text" id="nama" name="nama_ibu"></td>
                                <td>
                                    <input type="text" id="jk_ibu" name="jk_ibu" value="Perempuan" readonly>
                                </td>
                                <td><input type="text" id="tempat_lahir_ibu" name="tempat_lahir_ibu"></td>
                                <td><input type="date" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu"></td>
                                <td><input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu"></td>
                            </tr>
                    `;
            break;
          case 'Anak ke-1':
            rowHtml = `
                            <tr>
                                <td>
                                    <input type="text" id="status_keluarga_sub" name="status_keluarga_sub" value="Anak Pertama">
                                </td>
                                <td><input type="text" id="nama" name="nama_pertama"></td>
                                <td>
                                    <select name="jk_pertama" id="jk_pertama" class="jk_pertama">
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                     </select>
                                </td>
                                <td><input type="text" id="tempat_lahir_pertama" name="tempat_lahir_pertama"></td>
                                <td><input type="date" id="tanggal_lahir_pertama" name="tanggal_lahir_pertama"></td>
                                <td><input type="text" id="pekerjaan_pertama" name="pekerjaan_pertama"></td>
                             </tr>
                    `;
            break;
          case 'Anak ke-2':
            rowHtml = `
                                     <tr>
                                <td>
                                    <input type="text" id="status_keluarga_sub" name="status_keluarga_sub" value="Anak Kedua">
                                </td>
                                <td><input type="text" id="nama" name="nama_kedua"></td>
                                <td>
                                    <select name="jk_kedua" id="jk_kedua" class="jk_kedua">
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input type="text" id="tempat_lahir_kedua" name="tempat_lahir_kedua"></td>
                                <td><input type="date" id="tanggal_lahir_kedua" name="tanggal_lahir_kedua"></td>
                                <td><input type="text" id="pekerjaan_kedua" name="pekerjaan_kedua"></td>
                            </tr>
                    `;
            break;
          case 'Anak ke-3':
            rowHtml = `
                            <tr>
                                <td>
                                    <input type="text" id="status_keluarga_sub" name="status_keluarga_sub" value="Anak Ketiga">
                                </td>
                                <td><input type="text" id="nama" name="nama_ketiga"></td>
                                <td>
                                    <select name="jk_ketiga" id="jk_ketiga" class="jk_ketiga">
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input type="text" id="tempat_lahir_ketiga" name="tempat_lahir_ketiga"></td>
                                <td><input type="date" id="tanggal_lahir_ketiga" name="tanggal_lahir_ketiga"></td>
                                <td><input type="text" id="pekerjaan_ketiga" name="pekerjaan_ketiga"></td>
                            </tr>
                    `;
            break;
          case 'Anak ke-4':
            rowHtml = `
                            <tr>
                                <td>
                                    <input type="text" id="status_keluarga_sub" name="status_keluarga_sub" value="Anak Keempat">
                                </td>
                                <td><input type="text" id="nama" name="nama_keempat"></td>
                                <td>
                                    <select name="jk_keempat" id="jk_keempat" class="jk_keempat">
                                        <option value="">Pilih...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input type="text" id="tempat_lahir_keempat" name="tempat_lahir_keempat"></td>
                                <td><input type="date" id="tanggal_lahir_keempat" name="tanggal_lahir_keempat"></td>
                                <td><input type="text" id="pekerjaan_keempat" name="pekerjaan_keempat"></td>
                            </tr>
                    `;
            break;
          case 'Anak ke-5':
            rowHtml = `
                                <tr>
                                    <td>
                                        <input type="text" id="status_keluarga_sub" name="status_keluarga_sub" value="Anak Kelima">
                                    </td>
                                    <td><input type="text" id="nama" name="nama_kelima"></td>
                                    <td>
                                        <select name="jk_kelima" id="jk_kelima" class="jk_kelima">
                                            <option value="">Pilih...</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </td>
                                    <td><input type="text" id="tempat_lahir_kelima" name="tempat_lahir_kelima"></td>
                                    <td><input type="date" id="tanggal_lahir_kelima" name="tanggal_lahir_kelima"></td>
                                    <td><input type="text" id="pekerjaan_kelima" name="pekerjaan_kelima"></td>
                                </tr>
                    `;
            break;
        }

        table.insertAdjacentHTML('beforeend', rowHtml);

        // Disable the selected option
        select.querySelector(`option[value="${statusKursus}"]`).disabled = true;

        closeModalKursus();
      }

      // Menambahkan event listener pada window untuk menutup modal jika pengguna mengklik di luar modal
      window.onclick = function(event) {
        const modal = document.getElementById('myModalKursus');
        if (event.target === modal) {
          closeModalKursus();
        }
      }
    </script>

  </tbody>
</table>