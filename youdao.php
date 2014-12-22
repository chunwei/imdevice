<?php
//http://fanyi.youdao.com/openapi.do?keyfrom=<keyfrom>&key=<key>&type=data&doctype=<doctype>&version=1.1&q=要翻译的文本
/**
版本：1.1，请求方式：get，编码方式：utf-8
主要功能：中英互译，同时获得有道翻译结果和有道词典结果（可能没有）
参数说明：
　type - 返回结果的类型，固定为data
　doctype - 返回结果的数据格式，xml或json或jsonp
　version - 版本，当前最新版本为1.1
　q - 要翻译的文本，不能超过200个字符，需要使用utf-8编码
errorCode：
　0 - 正常
　20 - 要翻译的文本过长
　30 - 无法进行有效的翻译
　40 - 不支持的语言类型
　50 - 无效的key

xml数据格式举例:
<?xml version="1.0" encoding="UTF-8"?>
<youdao-fanyi>
    <errorCode>0</errorCode>
    <query><![CDATA[lunar]]></query>
    <!-- 有道翻译 -->
    <translation>
            <paragraph><![CDATA[月球]]></paragraph>
        </translation>
    <!-- 有道词典-基本词典 -->
    <basic>
            <!-- 音标 -->
        <phonetic><![CDATA['luːnə]]></phonetic>
            <!-- 基本释义 -->
        <explains>
                    <ex><![CDATA[adj. 月亮的，月球的；阴历的；银的；微亮的]]></ex>
                    <ex><![CDATA[n. (Lunar)人名；(西)卢纳尔]]></ex>
                </explains>
    </basic>
    <!-- 有道词典-网络释义 -->
    <web>
            <explain>
            <key><![CDATA[lunar]]></key>
            <value>
                            <ex><![CDATA[月球的]]></ex>
                            <ex><![CDATA[月亮的]]></ex>
                            <ex><![CDATA[月的]]></ex>
                        </value>
        </explain>
            <explain>
            <key><![CDATA[lunar January]]></key>
            <value>
                            <ex><![CDATA[正月]]></ex>
                            <ex><![CDATA[岁首]]></ex>
                            <ex><![CDATA[侧月]]></ex>
                        </value>
        </explain>
            <explain>
            <key><![CDATA[Lunar plaque]]></key>
            <value>
                            <ex><![CDATA[登月纪念牌]]></ex>
                        </value>
        </explain>
        </web>
</youdao-fanyi>
 */
class Youdao{
	private $dataArr=array(
				'keyfrom' => 'IMDevice',
				'key' => '38119578',
				'type'=>'data',
				'doctype'=>'xml',
				'version'=>'1.1',
				'q'=>'hello'
		);
	public function fy($q){
		$this->dataArr["q"]=$q;
		$querydata = http_build_query($this->dataArr);
		$url='http://fanyi.youdao.com/openapi.do'.'?'.$querydata;
		$result = file_get_contents($url);
		//$result = file_get_contents('fanyi.xml');
		return $result;
	}
	public function web($q){
		$EOL="<br />";
		$respond='';
		$result=$this->fy($q);
		$xmlResult=simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
		$respond.= $xmlResult->query;
		if($xmlResult->basic->phonetic){
			$respond.= sprintf("  [ %s ]",$xmlResult->basic->phonetic);
		}
		if($xmlResult->translation->paragraph){
			$respond.= sprintf("$EOL%s$EOL",$xmlResult->translation->paragraph);
		}
		if($xmlResult->basic&&$xmlResult->basic->explains){
			//echo "基本词典".'<br />';
			$exs=$xmlResult->basic->explains->ex;
			foreach ($exs as $ex){
				$respond.= $ex.$EOL;
			}
		}
		if($xmlResult->web&&$xmlResult->web->explain){
			$respond.= $EOL."网络释义".$EOL;
			$explains=$xmlResult->web->explain;
			foreach ($explains as $explain){
				$respond.= $explain->key.$EOL;
				$exs= $explain->value->ex;
				$exstr='';
				foreach ($exs as $ex){
					$exstr.= $ex.' | ';
				}
				$respond.= rtrim($exstr," |").$EOL;
			}
		}
		return $respond;
	}
	public function weixin($q){
		$EOL="\n";
		$respond='';
		$result=$this->fy($q);
		$xmlResult=simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
		$respond.= $xmlResult->query;
		if($xmlResult->basic->phonetic){
			$respond.= sprintf("  [ %s ]",$xmlResult->basic->phonetic);
		}
		if($xmlResult->translation->paragraph){
			$respond.= sprintf("$EOL%s$EOL",$xmlResult->translation->paragraph);
		}
		if($xmlResult->basic&&$xmlResult->basic->explains){
			//echo "基本词典".'<br />';
			$exs=$xmlResult->basic->explains->ex;
			foreach ($exs as $ex){
				$respond.= $ex.$EOL;
			}
		}
		if($xmlResult->web&&$xmlResult->web->explain){
			$respond.= $EOL."网络释义".$EOL;
			$explains=$xmlResult->web->explain;
			foreach ($explains as $explain){
				$respond.= $explain->key.$EOL;
				$exs= $explain->value->ex;
				$exstr='';
				foreach ($exs as $ex){
					$exstr.= $ex.' | ';
				}
				$respond.= rtrim($exstr," |").$EOL;
			}
		}
		return $respond;
	}
}

/* $youdao=new Youdao();
//$youdao->fy($_GET["q"]);
//print_r($youdao->fy('lunar'));
//$youdao->weixin('lunar');
$youdao->weixin($_GET["q"]); */





