<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result)) {

    $rows[] = $row;
    }

    return $rows;
}


function tambah($data) {
    global $conn;
$nrp = htmlspecialchars($data["nrp"]);
$nama = htmlspecialchars($data["nama"]);
$email = htmlspecialchars($data["email"]);
$jurusan = htmlspecialchars($data["jurusan"]);

// query insert data
$query = "INSERT INTO mahasiswa VALUES('', '$nrp', '$nama', '$email', '$jurusan')";
mysqli_query($conn, $query);

return mysqli_affected_rows($conn);

}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa where id = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;

    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    
    // query insert data
    $query = "UPDATE mahasiswa SET
    nrp = '$nrp',
    nama = '$nama',
    email = '$email',
    jurusan = '$jurusan'
    WHERE id = $id
    ";
    mysqli_query($conn, $query);
    
    return mysqli_affected_rows($conn);
}


function cari($keyword) {
    $query = "SELECT * FROM mahasiswa
    WHERE
    nama LIKE '$keyword%' OR
    nrp LIKE '$keyword%' OR
    email LIKE '$keyword%' OR
    jurusan LIKE '$keyword%'
    ";
    return query($query);
}


function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum 
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username  = '$username'");

    if( mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username sudah terdaftar!')
        </script>";
        return false;
    }


    // cek konfirmasi password
    if( $password !== $password2 ) {
        echo "<script>
                alert('konfirmasi password tidak sesuai!');
        </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);




}




?>
