<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;

class DataPaketController extends Controller
{
    private $client;
    public function __construct()
    {
        $this->client = new Client();
    }

    public function dataPenyedia(Request $request, $kode_kldi = 382, $panjang_data = 5000)
    {
        $panjang_data = (int) ($request->query('length') ?? $panjang_data);
        $kode_kldi = (int) ($request->query('kldi') ?? $kode_kldi);

        $url_utama = 'https://sirup.lkpp.go.id/sirup/caripaketctr/search?tahunAnggaran=2024&jenisPengadaan=&metodePengadaan=&minPagu=&maxPagu=&bulan=&lokasi=&kldi=' . $kode_kldi . '&pdn=&ukm=&draw=0&columns%5B0%5D%5Bdata%5D=&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=false&columns%5B0%5D%5Borderable%5D=false&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=paket&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=pagu&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=jenisPengadaan&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=isPDN&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B5%5D%5Bdata%5D=isUMK&columns%5B5%5D%5Bname%5D=&columns%5B5%5D%5Bsearchable%5D=true&columns%5B5%5D%5Borderable%5D=true&columns%5B5%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B5%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B6%5D%5Bdata%5D=metode&columns%5B6%5D%5Bname%5D=&columns%5B6%5D%5Bsearchable%5D=true&columns%5B6%5D%5Borderable%5D=true&columns%5B6%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B6%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B7%5D%5Bdata%5D=pemilihan&columns%5B7%5D%5Bname%5D=&columns%5B7%5D%5Bsearchable%5D=true&columns%5B7%5D%5Borderable%5D=true&columns%5B7%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B7%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B8%5D%5Bdata%5D=kldi&columns%5B8%5D%5Bname%5D=&columns%5B8%5D%5Bsearchable%5D=true&columns%5B8%5D%5Borderable%5D=true&columns%5B8%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B8%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B9%5D%5Bdata%5D=satuanKerja&columns%5B9%5D%5Bname%5D=&columns%5B9%5D%5Bsearchable%5D=true&columns%5B9%5D%5Borderable%5D=true&columns%5B9%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B9%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B10%5D%5Bdata%5D=lokasi&columns%5B10%5D%5Bname%5D=&columns%5B10%5D%5Bsearchable%5D=true&columns%5B10%5D%5Borderable%5D=true&columns%5B10%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B10%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B11%5D%5Bdata%5D=id&columns%5B11%5D%5Bname%5D=&columns%5B11%5D%5Bsearchable%5D=true&columns%5B11%5D%5Borderable%5D=true&columns%5B11%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B11%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=5&order%5B0%5D%5Bdir%5D=DESC&start=0&length=' . $panjang_data . '&search%5Bvalue%5D=&search%5Bregex%5D=false&_=1720942716429';

        try {
            // Melakukan GET request ke URL
            $response = $this->client
                ->request('GET', $url_utama)
                ->getBody()
                ->getContents();

            // Mengubah JSON menjadi array
            $result = json_decode($response, true);
        } catch (\Exception $e) {
            // Mengembalikan pesan error jika terjadi kesalahan
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }

        return $result;
    }

    public function dataSwakelola(Request $request, $kode_kldi = 382, $panjang_data = 5000)
    {
        $panjang_data = (int) ($request->query('length') ?? $panjang_data);
        $kode_kldi = (int) ($request->query('kldi') ?? $kode_kldi);
        $url_utama = 'https://sirup.lkpp.go.id/sirup/caripaketctr/search_s?tahunAnggaran=2024&jenisPengadaan=&metodePengadaan=&minPagu=&maxPagu=&bulan=&lokasi=&kldi=' . $kode_kldi . '&pdn=&ukm=&draw=0&columns%5B0%5D%5Bdata%5D=&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=false&columns%5B0%5D%5Borderable%5D=false&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=paket&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=pagu&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=jenisPengadaan&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=isPDN&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B5%5D%5Bdata%5D=isUMK&columns%5B5%5D%5Bname%5D=&columns%5B5%5D%5Bsearchable%5D=true&columns%5B5%5D%5Borderable%5D=true&columns%5B5%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B5%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B6%5D%5Bdata%5D=metode&columns%5B6%5D%5Bname%5D=&columns%5B6%5D%5Bsearchable%5D=true&columns%5B6%5D%5Borderable%5D=true&columns%5B6%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B6%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B7%5D%5Bdata%5D=pemilihan&columns%5B7%5D%5Bname%5D=&columns%5B7%5D%5Bsearchable%5D=true&columns%5B7%5D%5Borderable%5D=true&columns%5B7%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B7%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B8%5D%5Bdata%5D=kldi&columns%5B8%5D%5Bname%5D=&columns%5B8%5D%5Bsearchable%5D=true&columns%5B8%5D%5Borderable%5D=true&columns%5B8%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B8%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B9%5D%5Bdata%5D=satuanKerja&columns%5B9%5D%5Bname%5D=&columns%5B9%5D%5Bsearchable%5D=true&columns%5B9%5D%5Borderable%5D=true&columns%5B9%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B9%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B10%5D%5Bdata%5D=lokasi&columns%5B10%5D%5Bname%5D=&columns%5B10%5D%5Bsearchable%5D=true&columns%5B10%5D%5Borderable%5D=true&columns%5B10%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B10%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B11%5D%5Bdata%5D=id&columns%5B11%5D%5Bname%5D=&columns%5B11%5D%5Bsearchable%5D=true&columns%5B11%5D%5Borderable%5D=true&columns%5B11%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B11%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=5&order%5B0%5D%5Bdir%5D=DESC&start=0&length=' . $panjang_data . '&search%5Bvalue%5D=&search%5Bregex%5D=false&_=1720942716429';

        try {
            // Melakukan GET request ke URL
            $response = $this->client
                ->request('GET', $url_utama)
                ->getBody()
                ->getContents();

            // Mengubah JSON menjadi array
            $result = json_decode($response, true);
        } catch (\Exception $e) {
            // Mengembalikan pesan error jika terjadi kesalahan
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }

        return $result;
    }

