<?php
session_start();
require '../config/php/backend.php';
error_reporting(0);
// akses
$email = $_SESSION['email'];
$user = query("SELECT * FROM user WHERE Email = '$email'")[0];
$id_user = $user['id'];
$akses = query("SELECT * FROM akses WHERE id_user = '$id_user'")[0];
if (!isset($_SESSION['admin']) && $akses['Gallery'] == 'FALSE') {
    echo "<script>alert('akses ilegal');
    window.location='../config/php/logout.php'</script>";
    exit;
}
$id = $_GET['id_folder'];
$query = query("SELECT * FROM foto WHERE id_folder = '$id'");
$folder = query("SELECT * FROM folder WHERE id = '$id' ")[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon.png">
    <link rel="icon" type="image/pn g" href="../img/favicon.png">
    <title>
        JB Pay || Detail Foto
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../css/nucleo-icons.css" rel="stylesheet" />
    <link href="../css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><a class="opacity-5 text-dark" <?php if ($akses['Gallery'] == 'TRUE') {
                                                                                                                                    echo "href='../../dashboard/'";
                                                                                                                                } else {
                                                                                                                                    echo "href='../../admin/'";
                                                                                                                                }; ?>>Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Gallery</li>
                    </ol>
                    <h6 class="font-weight-bolder mb-0">Detail Foto</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <a href="./add.foto.php?id=<?= $id ?>"><button class="btn btn-success ms-4 mt-3"><i class="d-flex justify-content-center  material-icons opacity-100">add</i></button></a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navbar -->
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <!-- real -->
                <div class="d-flex justify-content-center col-12 my-4">
                    <div class="card p-4">
                        <h4 class="d-flex justify-content-center mt-3">Folder Detail</h4>
                        <hr class="dark horizontal mt-2 mb-4 my-0">
                        <table style="font-size:larger">
                            <tr>
                                <td>
                                    <strong>Id</strong>
                                </td>
                                <td>&nbsp;:&nbsp;&nbsp;</td>
                                <td><?= $id ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Nama Folder</strong>
                                </td>
                                <td>&nbsp;:&nbsp;&nbsp;</td>
                                <td><?= $folder['Nama_Folder'] ?></td>
                            </tr>
                        </table>
                        <hr class="dark horizontal mt-4 mb-2 my-0">
                        <footer>
                            <div class="back">
                                <a <?php if ($akses['Gallery'] == 'TRUE') {
                                        echo "href='../../dashboard/gallery.php'";
                                    } else {
                                        echo "href='../../admin/gallery.php'";
                                    }; ?>>
                                    Back
                                </a>
                            </div>
                        </footer>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="d-flex justify-content-start text-white text-capitalize ps-3">Foto</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div id="container" class=" table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-black font-weight-bolder">No</th>
                                            <th class="text-center text-uppercase text-black font-weight-bolder">Foto</th>
                                            <th class="text-center text-uppercase text-black font-weight-bolder">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($query as $row) : ?>
                                            <tr>
                                                <td class="text-center text-black"><?= $i ?></td>
                                                <td class="text-center text-black"><img style="max-width: 200px; max-height:200px;" src="../gallery/<?= $row['foto'] ?>" alt=""></td>
                                                <td class="text-center text-black">
                                                    <a onclick="return confirm('Yakin ingin menghapus foto?')" href="./delete.foto.php?id_foto=<?= $row['id_foto'] ?>&id_folder=<?= $row['id_folder'] ?>"><i class=" material-icons opacity-100">delete</i></a>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer py-4  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                                for a better web.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <!-- seting ui -->
    <!--   Core JS Files   -->
    <script src="../js/core/popper.min.js"></script>
    <script src="../js/core/bootstrap.min.js"></script>
    <script src="../js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="../config/js/user.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>