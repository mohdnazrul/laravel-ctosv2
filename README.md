#CTOS API Package (Version 2)

This Library allows to query the CTOS  - B2B API for registered users. 

You need the access details that were provided to you to make any calls to the API.
For exact parameters in the data array/XML, refer to your offline documentation.

If you do not know what all this is about, then you probably do not need or want this library.

# Configuration

## .env file

Configuration via the .env file currently allows the following variables to be set:

- CTOS\_URL='http://api.endpoint/url/'
- CTOS_USERNAME=demouser 
- CTOS\_PASSWORD=demoPassword

## Available functions

```php
CTOSV2::generateXMLFromArray($data, $XMLEscape = true);
```
This function takes an array of options for the CTOS API and generates the XML code
that can be submitted via the API Call. XMLEscape auto set true because data return generete XML 
must be in html special chars in 'UTF-8'. 
Example:
```php
// This is for Company Format
[
        'company_code' => 'XXXXXX',
        'account_no' => 'AAAAAA',
        'user_id' => 'AAAAAA',
        'record_total' => '1',
        'records' => [
            'type' => 'C', // type is C for Company
            'ic_lc' => 'COMPANY_REGISTRATION_NO',
            'nic_br' => '',
            'name' => 'COMPANY_NAME',
            'mphone_nos' => '',
            'ref_no' => '',
            'purpose' => 'PURPOSE_ENQUIRY',
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

// This is for Individual Format
[
        'company_code' => 'XXXXXX',
        'account_no' => 'AAAAAA',
        'user_id' => 'AAAAAA',
        'record_total' => '1',
        'records' => [
            'type' => 'I', // Type is I for Individual
            'ic_lc' => '',
            'nic_br' => 'IDENTIFICATION_NO',
            'name' => 'INDIVIDU_NAME',
            'mphone_nos' => '',
            'ref_no' => '',
            'purpose' => 'PURPOSE_ENQUIRY',
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

``` 

will generate
**// This is for Company Format**
```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.proxy.xml.ctos.com.my/">
   <soapenv:Header/>
   <soapenv:Body>
      <ws:request>
         <!--Optional:-->
         <input>
		&lt;batch output=&quot;0&quot; no=&quot;0009&quot; xmlns=&quot;http://ws.cmctos.com.my/ctosnet/request&quot;&gt;
			&lt;company_code&gt;XXXXXX&lt;/company_code&gt;
			&lt;account_no&gt;AAAAAA&lt;/account_no&gt;
			&lt;user_id&gt;AAAAAA&lt;/user_id&gt;
			&lt;record_total&gt;1&lt;/record_total&gt;
			&lt;records&gt;
				&lt;type code=&apos;11&apos;&gt;C&lt;/type&gt;
				&lt;ic_lc&gt;COMPANY_REGISTRATION_NO&lt;/ic_lc&gt;
				&lt;nic_br/&gt;
				&lt;name&gt;COMPANY_NAME&lt;/name&gt;
				&lt;mphone_nos/&gt;
				&lt;ref_no/&gt;
				&lt;purpose code=&apos;200&apos;&gt;PURPOSE_ENQUIRY&lt;/purpose&gt;
				&lt;include_ccris&gt;1&lt;/include_ccris&gt;
				&lt;include_ctos&gt;1&lt;/include_ctos&gt;
				&lt;include_dcheq&gt;1&lt;/include_dcheq&gt;
				&lt;include_ssm&gt;1&lt;/include_ssm&gt;
				&lt;include_trex&gt;1&lt;/include_trex&gt;
				&lt;include_fico&gt;1&lt;/include_fico&gt;
				&lt;include_cci&gt;1&lt;/include_cci&gt;
				&lt;confirm_entity/&gt;
			&lt;/records&gt;
			&lt;/batch&gt;
		</input>
      </ws:request>
   </soapenv:Body>
</soapenv:Envelope>

```
**// This is for Individual Format**
```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="http://ws.proxy.xml.ctos.com.my/">
   <soapenv:Header/>
   <soapenv:Body>
      <ws:request>
         <!--Optional:-->
         <input>
		&lt;batch output=&quot;0&quot; no=&quot;0009&quot; xmlns=&quot;http://ws.cmctos.com.my/ctosnet/request&quot;&gt;
			&lt;company_code&gt;XXXXXX&lt;/company_code&gt;
			&lt;account_no&gt;AAAAAA&lt;/account_no&gt;
			&lt;user_id&gt;AAAAAA&lt;/user_id&gt;
			&lt;record_total&gt;1&lt;/record_total&gt;
			&lt;records&gt;
				&lt;type code=&apos;11&apos;&gt;C&lt;/type&gt;
				&lt;ic_lc/&gt;
				&lt;nic_br&gt;IDENTIFICATION_NO&lt;/nic_br&gt;
				&lt;name&gt;INDIVIDUAL_NAME&lt;/name&gt;
				&lt;mphone_nos/&gt;
				&lt;ref_no/&gt;
				&lt;purpose code=&apos;200&apos;&gt;PURPOSE_ENQUIRY&lt;/purpose&gt;
				&lt;include_ccris&gt;1&lt;/include_ccris&gt;
				&lt;include_ctos&gt;1&lt;/include_ctos&gt;
				&lt;include_dcheq&gt;1&lt;/include_dcheq&gt;
				&lt;include_ssm&gt;1&lt;/include_ssm&gt;
				&lt;include_trex&gt;1&lt;/include_trex&gt;
				&lt;include_fico&gt;1&lt;/include_fico&gt;
				&lt;include_cci&gt;1&lt;/include_cci&gt;
				&lt;confirm_entity/&gt;
			&lt;/records&gt;
			&lt;/batch&gt;
		</input>
      </ws:request>
   </soapenv:Body>
</soapenv:Envelope>
```