    public function detailPenyedia($crawler, $kode_rup, $id)
    {
        $crawler = new Crawler($crawler);
        $nama_paket = $crawler->filter('td.label-left:contains("Nama Paket")')->siblings()->text();
        $nama_klpd = $crawler->filter('td.label-left:contains("Nama KLPD")')->siblings()->text();
        $satuan_kerja = $crawler->filter('td.label-left:contains("Satuan Kerja")')->siblings()->text();
        $tahun_anggaran = $crawler->filter('td.label-left:contains("Tahun Anggaran")')->siblings()->text();
        $volume_pekerjaan = $crawler->filter('td.label-left:contains("Volume Pekerjaan")')->siblings()->text();
        $tanggalUmumkanPaket = $crawler->filter('td.label-left:contains("Tanggal Umumkan Paket")')->siblings()->text();
        $timestamp = strtotime(str_replace(
            ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            $tanggalUmumkanPaket
        ));
        $formattedDate = date('Y-m-d H:i:s', $timestamp);
        $totalPagu = $crawler->filter('td.label-left:contains("Total Pagu")')->siblings()->text();
        $metodePemilihan = $crawler->filter('td.label-left:contains("Metode Pemilihan")')->siblings()->text();
        $produkDalamNegeri = trim($crawler->filter('td.label-left:contains("Produk Dalam Negeri")')->siblings()->text()) === 'Ya' ? 1 : 0;
        $usahaKecilKoperasi = trim($crawler->filter('td.label-left:contains("Usaha Kecil/Koperasi")')->siblings()->text()) === 'Ya' ? 1 : 0;

        $detailPenyedia = [];

        $countPaketTerkonsolidasi = $crawler->filter('td.label-left:contains("Paket Terkonsolidasi")')->count() > 0 ? 1 : 0;

        if ($countPaketTerkonsolidasi) {
            $paketTerkonsolidasi = $crawler->filter('table.table-striped.table-hover')->eq(0)->filter('tr');

            $paketTerkonsolidasi->each(function (Crawler $row, $index) use (&$detailPenyedia, $id, $kode_rup, $tahun_anggaran, $nama_klpd, $satuan_kerja, $nama_paket, $volume_pekerjaan, $totalPagu, $metodePemilihan, $produkDalamNegeri, $usahaKecilKoperasi, $formattedDate) {
                $columns = $row->filter('td');

                if ($columns->count() >= 2) {
                    $kodeRupKonsolidasi = trim($columns->eq(1)->text(), ': []');
                    // $namaPaket = trim($columns->eq(2)->text(), ': []');

                    $detailPenyedia[] = [
                        'paket_id' => $id,
                        'kode_rup' => $kode_rup,
                        'paket_terkonsolidasi' => $kodeRupKonsolidasi,
                        'tahun_anggaran' => $tahun_anggaran,
                        'nama_klpd' => $nama_klpd,
                        'satuan_kerja' => $satuan_kerja,
                        'paket' => $nama_paket,
                        'volume_pekerjaan' => $volume_pekerjaan,
                        'total_pagu' => $totalPagu,
                        'metode_pemilihan' => $metodePemilihan,
                        'produk_dalam_negeri' => $produkDalamNegeri,
                        'usaha_kecil_koperasi' => $usahaKecilKoperasi,
                        'tanggal_umumkan_paket' => $formattedDate,
                    ];
                }
            });
        } else {

            $detailPenyedia[] = [
                'paket_id' => $id,
                'kode_rup' => $kode_rup,
                'paket_terkonsolidasi' => $kode_rup,
                'tahun_anggaran' => $tahun_anggaran,
                'nama_klpd' => $nama_klpd,
                'satuan_kerja' => $satuan_kerja,
                'paket' => $nama_paket,
                'volume_pekerjaan' => $volume_pekerjaan,
                'total_pagu' => $totalPagu,
                'metode_pemilihan' => $metodePemilihan,
                'produk_dalam_negeri' => $produkDalamNegeri,
                'usaha_kecil_koperasi' => $usahaKecilKoperasi,
                'tanggal_umumkan_paket' => $formattedDate,
            ];
        }

        // dd($detailPenyedia);
        return $detailPenyedia;
    }

