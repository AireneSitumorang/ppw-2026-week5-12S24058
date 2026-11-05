<?php

namespace App\Http\Controllers\Soap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibrarySoapController extends Controller
{
    /**
     * Menangani request SOAP untuk pengecekan status bebas pustaka mahasiswa.
     */
    public function checkBebasPustaka(Request $request)
    {
        // 1. Tangkap payload XML yang dikirim oleh klien SOAP
        $xmlContent = $request->getContent();

        // 2. Parsing sederhana untuk mengambil NIM/NPM mahasiswa dari XML request
        preg_match('/<nim>(.*?)<\/nim>/', $xmlContent, $matches);
        $nim = $matches[1] ?? null;

        if (!$nim) {
            return response($this->soapFaultXml('NIM tidak ditemukan dalam request SOAP.'), 400)
                ->header('Content-Type', 'text/xml; charset=utf-8');
        }

        // 3. Cek ke database apakah mahasiswa masih memiliki peminjaman buku aktif (status 'dipinjam')
        $activeLoans = DB::table('peminjaman')
            ->join('anggota', 'peminjaman.anggota_id', '=', 'anggota.id')
            ->where('anggota.nim', $nim)
            ->where('peminjaman.status', 'dipinjam')
            ->count();

        $isClear = ($activeLoans === 0);
        $message = $isClear 
            ? "Mahasiswa dengan NIM {$nim} DINYATAKAN BEBAS PUSTAKA." 
            : "Mahasiswa dengan NIM {$nim} MASIH MEMILIKI {$activeLoans} TANGGUNGAN BUKU.";

        // 4. Bungkus hasil ke dalam format XML SOAP Response
        $soapResponse = '<?xml version="1.0" encoding="UTF-8"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
                <m:CheckBebasPustakaResponse xmlns:m="http://sipus.del.ac.id/soap">
                    <m:nim>' . htmlspecialchars($nim) . '</m:nim>
                    <m:status>' . ($isClear ? 'BEBAS' : 'BERMASALAH') . '</m:status>
                    <m:keterangan>' . htmlspecialchars($message) . '</m:keterangan>
                </m:CheckBebasPustakaResponse>
            </soap:Body>
        </soap:Envelope>';

        return response($soapResponse, 200)
            ->header('Content-Type', 'text/xml; charset=utf-8');
    }

    private function soapFaultXml($message)
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
                <soap:Fault>
                    <faultcode>soap:Client</faultcode>
                    <faultstring>' . htmlspecialchars($message) . '</faultstring>
                </soap:Fault>
            </soap:Body>
        </soap:Envelope>';
    }
}