```php
CTOSV2::getReport($requestXML,  $decryptedResponse=true)
```
This function tries to retrieve the report data from CTOS and returns the XML response;
In case of a connection error, it return,

If the request was successful but the query resulted in data related errors, the returned array will have the fields:

code  : contains the error code received from CTOS
error : contains the error message received from CTOS

A successful request returns the XML of the requested report


**OPTIONAL PARAMETER $decryptedResponse:**
 
 If this parameter is set to false, the function will return the data as an 64 ecryption format. 
 
 ```php
CTOSV2::convertToJSON($responseXML)
```
This function tries to retrieve the report data from CTOS and returns the JSON format.

 ```php
CTOSV2::getResponseReport($responseJSON)
```
This function tries to retrieve attributes report in array. 
$responseJSON = The parameter must come from CTOSV2::getReport($requestXML,  $decryptedResponse=true).

 ```php
CTOSV2::getResponseEnqReport($responseJSON)
```
This function tries to retrieve enquiry report in array. 
$responseJSON = The parameter must come from CTOSV2::getReport($requestXML,  $decryptedResponse=true).

 ```php
CTOSV2::getResponseTREX($responseJSON)
```
This function tries to retrieve TREX report in array. 
$responseJSON = The parameter must come from CTOSV2::getReport($requestXML,  $decryptedResponse=true).
In case of a data is null, it return 'N/A'.

 ```php
CTOSV2::getAttributesEnqReport($responseEnqReport)
```
This function tries to attributes Enquiry report in array. 
$responseEnqReport = The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getHeaderEnqReport($responseEnqReport)
```
This function tries to header Enquiry report in array. 
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getSummaryEnqReport($responseEnqReport)
```
This function tries to Summary Enquiry report in array. 
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getEnquiryAttributesReport($responseEnqReport)
```
This function tries to Enquiry Attributes report in array. 
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getEnquirySectionSummaryReport($responseEnqReport)
```
This function tries to Enquiry Section Summary Report report in array. 
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getEnquirySection_A_Report($responseEnqReport)
```
This function tries to Enquiry Section A Report report in array. 
[Section A contains data for identity verification against various sources from the CTOS Database]
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getEnquirySection_B_Report($responseEnqReport)
```
This function tries to Enquiry Section B Report report in array. 
[Section B contains inforamtion from subcriber's monitoring and internal list.]
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getEnquirySection_C_Report($responseEnqReport)
```
This function tries to Enquiry Section B Report report in array. 
[Section C provides information on the subjetc's directorship and other business interest.]
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getEnquirySection_D_Report($responseEnqReport)
```
This function tries to Enquiry Section B Report report in array. 
[Section D provides information on legal cases such as as summons, writs, bankruptcy proceedings,
foreclosure and others where the subject is the defendant]
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getEnquirySection_D2_Report($responseEnqReport)
```
This function tries to Enquiry Section B Report report in array. 
[Section D2 is a subsection to Section D which provides infromation on legal cases such as as summons, 
writs, bankruptcy proceedings, foreclosure and others where the subject is plaintif of the action]
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).

 ```php
CTOSV2::getEnquirySection_CCRIS_Report($responseEnqReport)
```
This function tries to Enquiry Section B Report report in array. 
[Section CCRIS provides the CCRIS Information]
$responseEnqReport =  The parameter must come from CTOSV2::getResponseEnqReport($responseJSON).


**FOR LARAVEL SETUP CONFIGURATION:-**

- Do composer require mohdnazrul/laravel-ctosv2
```php
   composer require mohdnazrul/laravel-ctosv2
```
- Add this syntax inside config/app.php
```php
   ....
   'providers'=> [
     .
     MohdNazrul\CTOSV2Laravel\CTOSServiceProvider::class,
     .
   ],
   'aliases' => [
      .
      'CBMApi' => MohdNazrul\CTOSV2Laravel\CTOSApiFacade::class,
      '
    ],
``` 
- Do publish as below
```php
php artisan vendor:publish --tag=ctosv2 
```
- You can edit the default configuration CBM inside config/ctosv2.php based your account as below
```php
return [
    'serviceUrl'    =>  env('CTOS_URL','http://localhost'),
    'username'      =>  env('CTOS_USERNAME','username'),
    'password'      =>  env('CTOS_PASSWORD','password')
];
``` 







     
