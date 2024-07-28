<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenyediaSumberDana;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\DataPaketController;
use App\Models\PenyediaDetail;
use App\Models\PenyediaPaket;

class PaketPenyediaController extends Controller
{
    public $dataPaketController;
    public $crawler;

    public function __construct(DataPaketController $dataPaketController, Crawler $crawler)
    {
        $this->dataPaketController = $dataPaketController;
        $this->crawler = $crawler;
    }

    public function index()
    {
        return view('paket.index', ['data' => PenyediaPaket::paginate(10)]);
    }

    public function ambilDataPenyedia(Request $request, $kode_kldi = 382, $panjang_data = 5000)
    {
        $panjang_data = (int) ($request->query('length') ?? $panjang_data);
        $kode_kldi = (int) ($request->query('kldi') ?? $kode_kldi);

        $result = $this->dataPaketController->dataPenyedia($request, $kode_kldi, $panjang_data);
        foreach ($result['data'] as $item) {
            [$month, $year] = explode(" ", $item['pemilihan']);
            $countIdsLokasi = count(explode(",", $item['idsLokasi']));

            $results = [
                'kode_rup' => $item['id'],
                'tahun' => $year,
                'id_bulan' => $item['idBulan'],
                'pagu' => $item['pagu'],
                'satuan_kerja' => $item['satuanKerja'],
                'id_lokasi' => $item['idlokasi'],
                'metode' => $item['metode'],
                'sumber_dana' => $item['sumberDana'],
                'id_kldi' => $item['idKldi'],
                'kldi' => $item['kldi'],
                'is_pdn' => $item['isPDN'],
                'is_umk' => $item['isUMK'],
                'ids_lokasi' => $item['idsLokasi'],
                'id_referensi' => $item['id_referensi'],
                'lokasi' => $item['lokasi'],
                'jenis_pengadaan' => $item['jenisPengadaan'],
                'id_satker' => $item['idSatker'],
                'pemilihan' => $month,
                'id_metode' => $item['idMetode'],
                'id_jenis_pengadaan' => $item['idJenisPengadaan'],
                'paket' => $item['paket'],
                'pds' => $item['pds'],
                'paket_terkonsolidasi' => $countIdsLokasi > 1 ? 1 : 0
            ];
            PenyediaPaket::updateOrCreate(['kode_rup' => $results['kode_rup']], $results);
        }
        return view('paket.penyedia', ['data' => $result['recordsTotal']]);
    }

    public function ambilDetailPenyedia(Request $request, $page = 1, $limit = 1000)
    {
        $page = $request->query('page', $page);
        $limit = $request->query('limit', $limit);
        $offset = ($page - 1) * $limit;

        $kode_paket = PenyediaPaket::skip($offset)->take($limit)->get();
        $data_hasil_simpan = [];

        foreach ($kode_paket as $item) {
            $url = 'https://sirup.lkpp.go.id/sirup/rup/detailPaketPenyedia2020?idPaket=' . $item->kode_rup;

            try {
                $response = Http::get($url)->body();
                $data_paket = $this->dataPaketController->detailPenyedia($response, $item->kode_rup, $item->id);

                // PenyediaDetail::updateOrCreate(['kode_rup' => $data_paket['kode_rup']], $data_paket);

                if (count($data_paket)) {
                    foreach ($data_paket as $datapaket) {
                        PenyediaDetail::updateOrCreate(['kode_rup' => $data_paket['kode_rup'], 'paket_terkonsolidasi' => $datapaket['paket_terkonsolidasi']], $datapaket);
                    }
                } else {
                    PenyediaDetail::updateOrCreate(['kode_rup' => $data_paket['kode_rup']], $data_paket);
                }

                // dd($data_paket);
                $data_hasil_simpan[] = $data_paket;
            } catch (\Exception $e) {
                // Tangani error HTTP atau parsing
                return dump($e);
                // return dd($e->getTrace());
                // return dd($e->getTrace()[1]['args']);
                continue;
            }
        }

        return view('detail.penyedia', ['data' => $data_hasil_simpan]);
    }

