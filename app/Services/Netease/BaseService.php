<?php
namespace App\Services\Netease;
class BaseService
{
    protected $AppKey = '';
    protected static $AppSecret = '';
    protected $Nonce;                    //随机数（最大长度128个字符）
    protected $CurTime;                 //当前UTC时间戳，从1970年1月1日0点0 分0 秒开始到现在的秒数(String)
    protected $CheckSum;                //SHA1(AppSecret + Nonce + CurTime),三个参数拼接的字符串，进行SHA1哈希计算，转化成16进制字符(String，小写)
    const   HEX_DIGITS = '0123456789abcdef';
    protected $baseUri = 'https://api.netease.im';
    protected $client;



    /**
     * @author ShaoZeMing
     * @email szm19920426@gmail.com
     * @param $url
     * @param $data
     * @return mixed
     */
    protected function post($url,$data)
    {
    }






    public  function checkSumBuilder()
    {
        //生成随机字符串
        $hex_digits= self::HEX_DIGITS;
        $this->Nonce = '';
        for ($i=0;$i<128;++$i)   //随机字符串最大128个字符，也可以小于该数
        {
            $this->Nonce .= $hex_digits[rand(0, 15)];  //此处rand是下标。
        }
        dd($hex_digits[rand(0, 15)]);
        dd($this->Nonce);
    }







}