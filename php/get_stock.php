<?php

include "redis.php";

$hour = date('H');
$min  = date('i');
$request = true;
// 不住开盘时间内
if (9 > $hour || 15 < $hour) {
    $request = false;
}
if (15 == $hour && $min) {
    $request = false;
}
if ($hour == 9) {
    if ($min < 30) {
        $request = false;
    }
}
if (11 == $hour) {
    if ($min > 30) {
        $request = false;
    }
}
if (12 == $hour) {
    $request = false;
}

if (!$request) {
    echo "Stock market not open this time: ".date('Y-m-d H:i:s').PHP_EOL;
    die;
}

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


function simple_get($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$exec = curl_exec($ch);
	curl_close($ch);
	return $exec;
}

// var_dump(MyRedis::get('foo'));die;

$key = 'edf1334608c75e51747fd72c7bf0824d';

// 请求地址：http://web.juhe.cn:8080/finance/stock/hs
// 请求参数：gid=&type=0&key=edf1334608c75e51747fd72c7bf0824d
// 请求方式：GET
// gid string  是   股票编号，上海股市以sh开头，深圳股市以sz开头如：sh601009（type为0或者1时gid不是必须）   
// type    int 否   0代表上证指数，1代表深证指数
/*
$url = "http://web.juhe.cn:8080/finance/stock/hs?key=$key&type=";
$json = simple_get($url.'0');
$arr  = json_decode($json, true);
if (0 === intval($arr['error_code'])) {
    MyRedis::set('shang', json_encode($arr['result']));
}
// type    int 否   0代表上证指数，1代表深证指数
$json = simple_get($url.'1');
$arr  = json_decode($json, true);
if (0 === intval($arr['error_code'])) {
    MyRedis::set('shen', json_encode($arr['result']));
}
print_r(MyRedis::get('shang'));
print_r(MyRedis::get('shen'));
die;
*/

// 沪股列表
// http://web.juhe.cn:8080/finance/stock/shall?stock=a&page=1&type=20&key=edf1334608c75e51747fd72c7bf0824d
// 深圳股市列表
// http://web.juhe.cn:8080/finance/stock/szall?stock=a&page=1&type=80&key=edf1334608c75e51747fd72c7bf0824d
$shall = "http://web.juhe.cn:8080/finance/stock/shall?";
$szall = "http://web.juhe.cn:8080/finance/stock/szall?";
$sh_stocks = array();
$sz_stocks = array();
$sh_pages = 17;
$sz_pages = 27;
$page = 1;

while (true) {
    $para = array(
        'stock'=>'a',
        'page' =>$page,
        'type' =>4,
        'key'  =>$key
    );
    $url = $shall.http_build_query($para);
    $json = simple_get($url);
    $arr  = json_decode($json, true);
    // echo $url.PHP_EOL;
    // print_r($arr);die;
    if (0 == $arr['error_code'] && $arr['result']) {
        // $total_pages = $arr['result']['totalCount']/$arr['result']['num'];
    	foreach ($arr['result']['data'] as $item) {
    		// echo $item['symbol'].";".$item['name'].PHP_EOL;
            $sh_stocks[$item['symbol']]= $item;
            MyRedis::sAdd('all_shang_set', $item['symbol']);
            MyRedis::set($item['symbol'], json_encode($item));
    	}
    }
    // MyRedis::sMembers('all_shang_set');
    $page++;
    if ($page > $sh_pages) {
        break;
    }
}
// var_dump(MyRedis::sMembers('all_shang_set'));die;

$page = 1;
while (true) {
    $para = array(
        'stock'=>'a',
        'page' =>$page,
        'type' =>4,
        'key'  =>$key
    );
    $url = $szall.http_build_query($para);
    $json = simple_get($url);
    $arr  = json_decode($json, true);
    // print_r($arr);die;
    if (0 == $arr['error_code'] && $arr['result']) {
        // $total_pages = $arr['result']['totalCount']/$arr['result']['num'];
        foreach ($arr['result']['data'] as $item) {
            // echo $item['symbol'].";".$item['name'].PHP_EOL;
            $sh_stocks[$item['symbol']]= $item;
            MyRedis::sAdd('all_shen_set', $item['symbol']);
            MyRedis::set($item['symbol'], json_encode($item));
        }
    }
    // MyRedis::sMembers('all_shen_set');
    $page++;
    if ($page > $sz_pages) {
        break;
    }
}
// var_dump(MyRedis::sMembers('all_shen_set'));die;


