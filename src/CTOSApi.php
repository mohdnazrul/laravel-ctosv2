<?php
/**
 * API Library for CTOS Version 2.
 * User: Mohd Nazrul Bin Mustaffa
 * Date: 26/04/2018
 * Time: 11:16 AM
 */

namespace MohdNazrul\CTOSV2Laravel;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class CTOSApi
{
    private $username;
    private $password;
    private $serviceURL;

    public function __construct($serviceUrl, $username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->serviceURL = $serviceUrl;
    }

    public function generateXMLFromArray($dataArray, $method, $XMLEscape = true)
    {
        if($method == 'request' || $method == 'requestLite' ){
            $namespace = 'request';
        } else {
            $namespace = $method;
        }

        $xmlString = '<batch output="0" no="0009" xmlns="http://ws.cmctos.com.my/ctosnet/'.$namespace.'">';

        foreach ($dataArray as $key => $value) {
            if ($key == 'records') {
                $xmlString .= "<$key>";
                foreach ($value as $key2 => $innerValue) {
                    if (!empty($innerValue)) {

                        if ($key2 == 'type') {
                            if($innerValue == 'C') {
                                $xmlString .= "<$key2 code='24'>$innerValue</$key2>";
                            } elseif($innerValue == 'B') {
                                $xmlString .= "<$key2 code='21'>$innerValue</$key2>";
                            } else {
                                $xmlString .= "<$key2 code='11'>$innerValue</$key2>";
                            }

                        } elseif ($key2 == 'mphone_nos') {
                            if (!empty($innerValue)) {
                                $xmlString .= "<$key2>";
                                foreach ($innerValue as $key3 => $nestedInnerValue) {
                                    $xmlString .= "<$key3>$nestedInnerValue</$key3>";
                                }
                                $xmlString .= "</$key2>";
                            } else {
                                $xmlString .= "<$key2><mphone_no/></$key2>";
                            }
                        } elseif ($key2 == 'purpose') {
                            $xmlString .= "<$key2 code='200'>$innerValue</$key2>";
                        } else {
                            $xmlString .= "<$key2>$innerValue</$key2>";
                        }

                    } else {
                        $xmlString .= "<$key2/>";
                    }
                }
                $xmlString .= "</$key>";
            } elseif($key == 'records2') {
                $key = 'records';
                $xmlString .= "<$key>";
                foreach ($value as $key2 => $innerValue) {
                    if (!empty($innerValue)) {

                        if ($key2 == 'type') {
                            if($innerValue == 'C') {
                                $xmlString .= "<$key2 code='24'>$innerValue</$key2>";
                            } elseif($innerValue == 'B') {
                                $xmlString .= "<$key2 code='21'>$innerValue</$key2>";
                            } else {
                                $xmlString .= "<$key2 code='11'>$innerValue</$key2>";
                            }

                        } elseif ($key2 == 'mphone_nos') {
                            if (!empty($innerValue)) {
                                $xmlString .= "<$key2>";
                                foreach ($innerValue as $key3 => $nestedInnerValue) {
                                    $xmlString .= "<$key3>$nestedInnerValue</$key3>";
                                }
                                $xmlString .= "</$key2>";
                            } else {
                                $xmlString .= "<$key2><mphone_no/></$key2>";
                            }
                        } elseif ($key2 == 'purpose') {
                            $xmlString .= "<$key2 code='200'>$innerValue</$key2>";
                        } else {
                            $xmlString .= "<$key2>$innerValue</$key2>";
                        }

                    } else {
                        $xmlString .= "<$key2/>";
                    }
                }
                $xmlString .= "</$key>";
            }
            else {
                if (!empty($value)) {
                    $xmlString .= "<$key>$value</$key>";
                } else {
                    $xmlString .= "<$key/>";
                }

            }



            if ($key == 'InterestParties') {
                $xmlString .= "<$key>";
                foreach ($value as $key3 => $innerValue2) {
                    if (!empty($innerValue)) {
                        $xmlString .= "<$key3>$innerValue2</$key3>";
                    } else {
                        $xmlString .= "<$key3/>";
                    }
                }
                $xmlString .= "</$key>";
            }

        }
        $xmlString .= '</batch>';
        
        if ($XMLEscape) {
            $escape = htmlspecialchars($xmlString, ENT_QUOTES, 'UTF-8');
        } else {
            $escape = $xmlString;
        }

        $str ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.proxy.xml.ctos.com.my/">'
            . '<soapenv:Header/>'
            . '<soapenv:Body>'
            . '<ws:request>'
            . '<!--Optional:-->'
            . '<input>';
        $str .= $escape;
        $str .= '</input></ws:request></soapenv:Body></soapenv:Envelope>';

        return $str;

    }

