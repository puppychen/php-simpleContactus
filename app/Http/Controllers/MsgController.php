<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class MsgController extends Controller
{
    private $url = "";
    private $chat_id = "";
    private $title = "xxx Contact us";
    public function send(Request $request){
        $ch = curl_init();
        $message = $this->getBody( $request );
        $pdata = array(
            'chat_id'	=>	$this->chat_id,
            'text'	=>	  $this->title. ':'. "\n"."\n".$message);
        curl_setopt($ch, CURLOPT_URL, $this->url );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $pdata ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        $msg_return =  curl_exec($ch);
        curl_close($ch);
        return  $msg_return;

    }
    private function getBody($get_data){
        $body_str = '';
        foreach( $get_data as $temp_word => $value) {
            if( strstr( $temp_word , 'data_'))
            {
                $body_str .= "<b>". str_replace("data_", "", $temp_word). "</b>: ". $value ."\n";
            }
        }
        return $body_str;
    }
    private function getArrayStr($name, $data_array)
    {
        $temp_count = count($data_array);
        $str = $name .": \n";
        for($k=0;$k <= ($temp_count-1);$k++)
        {
            $str .= "　". $data_array[$k] ."\n";
        }
        return $str;
    }
}