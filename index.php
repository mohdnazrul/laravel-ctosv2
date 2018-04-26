<?php
require "vendor/autoload.php";

$serviceURL = "http://enq.cmctos.com.my:8080/ctos/Proxy";
$username = "b074000_xml";
$password = "3a3N42kb4T";

try {
    $service = new \MohdNazrul\CTOSV2Laravel\CTOSApi($serviceURL, $username, $password);
    $dataArray = [
        'company_code' => 'B074000',
        'account_no' => 'B074000',
        'user_id' => 'b074000_xml',
        'record_total' => '1',
        'records' => [
            'type' => 'C',
            'ic_lc' => '0939518',
            'nic_br' => '',
            'name' => 'SALTYSKINS SDN BHD',
            'mphone_nos' => '',
            'ref_no' => '',
            'purpose' => 'Credit evaluation/account opening on subject/directors/shareholder with consent /due diligence on AMLA compliance',
            'include_ccris' => '1',
            'include_ctos' => '1',
            'include_ccris' => '1',
            'include_dcheq' => '1',
            'include_ssm' => '1',
            'include_trex' => '1',
            'include_fico' => '1',
            'include_cci' => '1',
            'confirm_entity' => ''
        ]
    ];

    $xml = $service->generateXMLFromArray($dataArray);

//    echo '<code>'.$xml.'</code>';

    $res = $service->getReport($xml);
    $jsonFormat = $service->convertToJSON($res);

    // 1. Test Report Attributes
//    $attr = $service->getResponseReport($jsonFormat);
//    dd($attr);
//
   dd($jsonFormat);
//
////    $res = $service->getReport($xml, true);
//
////   var_dump( $res );
//
////   print_r($res);

} catch (Exception $e) {
    print_r($e->getMessage());
}
?>