<?php
// Set header type konten.
header("Content-Type: application/json; charset=UTF-8");

  include 'configuration/config_connect.php';



// Deklarasi variable keyword buah.
$qry = $_GET["query"];

// Query ke database.
$query  = $conn->query("SELECT * FROM barang WHERE nama LIKE '%$qry%' or barcode LIKE '%$qry%' AND sisa>0 ORDER BY no DESC");

// Fetch hasil query.
$result = $query->fetch_All(MYSQLI_ASSOC);

// Cek apakah ada yang cocok atau tidak.
if (count($result) > 0) {
    foreach($result as $data) {
        $output['suggestions'][] = [
            'value' => $data['nama'],
            'stok' => $data['sisa'],
            'nama'  => $data['nama'],
             'kode'  => $data['kode'],
             'barcode'  => $data['barcode']

        ];
    }

    // Encode ke JSON.
    echo json_encode($output);

// Jika tidak ada yang cocok.
} else {
    $output['suggestions'][] = [
        'value' => "<tr><td>'Pencarian tidak memberikan hasil'</td></tr>",
        'nama'  => 'Tidak ditemukan',
        'stok' => '0',
          'kode' => '',
          'barcode'  => ''
    ];

    // Encode ke JSON.
    echo json_encode($output);
}


