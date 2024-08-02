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
            <th style="width: 110px;">Status Keluarga<button type="button" id="addRowOrtu" onclick="showModalOrtu()" style="margin-left: 10px;">+</button></th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Pekerjaan</th>
        </tr>
    </thead>
    <tbody id="familyTableOrtu">
        <style>
            .modal-ortu {
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

            .modal-content-ortu {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 20%;
                height: 30%;
            }

            .close-ortu {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close-ortu:hover,
            .close-ortu:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>

        <!-- Modal -->
        <div id="myModalOrtu" class="modal-ortu">
            <div class="modal-content-ortu">
                <span class="close-ortu" onclick="closeModalOrtu()">&times;</span>
                <h2 style="margin-top: -3px;">Pilih Status Keluarga</h2>
                <select id="statusKeluargaOrtuSelect">
                    <option value="Ayah">Ayah</option>
                    <option value="Ibu">Ibu</option>
                    <option value="Anak ke-1">Anak ke-1</option>
                    <option value="Anak ke-2">Anak ke-2</option>
                    <option value="Anak ke-3">Anak ke-3</option>
                    <option value="Anak ke-4">Anak ke-4</option>
                    <option value="Anak ke-5">Anak ke-5</option>
                </select>
                <button type="button" onclick="addRowOrtu()">Tambah</button>
            </div>
        </div>


        <script>
            // JavaScript untuk membuka dan menutup modal
            function showModalOrtu() {
                document.getElementById('myModalOrtu').style.display = 'block';
            }

            function closeModalOrtu() {
                document.getElementById('myModalOrtu').style.display = 'none';
            }

            // JavaScript untuk menambahkan baris baru ke tabel berdasarkan pilihan
            function addRowOrtu() {
                const table = document.getElementById('familyTableOrtu');
                const select = document.getElementById('statusKeluargaOrtuSelect');
                const statusOrtu = select.value;

                let rowHtml = '';
                switch (statusOrtu) {
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
                select.querySelector(`option[value="${statusOrtu}"]`).disabled = true;

                closeModalOrtu();
            }

            // Menambahkan event listener pada window untuk menutup modal jika pengguna mengklik di luar modal
            window.onclick = function(event) {
                const modal = document.getElementById('myModalOrtu');
                if (event.target === modal) {
                    closeModalOrtu();
                }
            }
        </script>

    </tbody>
</table>


<!-- <td>
                    <select id="status_keluarga_sub" name="status_keluarga_sub" class="status_keluarga_sub">
                        <option value="">Pilih...</option>
                        <option value="Strata 3">Strata 3</option>
                        <option value="Strata 2">Strata 2</option>
                        <option value="Strata 1">Strata 1</option>
                        <option value="Diploma 1/2/3">Diploma 1/2/3</option>
                        <option value="SMA">SMA</option>
                        <option value="SMP">SMP</option>
                        <option value="SD">SD</option>
                    </select>
                </td> -->
<!-- <script>
        // Function to add a new row to the table
        function familyStructure() {
            var tableBody = document.querySelector("#formTableFamily tbody");
            var newRow = document.createElement("tr");

            newRow.innerHTML = `
                <td>
                    <select class="status_keluarga_sub"  name="status_keluarga_sub" onchange="setGenderBasedOnStatus(this)">
                        <option value="">Pilih...</option>
                        <option value="Ayah">Ayah</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Anak">Anak</option>
                    </select>
                </td>
                <td><input type="text" name="nama" ></td>
                <td>
                    <select class="jenis_kelamin" name="jenis_kelamin" >
                        <option value="">Pilih...</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </td>
                <td><input type="text" name="tempat_lahir" ></td>
                <td><input type="date" name="tgl_lahir" ></td>
                <td><input type="text" name="pekerjaan" ></td>
            `;

            tableBody.appendChild(newRow);
            // Hide options based on the first row's selection
        }



        // Set gender based on selected status
        var jenisKelaminElement = selectElement.closest('tr').querySelector('.jenis_kelamin');
        if (selectElement.value === "Ayah") {
            jenisKelaminElement.value = "Laki-laki";
        } else if (selectElement.value === "Ibu") {
            jenisKelaminElement.value = "Perempuan";
        } else {
            jenisKelaminElement.value = "";
        }

        // Function to set gender based on status selection
        function setGenderBasedOnStatus(selectElement) {
            var jenisKelaminElement = selectElement.closest('tr').querySelector('.jenis_kelamin, .jenis_kelamin_awal');
            if (selectElement.value === "Ayah") {
                jenisKelaminElement.value = "Laki-laki";
            } else if (selectElement.value === "Ibu") {
                jenisKelaminElement.value = "Perempuan";
            } else {
                jenisKelaminElement.value = "";
            }
        }
    </script> -->
<!-- <table class="form-table" id="formTableFamily" style="margin-top: -30px;">
        <thead>
            <tr>
                <th style="width: 110px;">Status Keluarga<button type="button" onclick="familyStructure()" style="margin-left: 10px;">+</button></th>
                <th>Nama</th>
                <th style="width: 110px;">Jenis Kelamin</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" id="status_keluarga_sub" name="status_keluarga_sub" value="Ayah" readonly></td>
                <td><input type="text" id="nama" name="nama_ayah"></td>
                <td><input type="text" id="jk_ayah" name="jk_ayah" value="Laki-laki" readonly></td>
                <td><input type="text" id="tempat_lahir_ayah" name="tempat_lahir_ayah"></td>
                <td><input type="date" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah"></td>
                <td><input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah"></td>
            </tr>
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
        </tbody>
    </table> -->
<br>


<!-- <tr>
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
            </tr> -->
<!-- <script>
        // Function to add a new row to the table
        function familyStructure() {
            var tableBody = document.querySelector("#formTableFamily tbody");
            var newRow = document.createElement("tr");

            newRow.innerHTML = `
                <td>
                    <select class="status_keluarga_sub"  name="status_keluarga_sub" onchange="setGenderBasedOnStatus(this)">
                        <option value="">Pilih...</option>
                        <option value="Ayah">Ayah</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Anak">Anak</option>
                    </select>
                </td>
                <td><input type="text" name="nama" ></td>
                <td>
                    <select class="jenis_kelamin" name="jenis_kelamin" >
                        <option value="">Pilih...</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </td>
                <td><input type="text" name="tempat_lahir" ></td>
                <td><input type="date" name="tgl_lahir" ></td>
                <td><input type="text" name="pekerjaan" ></td>
            `;

            tableBody.appendChild(newRow);
            // Hide options based on the first row's selection
        }



        // Set gender based on selected status
        var jenisKelaminElement = selectElement.closest('tr').querySelector('.jenis_kelamin');
        if (selectElement.value === "Ayah") {
            jenisKelaminElement.value = "Laki-laki";
        } else if (selectElement.value === "Ibu") {
            jenisKelaminElement.value = "Perempuan";
        } else {
            jenisKelaminElement.value = "";
        }

        // Function to set gender based on status selection
        function setGenderBasedOnStatus(selectElement) {
            var jenisKelaminElement = selectElement.closest('tr').querySelector('.jenis_kelamin, .jenis_kelamin_awal');
            if (selectElement.value === "Ayah") {
                jenisKelaminElement.value = "Laki-laki";
            } else if (selectElement.value === "Ibu") {
                jenisKelaminElement.value = "Perempuan";
            } else {
                jenisKelaminElement.value = "";
            }
        }
    </script> -->

<!-- MENAMBAHKAN BARIS TABLE BARU di SUSUNAN KELUARGA -->
<!-- <script>


        var maxRows = 12; // Maximum number of rows
        var currentRows = 1; // Initially there is 1 row

        function addRow() {
            if (currentRows >= maxRows) {
                alert("Maksimal 12 baris tercapai.");
                document.getElementById("addRowButton").style.display = 'none';
                return;
            }

            var tableBody = document.getElementById("istriSuami");
            var newRow = tableBody.insertRow();

            var statusKeluargaCell = newRow.insertCell(0);
            var namaCell = newRow.insertCell(1);
            var jenisKelaminCell = newRow.insertCell(2);
            var tempatLahirCell = newRow.insertCell(3);
            var tanggalLahirCell = newRow.insertCell(4);
            var pekerjaanCell = newRow.insertCell(5);

            statusKeluargaCell.innerHTML = `
                <select id="status_keluarga" class="status_keluarga"  name="status_keluarga[]" onchange="updateJenisKelamin(this)">
                    <option value="">Pilih...</option>
                    <option value="Istri">Istri</option>
                    <option value="Suami">Suami</option>
                    <option value="Anak">Anak</option>
                </select>
            `;

            namaCell.innerHTML = `<input type="text" name="nama[]" >`;

            jenisKelaminCell.innerHTML = `
                <select name="jenis_kelamin_status_keluarga[]" >
                    <option value="">Pilih...</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            `;

            tempatLahirCell.innerHTML = `<input type="text" name="tempat_lahir[]" >`;

            tanggalLahirCell.innerHTML = `<input type="date" name="tgl_lahir[]" >`;

            pekerjaanCell.innerHTML = `<input type="text" name="pekerjaan[]" >`;

            currentRows++;

            if (currentRows >= maxRows) {
                document.getElementById("addRowButton").style.display = 'none';
            }
        }

        function updateJenisKelamin(selectElement) {
            var jenisKelaminSelect = selectElement.parentElement.nextElementSibling.nextElementSibling.firstElementChild;
            if (selectElement.value === "Istri") {
                jenisKelaminSelect.value = "Perempuan";
            } else if (selectElement.value === "Suami") {
                jenisKelaminSelect.value = "Laki-laki";
            } else {
                jenisKelaminSelect.value = ""; // Clear the selection for "Anak" or other values
            }
        }
    </script> -->
<!-- <td style="width: 200px;">
                <h4>Alamat Sekarang </h4>
                <select id="alamatDomisili" name="alamat_domisili" required>
                    <option type="radio" id="sesuaiKtp" name="alamat_domisili" value="Sesuai KTP">Sesuai KTP</option>
                    <option type="radio" id="tidakSesuaiKtp" name="alamat_domisili" value="Tidak Sesuai KTP">Tidak Sesuai KTP</option>
                </select>
            </td> -->