    public function ambilDetailPenyediaSatuan(Request $request, $kode_rup)
    {

        $kode_rup = (int) $request->route('kode_rup');
        $kode_paket = PenyediaPaket::where('kode_rup', $kode_rup)->first();
        $url = 'https://sirup.lkpp.go.id/sirup/rup/detailPaketPenyedia2020?idPaket=' . $kode_paket->kode_rup;
        try {
            $response = Http::get($url)->body();
            $data_paket = $this->dataPaketController->detailPenyedia($response, $kode_paket->kode_rup, $kode_paket->id);

            // dump(count($data_paket));
            // dump($data_paket);

            if (count($data_paket)) {
                foreach ($data_paket as $datapaket) {
                    PenyediaDetail::updateOrCreate(['paket_terkonsolidasi' => $datapaket['paket_terkonsolidasi']], $datapaket);
                }
            } else {
                PenyediaDetail::updateOrCreate(['kode_rup' => $data_paket['kode_rup']], $data_paket);
            }
        } catch (\Exception $e) {
            // Tangani error HTTP atau parsing
            return dump($e);
            // return dd($e->getTrace());
            // return dd($e->getTrace()[1]['args']);
        }
        return view('detail.penyedia-satuan', ['data' => $data_paket]);
    }

    public function ambilSumberDanaPenyedia(Request $request, $page = 1, $limit = 1000)
    {
        $page = $request->query('page', $page);
        $limit = $request->query('limit', $limit);
        $offset = ($page - 1) * $limit;

        $kode_paket = PenyediaDetail::skip($offset)->take($limit)->get();
        $data_hasil_simpan = [];

        foreach ($kode_paket as $item) {
            $url = 'https://sirup.lkpp.go.id/sirup/rup/detailPaketPenyedia2020?idPaket=' . $item->paket_terkonsolidasi;

            try {
                $response = Http::get($url)->body();
                $data_paket = $this->dataPaketController->sumberDanaPenyedia($response, $item);
                // dd($data_paket);
                foreach ($data_paket as $detail) {
                    PenyediaSumberDana::updateOrCreate(['kode_mak' => $detail['kode_mak'], 'pagu_sumber_dana' => $detail['pagu_sumber_dana']], $detail);
                    $data_hasil_simpan[] = $data_paket;
                }
            } catch (\Exception $e) {
                // Tangani error HTTP atau parsing
                return dump($e);
                // return dd($e->getTrace());
                // return dd($e->getTrace()[1]['args']);
                continue;
            }
        }

        dd($data_hasil_simpan);

        return view('detail.penyedia', ['data' => $data_hasil_simpan]);
    }

    public function ambilSumberDanaPenyediaSatuan(Request $request, $kode_rup)
    {
        $kode_rup = (int) $request->route('kode_rup');
        $kode_paket = PenyediaPaket::where('kode_rup', $kode_rup)->first();
        $url = 'https://sirup.lkpp.go.id/sirup/rup/detailPaketPenyedia2020?idPaket=' . $kode_paket->paket_terkonsolidasi;
        try {
            $response = Http::get($url)->body();
            $data_paket = $this->dataPaketController->sumberDanaPenyedia($response, $kode_paket);

            foreach ($data_paket as $detail) {
                PenyediaSumberDana::updateOrCreate(['kode_mak' => $detail['kode_mak'], 'pagu_sumber_dana' => $detail['pagu_sumber_dana']], $detail);
                // dd($data_paket);
            }
            // dd($data_paket);
        } catch (\Exception $e) {
            // Tangani error HTTP atau parsing
            return dump($e);
            // return dd($e->getTrace());
            // return dd($e->getTrace()[1]['args']);
        }
        return view('sumberdana.sd-penyedia-satuan', ['data' => $data_paket]);
    }
}