    public function getReport($requestXML, $decryptedResponse = true)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->serviceURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360000);
        curl_setopt($ch, CURLOPT_ACCEPTTIMEOUT_MS, 360000);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXML); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->Headers($requestXML));

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return new \Exception(curl_error($ch));
        }

        curl_close($ch);

        if($decryptedResponse){
            return base64_decode($this->getResponseBody($response));
        } else {
            return $this->getResponseBody($response);
        }

    }

    private function Headers($requestXML){

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-length: " . strlen($requestXML),
            "username:" . $this->username,
            "password:" . $this->password
        );

        return $headers;
    }

    private function getResponseBody($response)
    {
        $response1 = str_replace("<?xml version='1.0' encoding='UTF-8'?><S:Envelope xmlns:S=\"http://schemas.xmlsoap.org/soap/envelope/\"><S:Body><ns2:requestResponse xmlns:ns2=\"http://ws.proxy.xml.ctos.com.my/\"><return>", "", $response);
        $response2 = str_replace("</return></ns2:requestResponse></S:Body></S:Envelope>", "", $response1);
        return $response2;
    }

    public function convertToJSON($responseXML){
        $xml = simplexml_load_string($responseXML);
        $json = json_encode($xml);
        $array = json_decode($json, true);
        return $array;
    }

    public function getResponseReport($responseJSON){
        $data = $responseJSON['@attributes'];
        return $data;
    }

    public function getResponseEnqReport($responseJSON){
        $data = $responseJSON['enq_report'];
        return $data;
    }

    public function getResponseTREX($responseJSON){
        $data = empty($responseJSON['trex']) ? 'N/A' : $responseJSON['trex'];
        return $data;
    }

    public function getAttributesEnqReport($responseEnqReport){
        $data = $responseEnqReport['@attributes'];
        return $data;
    }

    public function getHeaderEnqReport($responseEnqReport){
        $data = $responseEnqReport['header'];
        return $data;
    }

    public function getSummaryEnqReport($responseEnqReport){
        $data = empty($responseEnqReport['summary']['enq_sum']) ? 'N/A' : $responseEnqReport['summary']['enq_sum'];
        return $data;
    }

    public function getEnquiryAttributesReport($responseEnqReport){
        $data = empty($responseEnqReport['enquiry']['@attributes']) ? 'N/A' : $responseEnqReport['enquiry']['@attributes'];
        return $data;
    }

    public function getEnquirySectionSummaryReport($responseEnqReport){
        $data = empty($responseEnqReport['enquiry']['section_summary']) ? 'N/A' : $responseEnqReport['enquiry']['section_summary'];
        return $data;
    }

    public function getEnquirySection_A_Report($responseEnqReport){
        $data = empty($responseEnqReport['enquiry']['section_a']) ? 'N/A' : $responseEnqReport['enquiry']['section_a'];
        return $data;
    }

    public function getEnquirySection_B_Report($responseEnqReport){
        $data = empty($responseEnqReport['enquiry']['section_b']) ? 'N/A' : $responseEnqReport['enquiry']['section_b'];
        return $data;
    }

    public function getEnquirySection_C_Report($responseEnqReport){
        $data = empty($responseEnqReport['enquiry']['section_c']) ? 'N/A' : $responseEnqReport['enquiry']['section_c'];
        return $data;
    }

    public function getEnquirySection_D_Report($responseEnqReport){
        $data = empty($responseEnqReport['enquiry']['section_d']) ? 'N/A' : $responseEnqReport['enquiry']['section_d'];
        return $data;
    }

    public function getEnquirySection_D2_Report($responseEnqReport){
        $data = empty($responseEnqReport['enquiry']['section_d2']) ? 'N/A' : $responseEnqReport['enquiry']['section_d2'];
        return $data;
    }

    public function getEnquirySection_CCRIS_Report($responseEnqReport){
        $data = empty($responseEnqReport['enquiry']['section_ccris']) ? 'N/A' : $responseEnqReport['enquiry']['section_ccris'];
        return $data;
    }
    public function getEnquirySection_DCHEQS_Report($responseEnqReport){
        $data = empty($responseEnqReport['enquiry']['section_dcheqs']) ? 'N/A' : $responseEnqReport['enquiry']['section_dcheqs'];
        return $data;
    }




}