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
   <h4 style="margin-top: -20px;">Susunan Keluarga (ayah/ibu/saudara kandung)</h4>

   <table class="form-table" id="formTablePendidikan" style="margin-top: -30px;">
     <thead>
       <tr>
         <th>Jenjang Pendidikan <button type="button" id="addRowPend" onclick="showModalPendidikan()" style="margin-left: 10px;">+</button></th>
         <th>Nama Institusi</th>
         <th>Fakultas/Jurusan</th>
         <th style="width: 175px;">Periode Tahun</th>
         <th>Keterangan</th>
       </tr>
     </thead>
     <style>
       .modal-pendidikan {
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

       .modal-content-pendidikan {
         background-color: #fefefe;
         margin: 5% auto;
         padding: 20px;
         border: 1px solid #888;
         width: 20%;
         height: 30%;
       }

       .close-pendidikan {
         color: #aaa;
         float: right;
         font-size: 28px;
         font-weight: bold;
       }

       .close-pendidikan:hover,
       .close-pendidikan:focus {
         color: black;
         text-decoration: none;
         cursor: pointer;
       }
     </style>

     <tbody id="familyTablePendidikan">
       <!-- isi form data riwayat pendidikan -->

       <!-- Modal -->
       <div id="myModalPendidikan" class="modal-pendidikan">
         <div class="modal-content-pendidikan">
           <span class="close-pendidikan" onclick="closeModalPendidikan()">&times;</span>
           <h2 style="margin-top: -3px;">Pilih Status Keluarga</h2>
           <select id="statusKeluargaPendidikanSelect">
             <option value="">Pilih...</option>
             <option value="Strata 3">Strata 3</option>
             <option value="Strata 2">Strata 2</option>
             <option value="Strata 1">Strata 1</option>
             <option value="Diploma 1/2/3">Diploma 1/2/3</option>
             <option value="SMA">SMA</option>
             <option value="SMP">SMP</option>
             <option value="SD">SD</option>
           </select>
           <button type="button" onclick="addRowPendidikan()">Tambah</button>
         </div>
       </div>

       <script>
         // JavaScript untuk membuka dan menutup modal
         function showModalPendidikan() {
           document.getElementById('myModalPendidikan').style.display = 'block';
         }

         function closeModalPendidikan() {
           document.getElementById('myModalPendidikan').style.display = 'none';
         }

         // JavaScript untuk menambahkan baris baru ke tabel berdasarkan pilihan
         function addRowPendidikan() {
           const table = document.getElementById('familyTablePendidikan');
           const select = document.getElementById('statusKeluargaPendidikanSelect');
           const statusPendidikan = select.value;

           let rowHtml = '';
           switch (statusPendidikan) {
             case 'Strata 3':
               rowHtml = `
                        <tr>
                          <td>
                            <input type="text" id="jenjang_s3" value="Strata 3">
                          </td>
                          <td><input type="text" id="nama_institusi_s3" name="nama_institusi_s3"></td>
                          <td><input type="text" id="nama_fakultas_s3" name="nama_fakultas_s3"></td>
                          <td>
                            <select id="tahun_awal_s3" name="tahun_awal_s3" style="width: 70px;">
                              <option value="">Dari</option>
                              <?php
                              for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                              }
                              ?>
                            </select>
                            <span style="font-size: 20px;"> - </span>
                            <select id="tahun_akhir_s3" name="tahun_akhir_s3" style="width: 85px;">
                              <option value="">Sampai</option>
                              <?php
                              for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                              }
                              ?>
                            </select>
                          </td>
                          <td><input type="text" id="keterangan_s3" name="keterangan_s3"></td>
                        </tr>
                    `;
               break;
             case 'Strata 2':
               rowHtml = `
                        <tr>
                          <td>
                            <input type="text" id="jenjang_s2" value="Strata 2">
                          </td>
                          <td><input type="text" id="nama_institusi_s2" name="nama_institusi_s2"></td>
                          <td><input type="text" id="nama_fakultas_s2" name="nama_fakultas_s2"></td>
                          <td>
                            <select id="tahun_awal_s2" name="tahun_awal_s2" style="width: 70px;">
                              <option value="">Dari</option>
                              <?php
                              for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                              }
                              ?>
                            </select>
                            <span style="font-size: 20px;"> - </span>
                            <select id="tahun_akhir_s2" name="tahun_akhir_s2" style="width: 85px;">
                              <option value="">Sampai</option>
                              <?php
                              for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                              }
                              ?>
                            </select>
                          </td>
                          <td><input type="text" id="keterangan_s2" name="keterangan_s2"></td>
                        </tr>
                    `;
               break;
             case 'Strata 1':
               rowHtml = `
                        <tr>
                          <td>
                            <input type="text" id="jenjang_s1" value="Strata 1">
                          </td>
                          <td><input type="text" id="nama_institusi_s1" name="nama_institusi_s1"></td>
                          <td><input type="text" id="nama_fakultas_s1" name="nama_fakultas_s1"></td>
                          <td>
                            <select id="tahun_awal_s1" name="tahun_awal_s1" style="width: 70px;">
                              <option value="">Dari</option>
                              <?php
                              for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                              }
                              ?>
                            </select>
                            <span style="font-size: 20px;"> - </span>
                            <select id="tahun_akhir_s1" name="tahun_akhir_s1" style="width: 85px;">
                              <option value="">Sampai</option>
                              <?php
                              for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                              }
                              ?>
                            </select>
                          </td>
                          <td><input type="text" id="keterangan_s1" name="keterangan_s1"></td>
                        </tr>
                    `;
               break;
             case 'Diploma 1/2/3':
               rowHtml = `
                        <tr>
                          <td>
                            <input type="text" id="jenjang_diploma" value="Diploma 1/2/3">
                          </td>
                          <td><input type="text" id="nama_institusi_diploma" name="nama_institusi_diploma"></td>
                          <td><input type="text" id="nama_fakultas_diploma" name="nama_fakultas_diploma"></td>
                          <td>
                            <select id="tahun_awal_diploma" name="tahun_awal_diploma" style="width: 70px;">
                              <option value="">Dari</option>
                              <?php
                              for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                              }
                              ?>
                            </select>
                            <span style="font-size: 20px;"> - </span>
                            <select id="tahun_akhir_diploma" name="tahun_akhir_diploma" style="width: 85px;">
                              <option value="">Sampai</option>
                              <?php
                              for ($i = 1970; $i <= 2024; $i++) {
                                echo "<option value='$i'>$i</option>";
                              }
                              ?>
                            </select>
                          </td>
                          <td><input type="text" id="keterangan_diploma" name="keterangan_diploma"></td>
                        </tr>
                    `;
               break;
             case 'SMA':
               rowHtml = `
                            <tr>
                              <td>
                                <input type="text" id="jenjang_sma" value="SMA">
                              </td>
                              <td><input type="text" id="nama_institusi_sma" name="nama_institusi_sma"></td>
                              <td><input type="text" id="nama_fakultas_sma" name="nama_fakultas_sma"></td>
                              <td>
                                <select id="tahun_awal_sma" name="tahun_awal_sma" style="width: 70px;">
                                  <option value="">Dari</option>
                                  <?php
                                  for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                  }
                                  ?>
                                </select>
                                <span style="font-size: 20px;"> - </span>
                                <select id="tahun_akhir_sma" name="tahun_akhir_sma" style="width: 85px;">
                                  <option value="">Sampai</option>
                                  <?php
                                  for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                  }
                                  ?>
                                </select>
                              </td>
                              <td><input type="text" id="keterangan_sma" name="keterangan_sma"></td>
                            </tr>
                    `;
               break;
             case 'SMP':
               rowHtml = `
                            <tr>
                              <td>
                                <input type="text" id="jenjang_smp" value="SMP">
                              </td>
                              <td><input type="text" id="nama_institusi_smp" name="nama_institusi_smp"></td>
                              <td></td>
                              <td>
                                <select id="tahun_awal_smp" name="tahun_awal_smp" style="width: 70px;">
                                  <option value="">Dari</option>
                                  <?php
                                  for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                  }
                                  ?>
                                </select>
                                <span style="font-size: 20px;"> - </span>
                                <select id="tahun_akhir_smp" name="tahun_akhir_smp" style="width: 85px;">
                                  <option value="">Sampai</option>
                                  <?php
                                  for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                  }
                                  ?>
                                </select>
                              </td>
                              <td><input type="text" id="keterangan_smp" name="keterangan_smp"></td>
                            </tr>
                    `;
               break;
             case 'SD':
               rowHtml = `
                            <tr>
                              <td>
                                <input type="text" id="jenjang_sd" value="SD">
                              </td>
                              <td><input type="text" id="nama_institusi_sd" name="nama_institusi_sd"></td>
                              <td></td>
                              <td>
                                <select id="tahun_awal_sd" name="tahun_awal_sd" style="width: 70px;">
                                  <option value="">Dari</option>
                                  <!-- Isi dengan opsi tahun yang diinginkan -->
                                  <?php
                                  for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                  }
                                  ?>
                                </select>
                                <span style="font-size: 20px;"> - </span>
                                <select id="tahun_akhir_sd" name="tahun_akhir_sd" style="width: 85px;">
                                  <option value="">Sampai</option>
                                  <!-- Isi dengan opsi tahun yang diinginkan -->
                                  <?php
                                  for ($i = 1970; $i <= 2024; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                  }
                                  ?>
                                </select>
                              </td>
                              <td><input type="text" id="keterangan_sd" name="keterangan_sd"></td>
                            </tr>
                    `;
               break;
           }

           table.insertAdjacentHTML('beforeend', rowHtml);

           // Disable the selected option
           select.querySelector(`option[value="${statusPendidikan}"]`).disabled = true;

           closeModalPendidikan();
         }

         // Menambahkan event listener pada window untuk menutup modal jika pengguna mengklik di luar modal
         window.onclick = function(event) {
           const modal = document.getElementById('myModalPendidikan');
           if (event.target === modal) {
             closeModalPendidikan();
           }
         }
       </script>


     </tbody>
   </table>

       <table class="form-table" id="formTablePendidikan" style="margin-top: -30px;">
        <thead>
            <tr>
                <th>Jenjang Pendidikan <button type="button" onclick="addRowPendidikan()" style="margin-left: 10px;">+</button></th>
                <th>Nama Institusi</th>
                <th>Fakultas/Jurusan</th>
                <th style="width: 175px;">Periode Tahun</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>

            <!-- STRATA 3 -->
            <tr>

                <td>
                    <input type="text" id="jenjang_s3" value="Strata 3">
                </td>
                <td><input type="text" id="nama_institusi_s3" name="nama_institusi_s3"></td>
                <td><input type="text" id="nama_fakultas_s3" name="nama_fakultas_s3"></td>
                <td>
                    <select id="tahun_awal_s3" name="tahun_awal_s3" style="width: 70px;">
                        <option value="">Dari</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <span style="font-size: 20px;"> - </span>
                    <select id="tahun_akhir_s3" name="tahun_akhir_s3" style="width: 85px;">
                        <option value="">Sampai</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" id="keterangan_s3" name="keterangan_s3"></td>
            </tr>

            <!-- STRATA 2 -->
            <tr>
                <td>
                    <input type="text" id="jenjang_s2" value="Strata 2">
                </td>
                <td><input type="text" id="nama_institusi_s2" name="nama_institusi_s2"></td>
                <td><input type="text" id="nama_fakultas_s2" name="nama_fakultas_s2"></td>
                <td>
                    <select id="tahun_awal_s2" name="tahun_awal_s2" style="width: 70px;">
                        <option value="">Dari</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <span style="font-size: 20px;"> - </span>
                    <select id="tahun_akhir_s2" name="tahun_akhir_s2" style="width: 85px;">
                        <option value="">Sampai</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" id="keterangan_s2" name="keterangan_s2"></td>
            </tr>

            <!-- STRATA 1 -->
            <tr>
                <td>
                    <input type="text" id="jenjang_s1" value="Strata 1">
                </td>
                <td><input type="text" id="nama_institusi_s1" name="nama_institusi_s1"></td>
                <td><input type="text" id="nama_fakultas_s1" name="nama_fakultas_s1"></td>
                <td>
                    <select id="tahun_awal_s1" name="tahun_awal_s1" style="width: 70px;">
                        <option value="">Dari</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <span style="font-size: 20px;"> - </span>
                    <select id="tahun_akhir_s1" name="tahun_akhir_s1" style="width: 85px;">
                        <option value="">Sampai</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" id="keterangan_s1" name="keterangan_s1"></td>
            </tr>

            <!-- DIPLOMA 1/2/3 -->
            <tr>
                <td>
                    <input type="text" id="jenjang_diploma" value="Diploma 1/2/3">
                </td>
                <td><input type="text" id="nama_institusi_diploma" name="nama_institusi_diploma"></td>
                <td><input type="text" id="nama_fakultas_diploma" name="nama_fakultas_diploma"></td>
                <td>
                    <select id="tahun_awal_diploma" name="tahun_awal_diploma" style="width: 70px;">
                        <option value="">Dari</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <span style="font-size: 20px;"> - </span>
                    <select id="tahun_akhir_diploma" name="tahun_akhir_diploma" style="width: 85px;">
                        <option value="">Sampai</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" id="keterangan_diploma" name="keterangan_diploma"></td>
            </tr>

            <!-- SMA -->
            <tr>
                <td>
                    <input type="text" id="jenjang_sma" value="SMA">
                </td>
                <td><input type="text" id="nama_institusi_sma" name="nama_institusi_sma"></td>
                <td><input type="text" id="nama_fakultas_sma" name="nama_fakultas_sma"></td>
                <td>
                    <select id="tahun_awal_sma" name="tahun_awal_sma" style="width: 70px;">
                        <option value="">Dari</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <span style="font-size: 20px;"> - </span>
                    <select id="tahun_akhir_sma" name="tahun_akhir_sma" style="width: 85px;">
                        <option value="">Sampai</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" id="keterangan_sma" name="keterangan_sma"></td>
            </tr>

            <!-- SMP -->
            <tr>
                <td>
                    <input type="text" id="jenjang_smp" value="SMP">
                </td>
                <td><input type="text" id="nama_institusi_smp" name="nama_institusi_smp"></td>
                <td></td>
                <td>
                    <select id="tahun_awal_smp" name="tahun_awal_smp" style="width: 70px;">
                        <option value="">Dari</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <span style="font-size: 20px;"> - </span>
                    <select id="tahun_akhir_smp" name="tahun_akhir_smp" style="width: 85px;">
                        <option value="">Sampai</option>
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" id="keterangan_smp" name="keterangan_smp"></td>
            </tr>

            <!-- SD -->
            <tr>
                <td>
                    <input type="text" id="jenjang_sd" value="SD">
                </td>
                <td><input type="text" id="nama_institusi_sd" name="nama_institusi_sd"></td>
                <td></td>
                <td>
                    <select id="tahun_awal_sd" name="tahun_awal_sd" style="width: 70px;">
                        <option value="">Dari</option>
                        <!-- Isi dengan opsi tahun yang diinginkan -->
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                    <span style="font-size: 20px;"> - </span>
                    <select id="tahun_akhir_sd" name="tahun_akhir_sd" style="width: 85px;">
                        <option value="">Sampai</option>
                        <!-- Isi dengan opsi tahun yang diinginkan -->
                        <?php
                        for ($i = 1970; $i <= 2024; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" id="keterangan_sd" name="keterangan_sd"></td>
            </tr>
        </tbody>
    </table>