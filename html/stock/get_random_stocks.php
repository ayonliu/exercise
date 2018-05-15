<?php

include "../../php/redis.php";

$shang = array(
    603993,
    601998,
    601989,
    601988,
    601985,
    601901,
    601899,
    601881,
    601857,
    601818,
    601800,
    601788,
    601766,
    601727,
    601688,
    601669,
    601668,
    601633,
    601628,
    601618,
    601601,
    601398,
    601390,
    601336,
    601328,
    601318,
    601288,
    601229,
    601225,
    601211,
    601186,
    601169,
    601166,
    601111,
    601088,
    601018,
    601009,
    601006,
    600999,
    600958,
    600919,
    600900,
    600893,
    600887,
    600837,
    600795,
    600703,
    600690,
    600663,
    600637,
    600606,
    600585,
    600519,
    600518,
    600340,
    600309,
    600276,
    600115,
    600104,
    600061,
    600050,
    600048,
    600036,
    600030,
    600028,
    600023,
    600019,
    600018,
    600016,
    600015,
    600011,
    600010,
    600000
);
$shen=array(
    300059,
    2797,
    2739,
    2736,
    2594,
    2558,
    2415,
    2352,
    2304,
    2252,
    2142,
    2027,
    2024,
    1979,
    895,
    858,
    776,
    725,
    651,
    625,
    538,
    333,
    166,
    69,
    63,
    2,
    1
);

$rand_keys_shang = array_rand($shang, 5);
$rand_keys_shen = array_rand($shen, 5);
shuffle($rand_keys_shang);
shuffle($rand_keys_shen);

// print_r($rand_keys_shang);
// print_r($rand_keys_shen);
$all = array();
$shang_stocks = array();
$shen_stocks = array();
foreach ($rand_keys_shang as $stock_key) {
    $key = 'sh'.$shang[$stock_key];
    $get = MyRedis::get($key);
    if ($get) {
        $shang_stocks[] = json_decode($get, true);   
    }
}
$all['shang'] = $shang_stocks;
foreach ($rand_keys_shen as $stock_key) {
    $key = 'sz'.str_pad($shen[$stock_key], 6, '0', STR_PAD_LEFT);
    // echo $key.'<br/>';
    $get = MyRedis::get($key);
    if ($get) {
        $shen_stocks[] = json_decode($get, true);
    }
}
$all['shen'] = $shen_stocks;
// echo '<pre>';
// print_r($all);die;

header('Content-type: application/json');
// echo MyRedis::get($key);
echo json_encode($all);


