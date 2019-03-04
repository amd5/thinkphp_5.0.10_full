<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function curl_func($url,$data='',$method='GET',$encode='UTF-8',$ssl='')
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   //1不显示内容，0显示内容
    // $header=array(
    //     "Accept: application/json",
    //     "Content-Type: application/json;charset=utf-8",
    // );

    // curl_setopt($curl, CURLOPT_HTTPHEADER, $header); 
    if ($ssl = 'ssl') {
    	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    }
    if ($method == 'POST') {
    	curl_setopt($curl, CURLOPT_POST, 1);
    	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    $data = curl_exec($curl);
    curl_close($curl);
    if ($encode == 'GBK') {
    	$data = mb_convert_encoding($data, 'utf-8', 'GBK,UTF-8,ASCII');
    }
    return $data;
}

/**
 * Json返回
 * @param string $message
 * @param int $code 0 默认成功
 * @return string
 */
function api_return($message='', $code='', $count=0 , $data=[])
{
    $return = [
        'code' => $code ?: 0,
        'msg'  => $message ?: 'success',
        'count' => $count ?:0,
        'data' => $data
    ];
    return json($return);
};