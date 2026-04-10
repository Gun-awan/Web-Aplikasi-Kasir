<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Finance</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="style/main.css">

    <style>
        .finance-grid {
            display: grid;
            gap: 20px;
      grid-template-columns: repeat(3, 1fr);
        }

        .finance-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            padding: 20px;
            height: 432px;
        }

        .finance-card h3 {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: rgb(25, 27, 25);
            color: white;
        }

        .export-btn {
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-right: 10px;
        }

        .pdf {
            background: #dc3545;
            color: white;
        }

        .judul {
            height: 72px;
        }

        .export-btn {
            margin-bottom: 10px;
        }

        .sidebar-menu a:hover {
            background: #ffffff88;
            color: rgb(25, 27, 25);
            border-radius: 30px 0px 0px 30px;
        }

        .judul span {
            padding-right: 25px;
        }

        .excel {
            background: #198754;
            color: white;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-accusoft"></span>The Cashier</h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="dashboard.php"><span class="las la-igloo"></span>
                        <span> Dashboard</span></a></li>
                <li>
                    <a href="barang.php"> <span class="las la-clipboard-list"></span>
                        <span>Produk</span></a>
                </li>
                <li>
                    <a href="antrian.php"> <span class="las la-shopping-bag"></span>
                        <span>Order</span></a>
                </li>
                <li>
                    <a href="index.php"> <span class="las la-receipt"></span>
                        <span>Cashier</span></a>
                </li>
                <li><a href="finance.php" class="active"><span class="las la-money-bill-wave">
                        </span><span> Finance</span></a></li>
                <li>
                    <a href=""> <span class="las la-user-circle"></span>
                        <span>Account</span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">

        <header class="judul">
            <h2><span class="las la-money-bill-wave"></span>Finance</h2>
        </header>

        <main>

            <button class="export-btn pdf">Convert PDF</button>
            <button class="export-btn excel">Convert Excel</button>

            <div class="finance-grid">

                <div class="finance-card">
                    <h3>Income Harian (1 Bulan)</h3>
                    <table>
                        <tr>
                            <th>Tanggal</th>
                            <th>Penghasilan</th>
                        </tr>
                        <tr>
                            <td>1 Maret</td>
                            <td>Rp 1.000.000</td>
                        </tr>
                        <tr>
                            <td>2 Maret</td>
                            <td>Rp 1.250.000</td>
                        </tr>
                    </table>
                </div>

                <div class="finance-card">
                    <h3>Income Bulanan (1 Tahun)</h3>
                    <table>
                        <tr>
                            <th>Bulan</th>
                            <th>Penghasilan</th>
                        </tr>
                        <tr>
                            <td>Januari</td>
                            <td>Rp 20.000.000</td>
                        </tr>
                    </table>
                </div>

                <div class="finance-card">
                    <h3>Income Tahunan</h3>
                    <table>
                        <tr>
                            <th>Tahun</th>
                            <th>Penghasilan</th>
                        </tr>
                        <tr>
                            <td>2026</td>
                            <td>Rp 240.000.000</td>
                        </tr>
                    </table>
                </div>

            </div>

        </main>
    </div>

</body>

</html>