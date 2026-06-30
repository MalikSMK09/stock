<?php
require_once __DIR__ . '/SecurityBootstrap.php';

/**
 * Shared secure bootstrap for quotation faktur print templates.
 */
function fakturSecureInit()
{
    global $conn, $nota, $tipe, $tabel, $tabeldatabase, $judul;

    if (!isset($conn)) {
        include __DIR__ . '/../configuration/config_connect.php';
    }

    $nota = SecurityBootstrap::secureNota($_GET['nota'] ?? '');
    $tipe = SecurityBootstrap::secureFakturType($_GET['tipe'] ?? 'quotation');

    if ($tipe === 'quotation') {
        $tabel = 'quotation';
        $tabeldatabase = 'quotation_list';
        $judul = 'Penawaran';
    } else {
        $tabel = 'sale';
        $tabeldatabase = 'invoicejual';
        $judul = 'Invoice';
    }
}

function fakturLoadHeader($conn, $tipe, $nota)
{
    if ($tipe === 'quotation') {
        return SecurityBootstrap::queryOne($conn, 'SELECT * FROM quotation WHERE nota = ? LIMIT 1', 's', [$nota]) ?: [];
    }
    return SecurityBootstrap::queryOne($conn, 'SELECT * FROM sale WHERE nota = ? LIMIT 1', 's', [$nota]) ?: [];
}

function fakturCountItems($conn, $table, $nota)
{
    $table = SecurityBootstrap::whitelistTable($table);
    $row = SecurityBootstrap::queryOne($conn, "SELECT COUNT(kode) AS countitem FROM `{$table}` WHERE nota = ?", 's', [$nota]);
    return (int) ($row['countitem'] ?? 0);
}

function fakturLoadItems($conn, $table, $nota, $offset, $limit)
{
    $table = SecurityBootstrap::whitelistTable($table);
    $offset = SecurityBootstrap::paramInt($offset);
    $limit = SecurityBootstrap::paramInt($limit);
    if ($limit <= 0) {
        $limit = 20;
    }
    return SecurityBootstrap::queryAll(
        $conn,
        "SELECT * FROM `{$table}` WHERE nota = ? ORDER BY no LIMIT ?, ?",
        'sii',
        [$nota, $offset, $limit]
    );
}

function fakturLoadCompany($conn)
{
    return SecurityBootstrap::queryOne($conn, 'SELECT * FROM data LIMIT 1') ?: [];
}

function fakturLoadPelanggan($conn, $kode)
{
    return SecurityBootstrap::queryOne(
        $conn,
        'SELECT nama, nohp, alamat FROM pelanggan WHERE kode = ? LIMIT 1',
        's',
        [$kode]
    ) ?: [];
}

function fakturApplyHeader($tipe, array $row)
{
    if ($tipe === 'quotation') {
        return [
            'nomor' => $row['nomor'] ?? '',
            'due' => $row['due'] ?? '',
            'bayar' => $row['oleh'] ?? '',
            'kasir' => $row['oleh'] ?? '',
            'biaya' => $row['biayatambahan'] ?? 0,
            'total' => $row['total'] ?? 0,
            'status' => $row['status'] ?? '',
            'tgl' => $row['tgl'] ?? '',
            'pelanggan' => $row['pelanggan'] ?? '',
            'diskon' => $row['diskon'] ?? 0,
            'pot' => $row['potongan'] ?? 0,
            'keterangan' => $row['keterangan'] ?? '',
            'batas' => 'Berlaku Sampai*',
        ];
    }

    return [
        'nomor' => $row['nomor'] ?? '',
        'due' => $row['duedate'] ?? '',
        'bayar' => $row['kasir'] ?? '',
        'kasir' => $row['kasir'] ?? '',
        'biaya' => $row['biaya'] ?? 0,
        'total' => $row['total'] ?? 0,
        'status' => $row['status'] ?? '',
        'tgl' => $row['tglsale'] ?? '',
        'pelanggan' => $row['pelanggan'] ?? '',
        'diskon' => $row['diskon'] ?? 0,
        'pot' => $row['potongan'] ?? 0,
        'keterangan' => $row['keterangan'] ?? '',
        'batas' => 'Jatuh Tempo',
    ];
}

function fakturLoadRekeningAll($conn)
{
    return SecurityBootstrap::queryAll($conn, 'SELECT * FROM rekening ORDER BY no');
}

function fakturLoadRekeningAt($conn, $offset)
{
    return SecurityBootstrap::queryOne(
        $conn,
        'SELECT * FROM rekening ORDER BY no LIMIT ?, 1',
        'i',
        [SecurityBootstrap::paramInt($offset)]
    ) ?: [];
}
