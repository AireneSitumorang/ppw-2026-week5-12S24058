<?php

namespace App\Http\Controllers\Soap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DOMDocument;
use DOMXPath;

class LibrarySoapController extends Controller
{
    /**
     * Menampilkan WSDL layanan SOAP SIPUS-Del.
     */
    public function wsdl()
    {
        $wsdl = '<?xml version="1.0" encoding="UTF-8"?>
        <definitions
            name="SIPUSService"
            targetNamespace="http://sipus.del.ac.id/soap"
            xmlns="http://schemas.xmlsoap.org/wsdl/"
            xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
            xmlns:tns="http://sipus.del.ac.id/soap"
            xmlns:xsd="http://www.w3.org/2001/XMLSchema">

            <types>
                <xsd:schema
                    targetNamespace="http://sipus.del.ac.id/soap"
                    elementFormDefault="qualified">

                    <xsd:element name="CheckClearanceStatus">
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="nim_peminjam" type="xsd:string"/>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                    <xsd:element name="CheckClearanceStatusResponse">
                        <xsd:complexType>
                            <xsd:sequence>
                                <xsd:element name="nim_peminjam" type="xsd:string"/>
                                <xsd:element name="active_loans" type="xsd:int"/>
                                <xsd:element name="is_cleared" type="xsd:boolean"/>
                            </xsd:sequence>
                        </xsd:complexType>
                    </xsd:element>

                </xsd:schema>
            </types>

            <message name="CheckClearanceStatusInput">
                <part name="parameters" element="tns:CheckClearanceStatus"/>
            </message>

            <message name="CheckClearanceStatusOutput">
                <part name="parameters" element="tns:CheckClearanceStatusResponse"/>
            </message>

            <portType name="SIPUSPortType">
                <operation name="CheckClearanceStatus">
                    <input message="tns:CheckClearanceStatusInput"/>
                    <output message="tns:CheckClearanceStatusOutput"/>
                </operation>
            </portType>

            <binding name="SIPUSBinding" type="tns:SIPUSPortType">
                <soap:binding
                    style="document"
                    transport="http://schemas.xmlsoap.org/soap/http"/>

                <operation name="CheckClearanceStatus">
                    <soap:operation soapAction="CheckClearanceStatus"/>
                    <input>
                        <soap:body use="literal"/>
                    </input>
                    <output>
                        <soap:body use="literal"/>
                    </output>
                </operation>
            </binding>

            <service name="SIPUSService">
                <port name="SIPUSPort" binding="tns:SIPUSBinding">
                    <soap:address location="http://127.0.0.1:8000/soap/sipus"/>
                </port>
            </service>
        </definitions>';

        return response($wsdl, 200)
            ->header('Content-Type', 'text/xml; charset=utf-8');
    }

    /**
     * Memeriksa status bebas pustaka mahasiswa melalui SOAP.
     */
    public function checkBebasPustaka(Request $request)
    {
        $xmlContent = $request->getContent();

        // Hapus BOM jika ada di awal XML.
        $xmlContent = preg_replace('/^\xEF\xBB\xBF/', '', $xmlContent);

        // Hapus spasi dan baris kosong sebelum deklarasi XML.
        $xmlContent = ltrim($xmlContent);

        // Periksa apakah XML valid.
        $previousErrorSetting = libxml_use_internal_errors(true);

        $document = new DOMDocument();

        $xmlLoaded = $document->loadXML(
            $xmlContent,
            LIBXML_NONET | LIBXML_NOBLANKS
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousErrorSetting);

        if (!$xmlLoaded) {
            return $this->soapFaultXml(
                'Format XML tidak valid.'
            );
        }

        // Ambil SOAP Body.
        $xpath = new DOMXPath($document);

        $xpath->registerNamespace(
            'soap',
            'http://schemas.xmlsoap.org/soap/envelope/'
        );

        $body = $xpath->query('/soap:Envelope/soap:Body')->item(0);

        if (!$body) {
            return $this->soapFaultXml(
                'SOAP Envelope atau Body tidak valid.'
            );
        }

        // Periksa operasi CheckClearanceStatus.
        $operation = $xpath->query(
            './*[local-name()="CheckClearanceStatus"]',
            $body
        )->item(0);

        if (!$operation) {
            return $this->soapFaultXml(
                'Operasi CheckClearanceStatus tidak ditemukan.'
            );
        }

        // Ambil NIM dari nim_peminjam.
        $nimNode = $xpath->query(
            './*[local-name()="nim_peminjam"]',
            $operation
        )->item(0);

        $nim = $nimNode ? trim($nimNode->textContent) : '';

        if ($nim === '') {
            return $this->soapFaultXml(
                'NIM peminjam wajib diisi.'
            );
        }

        // Hitung peminjaman yang masih aktif.
        $activeLoans = DB::table('peminjamans')
            ->where('nim_peminjam', $nim)
            ->where('status', 'dipinjam')
            ->count();

        $isCleared = ($activeLoans === 0);

        // Amankan NIM untuk XML response.
        $escapedNim = htmlspecialchars(
            $nim,
            ENT_XML1 | ENT_QUOTES,
            'UTF-8'
        );

        // Bentuk SOAP Response.
        $soapResponse = '<?xml version="1.0" encoding="UTF-8"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
                       xmlns:m="http://sipus.del.ac.id/soap">
            <soap:Body>
                <m:CheckClearanceStatusResponse>
                    <m:nim_peminjam>' . $escapedNim . '</m:nim_peminjam>
                    <m:active_loans>' . $activeLoans . '</m:active_loans>
                    <m:is_cleared>' . ($isCleared ? 'true' : 'false') . '</m:is_cleared>
                </m:CheckClearanceStatusResponse>
            </soap:Body>
        </soap:Envelope>';

        return response($soapResponse, 200)
            ->header('Content-Type', 'text/xml; charset=utf-8');
    }

    /**
     * Menghasilkan SOAP Fault ketika request tidak valid.
     */
    private function soapFaultXml($message)
    {
        $escapedMessage = htmlspecialchars(
            $message,
            ENT_XML1 | ENT_QUOTES,
            'UTF-8'
        );

        $fault = '<?xml version="1.0" encoding="UTF-8"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
                <soap:Fault>
                    <faultcode>soap:Client</faultcode>
                    <faultstring>' . $escapedMessage . '</faultstring>
                </soap:Fault>
            </soap:Body>
        </soap:Envelope>';

        return response($fault, 400)
            ->header('Content-Type', 'text/xml; charset=utf-8');
    }
}
