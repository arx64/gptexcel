<?php
$tools =  $_REQUEST['tools']; // Tools: formula, script, sql, regex, and template.
$prompt = $_REQUEST['prompt']; // Prompt Ex: "Averange of B1:B10"
$act = $_REQUEST['act']; // Act: explainer / generator
function REQUESTAPI($tools, $prompt, $act)
{
    /* Example URL: https://gptexcel.uk/api/tools/formula
    / Act: explainer / generator
    / Tools: formula, script, sql, regex, and template.
    / Example Prompt for formula:
    / $data = '{"prompt":"Averange of B1:B10","tool":"Microsoft Excel","action":"generator","uid":"xRIiZzZInEZwqSECYQH4JeIP2G02","isPro":true,"version":"Excel 2010","separator":"comma"}';
    */
    $postData = [];
    $url = "https://gptexcel.uk/api/tools/$tools";
    switch ($tools) {

        case 'formula':
            $tool = $_REQUEST['tool'] ?? "Microsoft Excel"; // value: Microsoft Excel, Google Sheets, Airtable
            $version = $_REQUEST['version'] ?? "Excel 2010"; // value: Excel 365, Excel 2021, Excel 2019, Excel 2016, Excel 2013, Excel 2010
            $separator = $_REQUEST['separator'] ?? "comma"; // value: comma or semicolon
            $postData = '{"prompt":"' . $prompt . '","tool":"' . $tool . '","action":"' . $act . '","uid":"xRIiZzZInEZwqSECYQH4JeIP2G02","isPro":true,"version":"' . $version . '","separator":"' . $separator . '"}';
            break;

        case 'script':
            $tool = $_REQUEST['tool'] ?? "VBA Script";
            $postData = '{"prompt":"' . $prompt . '","tool":"' . $tool . '","action":"' . $act . '","uid":"xRIiZzZInEZwqSECYQH4JeIP2G02","isPro":true}';
            break;

        case 'sql':
            # code...
            break;

        default:
            # code...
            break;
    }

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "Accept: application/json",
        "Origin: https://gptexcel.uk",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36",
        "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $data = "$postData";

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    echo $resp;
}

REQUESTAPI($tools, $prompt, $act);
