<?php
$konek = mysqli_connect('localhost', 'root', '', 'paylater');

function query($query)
{
    global $konek;
    $result = mysqli_query($konek, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
// function input chat
function chat($data)
{
    global $konek;
    $Email = $data['Email'];
    $waktu = $data['waktu'];
    $pesan = $data['message'];
    $query = "INSERT INTO chat VALUES('','$Email','$pesan','$waktu')";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
//  function hadir
function hadir($data)
{
    global $konek;
    $lokasi = $data['id_lokasi'];
    $email = $data['email'];
    $hadir = $data['kehadiran'];
    $query = "INSERT INTO kehadiran VALUES('','$lokasi','$email','$hadir')";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function add event
function addevent($data)
{
    global $konek;
    $lokasi = $data['lokasi'];
    $daerah = $data['daerah'];
    $tanggal = $data['tgl'];
    $waktu = $data['waktu'];
    $biaya = $data['biaya'];
    $dress = $data['dress'];
    $tikum = $data['tikum'];
    $kegiatan = $data['kegiatan'];
    $map =  mysqli_real_escape_string($konek, $data['link']);
    $query = "INSERT INTO lokasi VALUES('','$lokasi','$daerah','$tanggal','$waktu','$dress','$biaya','$tikum','$map','$kegiatan')";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function update event
function updateevent($data)
{
    global $konek;
    $id = $data['id'];
    $lokasi = $data['lokasi'];
    $daerah = $data['daerah'];
    $tanggal = $data['tgl'];
    $waktu = $data['waktu'];
    $biaya = $data['biaya'];
    $dress = $data['dress'];
    $tikum = $data['tikum'];
    $kegiatan = $data['kegiatan'];
    $map =  mysqli_real_escape_string($konek, $data['link']);
    $query = "UPDATE lokasi SET Lokasi = '$lokasi', Daerah = '$daerah', tanggal = '$tanggal', waktu = '$waktu', dress='$dress',Biaya='$biaya',tikum = '$tikum', Kegiatan = '$kegiatan', Map = '$map' WHERE Id_lokasi = '$id'";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function delete event 
function deleteevent($data)
{
    global $konek;
    $id = $data['id'];
    $query = "DELETE FROM lokasi WHERE Id_lokasi = '$id'";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
//  function edit hadir
function ubahhadir($data)
{
    global $konek;
    $id = $data['id'];
    $hadir = $data['kehadiran'];
    $query = "UPDATE kehadiran SET kehadiran = '$hadir' WHERE Id_kehadiran = '$id'";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// add hutang user
function adduser($data)
{
    global $konek;
    $user = $data['user'];
    $lokasi = $data['lokasi'];
    $hutang = $data['hutang'];
    $bayar = $data['bayar'];
    $confirm = $data['metode'];
    $confirm2 = $data['transaksi'];
    $keterangan = $data['ket'];
    if ($lokasi == 'bkn') {
        echo "
        <script>
        alert('insert valid value')
        </script>
        ";
        return false;
    }
    if ($confirm == 'ada' && $confirm2 == 'gk') {
        $pembayaran = bukti();
        $query = "INSERT INTO hutang VALUES('','$user','$lokasi','$hutang','$bayar','$pembayaran','','$keterangan')";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
    } elseif ($confirm == 'gk' && $confirm2 == 'ada') {
        $transaksi = transaksi();
        $query = "INSERT INTO hutang VALUES('','$user','$lokasi','$hutang','$bayar','','$transaksi','$keterangan')";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
    } elseif ($confirm == 'ada' && $confirm2 == 'ada') {
        $transaksi = transaksi();
        $pembayaran = bukti();
        $query = "INSERT INTO hutang VALUES('','$user','$lokasi','$hutang','$bayar','$pembayaran','$transaksi','$keterangan')";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
    } elseif ($confirm == 'old' && $confirm2 == 'ada') {
        $transaksi = transaksi();
        $old_bukti = $data['old_bukti'];
        $query = "INSERT INTO hutang VALUES('','$user','$lokasi','$hutang','$bayar','$old_bukti','$transaksi','$keterangan')";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
    } elseif ($confirm == 'ada' && $confirm2 == 'old') {
        $pembayaran = bukti();
        $old_transaksi = $data['old_transaki'];
        $query = "INSERT INTO hutang VALUES('','$user','$lokasi','$hutang','$bayar','$pembayaran','$old_transaksi','$keterangan')";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
    } elseif ($confirm == 'gk' && $confirm2 == 'old') {
        $old_transaksi = $data['old_transaki'];
        $query = "INSERT INTO hutang VALUES('','$user','$lokasi','$hutang','$bayar','','$old_transaksi','$keterangan')";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
    } elseif ($confirm == 'old' && $confirm2 == 'gk') {
        $old_bukti = $data['old_bukti'];
        $query = "INSERT INTO hutang VALUES('','$user','$lokasi','$hutang','$bayar','$old_bukti','','$keterangan')";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
    } elseif ($confirm == 'old' && $confirm2 == 'old') {
        $old_transaksi = $data['old_transaki'];
        $old_bukti = $data['old_bukti'];
        $query = "INSERT INTO hutang VALUES('','$user','$lokasi','$hutang','$bayar','$old_bukti','$old_transaksi','$keterangan')";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
    } else {
        $query = "INSERT INTO hutang VALUES('','$user','$lokasi','$hutang','$bayar','','','$keterangan')";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
    }
    exit;
}
// edit hutang user
function edituser($data)
{
    global $konek;
    $id = $data['id'];
    $user = $data['user'];
    $lokasi = $data['lokasi'];
    $hutang = $data['hutang'];
    $bayar = $data['bayar'];
    $confirm = $data['metode'];
    $keterangan = $data['ket'];
    if ($lokasi == 'bkn') {
        echo "
        <script>
        alert('insert valid value')
        </script>
        ";
        return false;
    }
    if ($confirm == 'ada') {
        $gambarlama = $data["buktiold"];
        if ($_FILES['bukti']['error'] === 4) {
            $gambar = $gambarlama;
        } else {
            $gambar = bukti();
        }
        $query = "UPDATE hutang SET Id_user = '$user', Id_tempat = '$lokasi', hutang= '$hutang', bayar='$bayar',bukti = '$gambar', keterangan = '$keterangan' WHERE Id_hutang = '$id'";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
        exit;
    }
    $query = "UPDATE hutang SET Id_user = '$user', Id_tempat = '$lokasi', hutang= '$hutang', bayar='$bayar', keterangan = '$keterangan' WHERE Id_hutang = '$id'";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
    exit;
}
// function update profile
function Uprofile($data)
{
    global $konek;
    $id = $data["id"];
    $nama = $data["nama"];
    $usernama = $data["username"];
    $passwordold = $data['passwordold'];
    $pw = $data['pw1'];
    $pw2 = $data['pw2'];
    if ($pw !== $pw2) {
        echo "
        <script>
        alert('password baru berbeda')
        </script>
        ";
        return false;
    }
    $result = mysqli_query($konek, "SELECT * FROM user WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);
    $result2 = mysqli_query($konek, "SELECT UserName FROM user WHERE UserName = '$usernama' AND id != '$id'");
    if (mysqli_fetch_assoc($result2)) {
        echo "
        <script>
        alert('username sudah di sudah digunakan')
        </script>
        ";
        return false;
    }
    $gambarlama = ($data["oldgambar"]);
    if ($_FILES['img']['error'] === 4) {
        $gambar = $gambarlama;
    } else {
        $gambar = foto_profile();
    }
    if ($passwordold != NULL) {
        if (password_verify($passwordold, $row['Password'])) {
            $password = password_hash($pw, PASSWORD_DEFAULT);
            $query = "UPDATE user SET Password ='$password', Username = '$usernama',Nama = '$nama', gambar='$gambar' WHERE id= '$id' ";
            mysqli_query($konek, $query);
            return mysqli_affected_rows($konek);
            exit;
        } else {
            echo "
            <script>
            alert('password lama beda')
            </script>
            ";
        }
    }
    $query = "UPDATE user SET Username = '$usernama',Nama = '$nama', gambar='$gambar' WHERE id= '$id' ";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function update profile admin
function Uprofileadmin($data)
{
    global $konek;
    $id = $data["id"];
    $nama = $data["nama"];
    $usernama = $data["username"];
    $pw = $data['pw1'];
    $pw2 = $data['pw2'];
    $role = $data['role'];
    if ($pw !== $pw2) {
        echo "
        <script>
        alert('password baru berbeda')
        </script>
        ";
        return false;
    }
    $result2 = mysqli_query($konek, "SELECT UserName FROM user WHERE UserName = '$usernama' AND id != '$id'");
    if (mysqli_fetch_assoc($result2)) {
        echo "
        <script>
        alert('username sudah di sudah digunakan')
        </script>
        ";
        return false;
    }
    if ($pw != NULL) {
        $password = password_hash($pw, PASSWORD_DEFAULT);
        $query = "UPDATE user SET lvl='$role', Password = '$password', Username = '$usernama', Nama = '$nama' WHERE id= '$id' ";
        mysqli_query($konek, $query);
        return mysqli_affected_rows($konek);
        exit;
    }
    $query = "UPDATE user SET lvl='$role', Username = '$usernama', Nama = '$nama' WHERE id= '$id' ";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function add foto
function addfoto($data)
{
    global $konek;
    $id_folder = $data['folder'];
    $gambar = foto();
    $query = "INSERT INTO foto VALUES('','$id_folder','$gambar')";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function add folder
function addfolder($data)
{
    global $konek;
    $nama = $data['nama'];
    $link = $data['link'];
    $query = "INSERT INTO folder VALUES('','$nama','$link')";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function edit folder
function Editfolder($data)
{
    global $konek;
    $id_folder = $data['id_folder'];
    $nama = $data['nama'];
    $link = $data['link'];
    $query = "UPDATE folder SET Nama_Folder = '$nama', link = '$link' WHERE id = '$id_folder' ";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function edit season
function editseason($data)
{
    global $konek;
    $id = $data['id'];
    $season = $data['season'];
    $tgl = $data['tgl'];
    $bulan = $data['bulan'];
    $tahun = $data['tahun'];
    if ($bulan == 'bkn') {
        echo "
        <script>
        alert('insert valid value')
        </script>
        ";
        return false;
    }
    $query = "UPDATE deadline SET tanggal ='$tgl',bulan ='$bulan',season ='$season',tahun = '$tahun' WHERE id = '$id'";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function edit season
function addseason($data)
{
    global $konek;
    $season = $data['season'];
    $tgl = $data['tgl'];
    $bulan = $data['bulan'];
    $tahun = $data['tahun'];
    if ($bulan == 'bkn') {
        echo "
        <script>
        alert('insert valid value')
        </script>
        ";
        return false;
    }
    $query = "INSERT INTO deadline VALUES('','$tgl','$bulan','$tahun','$season')";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function add akses
function addakses($data)
{
    global $konek;
    $user = $data['user'];
    $event = $data['event'];
    $gallery = $data['gallery'];
    if ($user == "bkn") {
        echo "
        <script>
        alert('insert valid value')
        </script>
        ";
        return false;
    }
    $result2 = mysqli_query($konek, "SELECT id_user FROM akses WHERE id_user = '$user'");
    if (mysqli_fetch_assoc($result2)) {
        echo "
        <script>
        alert('User telah memiliki akses')
        </script>
        ";
        return false;
    }
    $query = "INSERT INTO akses VALUES('','$user','$event','$gallery')";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// function edit akses
function editakses($data)
{
    global $konek;
    $id = $data['id'];
    $event = $data['event'];
    $gallery = $data['gallery'];
    $query = "UPDATE akses SET Event = '$event', Gallery = '$gallery' WHERE id_akses = '$id'";
    mysqli_query($konek, $query);
    return mysqli_affected_rows($konek);
}
// 
//  FUNCTION Gambar
// 
// function profile
function foto_profile()
{
    $namafile = $_FILES['img']['name'];
    $ukuranfile = $_FILES['img']['size'];
    $error = $_FILES['img']['error'];
    $tmpName = $_FILES['img']['tmp_name'];
    if ($error === 4) {
        echo "
        <script>
        alert('insert image')
        </script>
        ";
        return false;
    }
    $filegambar = ['jpg', 'jpeg', 'png', 'jfif', 'raw', 'webp', 'img'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $filegambar)) {
        echo "
        <script>
        alert('file not supported')
        </script>
        ";
        return false;
    }
    if ($ukuranfile > 11000000) {
        echo "
        <script>
        alert('file size not supported ')
        </script>
        ";
        return false;
    }
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;
    move_uploaded_file($tmpName, '../assets/profile/' . $namafilebaru);
    return $namafilebaru;
}
// function bukti
function bukti()
{
    $namafile = $_FILES['bukti']['name'];
    $ukuranfile = $_FILES['bukti']['size'];
    $error = $_FILES['bukti']['error'];
    $tmpName = $_FILES['bukti']['tmp_name'];
    if ($error === 4) {
        echo "
        <script>
        alert('insert image')
        </script>
        ";
        return false;
    }
    $filegambar = ['jpg', 'jpeg', 'png', 'jfif', 'raw', 'webp', 'img'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $filegambar)) {
        echo "
        <script>
        alert('file not supported')
        </script>
        ";
        return false;
    }
    if ($ukuranfile > 11000000) {
        echo "
        <script>
        alert('file size not supported ')
        </script>
        ";
        return false;
    }
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;
    move_uploaded_file($tmpName, '../bukti/' . $namafilebaru);
    return $namafilebaru;
}
function transaksi()
{
    $namafile = $_FILES['bukti_transaksi']['name'];
    $ukuranfile = $_FILES['bukti_transaksi']['size'];
    $error = $_FILES['bukti_transaksi']['error'];
    $tmpName = $_FILES['bukti_transaksi']['tmp_name'];
    if ($error === 4) {
        echo "
        <script>
        alert('insert image')
        </script>
        ";
        return false;
    }
    $filegambar = ['jpg', 'jpeg', 'png', 'jfif', 'raw', 'webp', 'img'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $filegambar)) {
        echo "
        <script>
        alert('file not supported')
        </script>
        ";
        return false;
    }
    if ($ukuranfile > 11000000) {
        echo "
        <script>
        alert('file size not supported ')
        </script>
        ";
        return false;
    }
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;
    move_uploaded_file($tmpName, '../bukti_transaksi/' . $namafilebaru);
    return $namafilebaru;
}
// function foto
function foto()
{
    $namafile = $_FILES['foto']['name'];
    $ukuranfile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];
    if ($error === 4) {
        echo "
        <script>
        alert('insert image')
        </script>
        ";
        return false;
    }
    $filegambar = ['jpg', 'jpeg', 'png', 'jfif', 'raw', 'webp', 'img'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $filegambar)) {
        echo "
        <script>
        alert('file not supported')
        </script>
        ";
        return false;
    }
    if ($ukuranfile > 11000000) {
        echo "
        <script>
        alert('file size not supported ')
        </script>
        ";
        return false;
    }
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;
    move_uploaded_file($tmpName, '../gallery/' . $namafilebaru);
    return $namafilebaru;
}
// 
//  FUNCTION Register
// 
// function registrasi
function regis($data)
{
    global $konek;
    $nama = $data['nama'];
    $username = mysqli_real_escape_string($konek, $data['username']);
    $email = $data['email'];
    $pw = mysqli_real_escape_string($konek, $data['pw']);
    $pw2 = mysqli_real_escape_string($konek, $data['pw2']);
    $result = mysqli_query($konek, "SELECT Email FROM user WHERE Email = '$email'");
    $result2 = mysqli_query($konek, "SELECT UserName FROM user WHERE UserName = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
        alert('Email sudah di sudah digunakan')
        </script>
        ";
        return false;
    }
    if (mysqli_fetch_assoc($result2)) {
        echo "
        <script>
        alert('username sudah di sudah digunakan')
        </script>
        ";
        return false;
    }
    if ($pw !== $pw2) {
        echo "
        <script>
        alert('password berbeda')
        </script>
        ";
        return false;
    }
    $password = password_hash($pw, PASSWORD_DEFAULT);
    mysqli_query($konek, "INSERT INTO user VALUES('','user','$nama','$username','$email','$password','profile.png')");
    return mysqli_affected_rows($konek);
}
