<!DOCTYPE html>
<html>

<head>
    <title>Tahap Klasifikasi Step 2 Data Dengan Algoritma Naive Bayes</title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
</head>

<body>
    <table class="table table-bordered table-striped">
        <td colspan="3">
            <button onclick="goBack()">Kembali Ke Form Input Link</button>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </td>
    </table>
    <br>
    <?php
    require_once "Koneksi_2211501073.php";

    $sql_2211501073_Fajar_Sidik = "SELECT
    data_bersih,
    id_predicted,
    COALESCE(
        (SELECT nm_kategori FROM kategori_2211501073 WHERE id_kategori = id_predicted),
        '<span style=''color:red;''><em>Kategori tidak ditemukan</em><span>'
    ) AS nm_kategori
FROM
    classify_2211501073";

    $result4_2211501073_Fajar_Sidik = $conn_2211501073_Fajar_Sidik->query($sql_2211501073_Fajar_Sidik);

    // $sql_2211501073_Fajar_Sidik = "INSERT INTO classify_2211501073 (data_bersih)
    // SELECT data_bersih
    // FROM preprocessing_2211501073
    // WHERE id_kategori IS NULL
    // AND data_bersih NOT IN (SELECT data_bersih FROM classify_2211501073)";

    // $resultInsert2_2211501073_Fajar_Sidik = $conn_2211501073_Fajar_Sidik->query($sql_2211501073_Fajar_Sidik);

    ?>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <br><br>
            <tr></tr>
            <tr>
                <td colspan="5"><strong>Menentukan Kategori Aktual</strong></td>
            </tr>
            <tr bgcolor="#CCCCCC">
                <th>No.</th>
                <th>Data Bersih</th>
                <th>Prediksi Kategori</th>
                <th>Aktual Kategori</th>
            </tr>
        </thead>
        <?php
        $i_2211501073_Fajar_Sidik = 1;
        while ($d_2211501073_Fajar_Sidik = mysqli_fetch_array($result4_2211501073_Fajar_Sidik)) {
        ?>
            <tr bgcolor="#FFFFFF">
                <td><?php echo $i_2211501073_Fajar_Sidik; ?></td>
                <td><?php echo $d_2211501073_Fajar_Sidik[0]; ?></td>
                <td><?php echo $d_2211501073_Fajar_Sidik[2]; ?></td>
                <td>
                    <select id="kategori" name="kategori">
                        <option value="">Pilih kategori</option>
                        <?php
                        // Mengambil data kategori dari tabel kategori_2211501073
                        $sql_kategori = "SELECT nm_kategori FROM kategori_2211501073";
                        $result_kategori = $conn_2211501073_Fajar_Sidik->query($sql_kategori);

                        // Menampilkan data kategori sebagai opsi dropdown
                        while ($row_kategori = mysqli_fetch_array($result_kategori)) {
                            echo "<option value='" . $row_kategori['nm_kategori'] . "'>" . $row_kategori['nm_kategori'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        <?php
            $i_2211501073_Fajar_Sidik = $i_2211501073_Fajar_Sidik + 1;
        }

        ?>
    </table>
    <form style="text-align: center;" action="#" method="get">
        <input type="submit" value="Simpan Data">
        <br><br>
    </form>




//////////////////////////////////////

<?php

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        // Memproses form jika data dikirimkan melalui metode GET
                        if (isset($_GET['kategori'])) {
                            $kategori_terpilih = $_GET['kategori'];

                            // Mengambil id_kategori berdasarkan nm_kategori yang dipilih
                            $sql_id_kategori = "SELECT id_kategori FROM kategori_2211501073 WHERE nm_kategori = '$kategori_terpilih'";
                            $result_id_kategori = $conn_2211501073_Fajar_Sidik->query($sql_id_kategori);

                            if ($result_id_kategori->num_rows > 0) {
                                $row_id_kategori = $result_id_kategori->fetch_assoc();
                                $id_actual = $row_id_kategori['id_kategori'];

                                // Update kolom id_actual pada tabel classify_2211501073 dengan nilai yang dipilih
                                $sql_update_actual = "UPDATE classify_2211501073 SET id_actual = '$id_actual' WHERE data_bersih = '$kategori_terpilih'";
                                $result_update_actual = $conn_2211501073_Fajar_Sidik->query($sql_update_actual);

                                if ($result_update_actual) {
                                    echo "Data berhasil disimpan.";
                                } else {
                                    echo "Error: " . $conn_2211501073_Fajar_Sidik->error;
                                }
                            }
                        }
                    }
                    ?>