    public function sumberDanaPenyedia($crawler, $item)
    {
        $crawler = new Crawler($crawler);
        $uraianPekerjaan = $crawler->filter('td.label-left:contains("Uraian Pekerjaan")')->siblings()->text();
        $uraianPekerjaan =  str_contains($uraianPekerjaan, ';') ? explode("; ", $uraianPekerjaan) : [$uraianPekerjaan];
        $uraianPekerjaan[count($uraianPekerjaan) - 1] = rtrim($uraianPekerjaan[count($uraianPekerjaan) - 1], ';');

        $spesifikasiPekerjaan = $crawler->filter('td.label-left:contains("Spesifikasi Pekerjaan")')->siblings()->text();
        $spesifikasiPekerjaan =  array_map(function ($element) {
            return trim($element, ';');
        }, explode("; ", $spesifikasiPekerjaan));

        $sumberDana = [];
        $tableRowsSumberDana = $crawler->filter('table.table-striped')->eq(2)->filter('tr');

        $tableRowsSumberDana->each(function (Crawler $row, $index) use (&$sumberDana, $uraianPekerjaan, $spesifikasiPekerjaan, $item) {
            if ($index > 0) {
                $columns = $row->filter('td');
                if ($columns->count() >= 5) {
                    $kode_subkegiatan = substr($columns->eq(4)->text(), 0, 17);
                    $kode_akun = substr($columns->eq(4)->text(), 18, 17);
                    $kode_klasifikasi_sh = substr($columns->eq(4)->text(), 36, 18);
                    $kode_standar_harga = substr($columns->eq(4)->text(), 55);

                    $sumberDana[] = [
                        'paket_id' => $item->paket_id,
                        'kode_rup' => $item->kode_rup,
                        'paket_terkonsolidasi' => $item->paket_terkonsolidasi,
                        'sumber_dana' => trim($columns->eq(1)->text()),
                        'tahun_anggaran' => trim($columns->eq(2)->text()),
                        'kl_pd' => trim($columns->eq(3)->text()),
                        'kode_mak' => $columns->eq(4)->text(),
                        'kode_subkegiatan' => $kode_subkegiatan,
                        'kode_akun' => $kode_akun,
                        'kode_klasifikasi_sh' => $kode_klasifikasi_sh,
                        'kode_standar_harga' => $kode_standar_harga,
                        'pagu_sumber_dana' => trim($columns->eq(5)->text()),
                        'uraian_pekerjaan' => $uraianPekerjaan[$index - 1] ?? $uraianPekerjaan[0],
                        'spesifikasi_pekerjaan' => $spesifikasiPekerjaan[$index - 1] ?? $spesifikasiPekerjaan[0],
                    ];
                }
            }
        });

        return $sumberDana;
    }

    public function detailSwakelola($crawler, $kode_rup)
    {
        $crawler = new Crawler($crawler);
        $nama_paket = $crawler->filter('td.label-left:contains("Nama Paket")')->siblings()->text();
        $nama_klpd = $crawler->filter('td.label-left:contains("Nama KLPD")')->siblings()->text();
        $satuan_kerja = $crawler->filter('td.label-left:contains("Satuan Kerja")')->siblings()->text();
        $tipeSwakelola = $crawler->filter('td.label-left:contains("Tipe Swakelola")')->siblings()->text();
        $penyelenggaraSwakelola = $crawler->filter('td.label-left:contains("Penyelenggara Swakelola")')->siblings()->text();
        $tahun_anggaran = $crawler->filter('td.label-left:contains("Tahun Anggaran")')->siblings()->text();
        $volume_pekerjaan = $crawler->filter('td.label-left:contains("Volume Pekerjaan")')->siblings()->text();
        $tanggalUmumkanPaket = $crawler->filter('td.label-left:contains("Tanggal Umumkan Paket")')->siblings()->text();
        $totalPagu = $crawler->filter('td.label-left:contains("Total Pagu")')->siblings()->text();

        return [
            'kode_rup' => $kode_rup,
            'tahun_anggaran' => $tahun_anggaran,
            'nama_klpd' => $nama_klpd,
            'satuan_kerja' => $satuan_kerja,
            'paket' => $nama_paket,
            'volume_pekerjaan' => $volume_pekerjaan,
            'total_pagu' => $totalPagu,
            'tipe_swakelola' => $tipeSwakelola,
            'penyelenggara_swakelola' => $penyelenggaraSwakelola,
            'tanggal_umumkan_paket' => $tanggalUmumkanPaket,
        ];
    }
}
