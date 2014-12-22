<?php
/* 
Plugin Name: Weixin Assistant
Version: 0.0.1
Plugin URI: http://www.imdevice.com
Description: 微信助手
Author: Lu Chunwei
Author URI: http://www.imdevice.com
*/

define("TOKEN","imdevice");

// $wechat=new wechatCallbackApi();
// $wechat->valid();
//$wechat->respondMsg(); 

require_once 'youdao.php';
		
class WX_MSG_TYPE{
	public static $text="text";
	public static $image="image";
	public static $voice="voice";
	public static $video="video";
	public static $location="location";
	public static $link="link";
	public static $event="event";
	public static $music="music";
	public static $news="news";	
}
class WX_EVENT_TYPE{
	public static $subscribe="subscribe";
	public static $unsubscribe="unsubscribe";
	public static $scan="scan";
	public static $location="LOCATION";
	public static $click="CLICK";
	
}

class wechatCallbackApi
{
		/**
		 * 当普通微信用户向公众账号发消息时，微信服务器将POST消息的XML数据包到开发者填写的URL上。
		 * 大部分post用application/x-www.form-urlencoded标准的数据类型，可使用_POST接收。
		 * 但若是使用text/xml或者soap或者application/octet-stream;charset=UTF-8的数据类型就要用$GLOBALS["HTTP_RAW_POST_DATA"]来接收。
		 * 
		 * post xml format		 
		 * <xml>
		 * <ToUserName><![CDATA[toUser]]></ToUserName>
		 * <FromUserName><![CDATA[fromUser]]></FromUserName> 
		 * <CreateTime>1348831860</CreateTime>
		 * <MsgType><![CDATA[text]]></MsgType>
		 * <Content><![CDATA[this is a test]]></Content>
		 * <MsgId>1234567890123456</MsgId>
		 * </xml>
		 * 
		 * respond xml format		 
		 * <xml>
		 * <ToUserName><![CDATA[toUser]]></ToUserName>
		 * <FromUserName><![CDATA[fromUser]]></FromUserName>
		 * <CreateTime>12345678</CreateTime>
		 * <MsgType><![CDATA[text]]></MsgType>
		 * <Content><![CDATA[你好]]></Content>
		 * </xml>
		 */
	public function respondMsg(){
		$postStr=$GLOBALS["HTTP_RAW_POST_DATA"];
		if(!empty($postStr)){
			$postXml= simplexml_load_string($postStr);
			$toUserName=$postXml->ToUserName;
			$fromUserName=$postXml->FromUserName;
			$msgType=$postXml->MsgType;
			$keyword=$postXml->Content;
			$time=time();
			
			$respondXmlTpl="<xml>
							 <ToUserName><![CDATA[%s]]></ToUserName>
							 <FromUserName><![CDATA[%s]]></FromUserName>
							 <CreateTime>%s</CreateTime>
							 <MsgType><![CDATA[%s]]></MsgType>
							 <Content><![CDATA[%s]]></Content>
							</xml>";
			if(!empty($keyword)){
				$content=$keyword;
				$respondXml=sprintf($respondXmlTpl,$fromUserName,$toUserName,$time,$msgType,$content);
				echo $respondXml;
			}else{
				echo "input something...";
			}
		}else{
			echo "nothing received.";
			exit;
		}
	}
	
	/**
	 * @return void
	 * @desc 开发者通过检验signature对请求进行校验（下面有校验方式）。
	 * 若确认此次GET请求来自微信服务器，请原样返回echostr参数内容，则接入生效，成为开发者成功，否则接入失败。
	 */
	public function valid(){
		$echoStr=$_GET["echostr"];
		if($this->checkSignature()){
			echo $echoStr;
			exit;
		}
	}
	
	/**
	 * @desc 检验signature,加密/校验流程如下：
	 * 1. 将token、timestamp、nonce三个参数进行字典序排序
	 * 2. 将三个参数字符串拼接成一个字符串进行sha1加密
	 * 3. 开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
	 *
	 * @return bool
	 */
	private function checkSignature()
	{
		//GET /weixin.php?signature=b2cab3391bfff174e1ee46fca14d6b1a45aed9da&echostr=5948773415674059893&timestamp=1384782965&nonce=1385056738
	        $signature = $_GET["signature"];
	        $timestamp = $_GET["timestamp"];
	        $nonce = $_GET["nonce"];	 
/* 		$signature = "b2cab3391bfff174e1ee46fca14d6b1a45aed9da";
		$timestamp = "1384782965";
		$nonce = "1385056738";
	echo "signature=".$signature.'<hr>';
	echo "timestamp=".$timestamp.'<hr>';
	echo "nonce=".$nonce.'<hr>';
	*/
			$token = TOKEN;
			$tmpArr = array($token, $timestamp, $nonce);
	
			sort($tmpArr,SORT_STRING);
			$tmpStr = implode( $tmpArr );
	//echo "implode tmpStr=".$tmpStr.'<hr>';		
			$tmpStr = sha1( $tmpStr );
	//echo "sha1 tmpStr=".$tmpStr.'<hr>';			
	//echo "tmpStr == signature ? ".( $tmpStr == $signature ).'<hr>';	
			if( $tmpStr == $signature ){
				return true;
			}else{
				return false;
			}
	}
}

class Operator{
	/**
	 * 
	 * @param SimpleXMLElement  $xmlMsg ,an object returned by "simplexml_load_string()"
	 */
	public static  function operate($xmlMsg){
/* 				$msg=new weChatTextMessage();
				$msg->fromUserName=$xmlMsg->ToUserName;
				$msg->toUserName=$xmlMsg->FromUserName;
				$msg->content=$xmlMsg->asXML();
				echo $msg->respondXml();
				exit(); */
		$msgType=$xmlMsg->MsgType;
		switch ($msgType) {
			case WX_MSG_TYPE::$text :
				self::repondXmlText($xmlMsg);
				break;
			case WX_MSG_TYPE::$image :
				self::repondXmlImage($xmlMsg);
				break;
			case WX_MSG_TYPE::$voice :
				self::repondXmlVoice($xmlMsg);
				break;
			case WX_MSG_TYPE::$video :
				self::repondXmlVideo($xmlMsg);
				break;
			case WX_MSG_TYPE::$location :
				echo $msgType . PHP_EOL;
				break;
			case WX_MSG_TYPE::$news :
				echo $msgType . PHP_EOL;
				break;
			case WX_MSG_TYPE::$music :
				echo $msgType . PHP_EOL;
				break;
			case WX_MSG_TYPE::$link :
				echo $msgType . PHP_EOL;
				break;
			case WX_MSG_TYPE::$event:
				echo $msgType.PHP_EOL;
				$eventType=(string)$xmlMsg->Event;
				switch ($eventType){
					case WX_EVENT_TYPE::$subscribe:
						self::respondSubscribeXML($xmlMsg);
						break;
					case WX_EVENT_TYPE::$unsubscribe:
						echo $eventType.PHP_EOL;
						break;
					case WX_EVENT_TYPE::$scan:
						echo $eventType.PHP_EOL;
						break;
					case WX_EVENT_TYPE::$location:
						echo $eventType.PHP_EOL;
						break;
					case WX_EVENT_TYPE::$click:
						echo $eventType.PHP_EOL;
						break;
					default: echo "default handler for [".$eventType."] event ".PHP_EOL;
				}
				break;
			default: echo "default handler for [".$msgType."] message ".PHP_EOL;
		}
	}
	private static  function who2who($msg,$xmlMsg){
		$msg->fromUserName=$xmlMsg->ToUserName;
		$msg->toUserName=$xmlMsg->FromUserName;
	}
	private static function getArticles(){
/* 		$articles=array(
				array("title"=>"微信公众大会透露的杀气，最有价值信息在这里",
						"description"=>"昨日微信公众沟通会有关“微信开放”很火爆，除了爆满的用户需求，和被透露的那些一个个数字，200万公众帐号，2亿多月活跃用户，等等，更重要的是其主旨，开放，以及连接一切人、物、钱和场景的可能性",
						"picUrl"=>"http://www.tmtpost.com/wp-content/uploads/2013/11/138479787478-560x372.jpg",
						"url"=>"http://www.imdevice.com/215227/"),
				array("title"=>"互联网金融只是互联网吗？",
						"description"=>"粗看了遍江南愤青的”互联网金融本质是互联网”，看完一个感觉：不明觉厉，所以又读了一遍，基本是目前互联网金融发展状况的一些总结，以及资管怎么结合的问题，道理说了很多，不过总感觉意犹未尽，没有说清楚互联网",
						"picUrl"=>"http://www.tmtpost.com/wp-content/uploads/2013/11/138482744916.jpg",
						"url"=>"http://www.imdevice.com/215221/")
		); */
		$url="http://www.imdevice.com/wp2weixin/";
		$json = file_get_contents($url);
		$articles=json_decode($json,true);
		return $articles;
	}
	private static function getTranslation($q){
		$youdao=new Youdao();
		return $youdao->weixin($q);
	}
	private static function respondSubscribeXML($xmlMsg){
		$msg=new weChatTextMessage();
		$msg->fromUserName=$xmlMsg->ToUserName;
		$msg->toUserName=$xmlMsg->FromUserName;
		$welcome="欢迎来到imdevice.com\n";
		$welcome.="IMDevice爱米手机网 汇集和分享国内外最新最潮最酷的智能手机、平板电脑、互联网应用等科技资讯及创业项目等业界动态信息，为您提供清爽简洁的一站式阅读体验。";
		$welcome.="\n\n";
		$welcome.="发送news 来获取最新资讯\n";
		$welcome.="发送fy 或 翻译 空格+要翻译的内容 可获得中英文互译\n";
		$msg->content=$welcome;
		echo $msg->respondXml();
	}
	private static function repondXmlDefault($xmlMsg){
		$msg=new weChatTextMessage();
		$msg->fromUserName=$xmlMsg->ToUserName;
		$msg->toUserName=$xmlMsg->FromUserName;
		$msg->content=$xmlMsg->asXML();
		echo $msg->respondXml();
	}
	private static function repondXmlText($xmlMsg){
		$content=(string)$xmlMsg->Content;
		switch ($content){
			case "news":
				$msg=new weChatNewsMessage();
				self::who2who($msg, $xmlMsg);
				$msg->articles=self::getArticles();
				echo $msg->respondXml();
				break;
			case (strpos(strtolower($content),"fy")===0):
			case (strpos($content,"翻译")===0):
				$length=mb_strlen($content,"utf-8");
				$q=trim(mb_substr($content,2,$length-2,"utf-8"));
				$msg=new weChatTextMessage();
				self::who2who($msg, $xmlMsg);
				if($q){
					$msg->content=self::getTranslation($q);
				}else{
					$msg->content="请输入 fy xxx 或 翻译 xxx，来进行中英文互译";
				}
				echo $msg->respondXml();
				break;
				
			default:
				$msg=new weChatTextMessage();
				self::who2who($msg, $xmlMsg);
				$msg->content=$xmlMsg->Content;
				echo $msg->respondXml();				
		}
	}
	private function repondXmlImage($xmlMsg){
		$msg=new weChatImageMessage();
		self::who2who($msg, $xmlMsg);
		$msg->mediaId=$xmlMsg->MediaId;
		echo $msg->respondXml();
	}
	private function repondXmlVoice($xmlMsg){
		$msg=new weChatVoiceMessage();
		self::who2who($msg, $xmlMsg);
		$msg->mediaId=$xmlMsg->MediaId;
		echo $msg->respondXml();
	}
	private function repondXmlVideo($xmlMsg){
		$msg=new weChatVideoMessage();
		self::who2who($msg, $xmlMsg);
		$msg->mediaId=$xmlMsg->MediaId;
		$msg->thumbMediaId=$xmlMsg->ThumbMediaId;
		echo $msg->respondXml();
	}
}

class weChatMessage{
	public static $TYPE=array(
						"text"=>"text",
						"image"=>"image",
						"voice"=>"voice",
						"video"=>"video",
						"location"=>"location",
						"link"=>"link",
						"event"=>"event",
						"music"=>"music",
						"news"=>"news"
						);
	public static $EVENT=array(
						"subscribe"=>"subscribe",
						"unsubscribe"=>"unsubscribe",
						"scan"=>"scan",
						"location"=>"LOCATION",
						"click"=>"CLICK",
	);
	/**开发者微信号*/
	public $toUserName;
	/**发送方帐号（一个OpenID）*/
	public $fromUserName;
	/**消息创建时间 （整型）*/
	public $createTime;
	/**消息类型*/
	public $msgType;
	/**消息id，64位整型*/
	public $msgId;
	protected $xmlSpecial="<Content><![CDATA[This is a Text Message.]]></Content>";
	protected $xmlSpecialRespond="<Content><![CDATA[This is a Text Message.]]></Content>";
	protected $xmlSpecialRespondJson='{"content":"Hello World"}';
	protected $xmlCommon=
				 "<ToUserName><![CDATA[%s]]></ToUserName>
				 <FromUserName><![CDATA[%s]]></FromUserName>
				 <CreateTime>%s</CreateTime>
				 <MsgType><![CDATA[%s]]></MsgType>
				 <MsgId>%s</MsgId>"; 
	protected $xmlCommonRspond=
				 "<ToUserName><![CDATA[%s]]></ToUserName>
				 <FromUserName><![CDATA[%s]]></FromUserName>
				 <CreateTime>%s</CreateTime>
				 <MsgType><![CDATA[%s]]></MsgType>"; 
	protected $xmlCommonRspondJson=	 '"touser":"%1$s", "msgtype":"%2$s","%2$s":';
	function __construct(){
		$this->toUserName="toUser接收人";
		$this->fromUserName="fromUser发送人";
		$this->msgType=WX_MSG_TYPE::$text;
		$this->createTime=time();
	}

	protected function specialItemsToXml(){
		return $this->xmlSpecial;
	}
	protected function commonItemsToXml(){
		return sprintf($this->xmlCommon,$this->toUserName,$this->fromUserName,$this->createTime,$this->msgType,$this->msgId);
	}
	protected function specialItemsRespondXml(){
		return $this->xmlSpecialRespond;
	}
	protected function specialItemsRespondJson(){
		return $this->xmlSpecialRespondJson;
	}
	protected function commonItemsRespondXml(){  //$this->iterate();
		return sprintf($this->xmlCommonRspond,$this->toUserName,$this->fromUserName,$this->createTime,$this->msgType);
	}
	protected function commonItemsRespondJson(){
		return sprintf($this->xmlCommonRspondJson,$this->toUserName,$this->msgType);
	}
	protected function wrapWithMediaType($mediaType,$content){
		return sprintf("<%s>%s</%s>",$mediaType,$content,$mediaType);
	}
	public function iterate(){
		print static ::who()."::iterateVisible:\n";
		foreach ($this as $key=>$value){
			print "$key => $value\n";
		}
	}
	private static function who(){
		return get_called_class();
	}
	/**
	 * Received Message in xml format
	 **/
	public function toXml(){
		return "<xml>".$this->commonItemsToXml().$this->specialItemsToXml()."</xml>";
	}
	/**
	 * Respond Message in xml format
	 **/
	public function respondXml(){
		return "<xml>".$this->commonItemsRespondXml().$this->specialItemsRespondXml()."</xml>";
	}
	/**
	 * Respond Message in json format
	 **/
	public function respondJson(){
		return "{".$this->commonItemsRespondJson().$this->specialItemsRespondJson()."}";
	}
}

class weChatTextMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$text;		
	}
	/**文本消息内容*/
	public $content;
	protected $xmlSpecial="<Content><![CDATA[%s]]></Content>";
	protected $xmlSpecialRespond="<Content><![CDATA[%s]]></Content>";
	protected $xmlSpecialRespondJson='{"content":"%s"}';
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->content);
	}
	protected function specialItemsRespondXml(){
		return sprintf($this->xmlSpecialRespond,$this->content);
	}
	protected function specialItemsRespondJson(){
		return sprintf($this->xmlSpecialRespondJson,$this->content);
	}
}
class weChatImageMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$image;		
	}
	/**图片链接*/
	public $picUrl;
	/**图片消息媒体id，可以调用多媒体文件下载接口拉取数据。*/
	public $mediaId;
	protected $xmlSpecial="<PicUrl><![CDATA[%s]]></PicUrl>
 						   <MediaId><![CDATA[%s]]></MediaId>";
	protected $xmlSpecialRespond="<MediaId><![CDATA[%s]]></MediaId>";
	protected $xmlSpecialRespondJson='{"media_id":"%s"}';
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->picUrl,$this->mediaId);
	}
	protected function specialItemsRespondXml(){
			$xml= sprintf($this->xmlSpecialRespond,$this->mediaId);
			return $this->wrapWithMediaType("Image",$xml);
		}
	protected function specialItemsRespondJson(){
		return sprintf($this->xmlSpecialRespondJson,$this->mediaId);
	}
}
class weChatVoiceMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$voice;		
	}
	/**语音格式，如amr，speex等*/
	public $format;
	/**语音消息媒体id，可以调用多媒体文件下载接口拉取数据。*/
	public $mediaId;
	protected $xmlSpecial="<MediaId><![CDATA[%s]]></MediaId>
 						   <Format><![CDATA[%s]]></Format>";
	protected $xmlSpecialRespond="<MediaId><![CDATA[%s]]></MediaId>";
	protected $xmlSpecialRespondJson='{"media_id":"%s"}';
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->mediaId,$this->format);
	}
	protected function specialItemsRespondXml(){
		$xml= sprintf($this->xmlSpecialRespond,$this->mediaId);
		return $this->wrapWithMediaType("Voice",$xml);
	}
	protected function specialItemsRespondJson(){
		return sprintf($this->xmlSpecialRespondJson,$this->mediaId);
	}
}
/**
 * 开通语音识别功能，用户每次发送语音给公众号时，微信会在推送的语音消息XML数据包中，增加一个Recongnition字段。
 * 注：由于客户端缓存，开发者开启或者关闭语音识别功能，对新关注者立刻生效，对已关注用户需要24小时生效。
 * 开发者可以重新关注此帐号进行测试。
 */
class weChatVoiceRecognitionMessage extends weChatVoiceMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$voice;		
	}
	/**语音识别结果，UTF8编码*/
	public $recognition;
	protected $xmlSpecialExtend="<Recognition><![CDATA[%s]]></Recognition>";
	protected function specialItemsToXml(){
		$voiceSpecial=parent::specialItemsToXml();
		return $voiceSpecial.sprintf($this->xmlSpecialExtend,$this->recognition);
	}
}
class weChatVideoMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$video;		
	}
	/**视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。*/
	public $thumbMediaId;
	/**视频消息媒体id，可以调用多媒体文件下载接口拉取数据。*/
	public $mediaId;
	protected $xmlSpecial="<MediaId><![CDATA[%s]]></MediaId>
 						   <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>";
	protected $xmlSpecialRespondJson='{"media_id":"%s", "thumb_media_id":"%s"}';
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->mediaId,$this->thumbMediaId);
	}
	protected function specialItemsRespondXml(){
		$xml= sprintf($this->xmlSpecial,$this->mediaId,$this->thumbMediaId);
		return $this->wrapWithMediaType("Video",$xml);
	}
	protected function specialItemsRespondJson(){
		return sprintf($this->xmlSpecialRespondJson,$this->mediaId,$this->thumbMediaId);
	}
}
class weChatLocationMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$location;		
	}
	/**地理位置纬度。*/
	public $location_X;
	/**地理位置经度。*/
	public $location_Y;
	/**地图缩放大小。*/
	public $scale;
	/**地理位置信息。*/
	public $label;
	protected $xmlSpecial="<Location_X>%s</Location_X>
							<Location_Y>%s</Location_Y>
							<Scale>%s</Scale>
							<Label><![CDATA[%s]]></Label>";
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->location_X,$this->location_Y,$this->scale,$this->label);
	}
}
class weChatLinkMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$link;		
	}
	/**消息标题*/
	public $title;
	/**消息描述*/
	public $description;
	/**消息链接*/
	public $url;

	protected $xmlSpecial="<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
							<Url><![CDATA[%s]]></Url>";
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->title,$this->description,$this->url);
	}
}
class weChatMusicMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$music;		
	}
	/**音乐标题*/
	public $title;
	/**音乐描述*/
	public $description;
	/**音乐链接*/
	public $music_url;
	/**高品质音乐链接*/
	public $hq_music_url;
	/**音乐消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据。*/
	public $thumbMediaId;

	protected $xmlSpecial="<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
							<MusicUrl><![CDATA[%s]]></MusicUrl>
							<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
 						    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>";
	protected $xmlSpecialRespondJson='{ "title":"%s",
														      "description":"%s",
														      "musicurl":"%s",
														      "hqmusicurl":"%s",
														      "thumb_media_id":"%s" }';
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->title,$this->description,$this->music_url,$this->hq_music_url,$this->thumbMediaId);
	}
	protected function specialItemsRespondXml(){
		$xml= $this->specialItemsToXml();
		return $this->wrapWithMediaType("Music",$xml);
	}
	protected function specialItemsRespondJson(){
		return sprintf($this->xmlSpecialRespondJson,$this->title,$this->description,$this->music_url,$this->hq_music_url,$this->thumbMediaId);
	}
}
class weChatNewsMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$news;		
	}
	/**
	 * 多条图文消息信息，默认第一个item为大图，限制为10条以内
	 * 是一个article数组，每个article包含以下四项：
	 * title：图文消息标题
	 * description：图文消息描述
	 * picUrl：图片链接，支持JPG、PNG格式，较好的效果为大图360*200，小图200*200
	 * url:点击图文消息跳转链接
	 */
	public $articles;

	protected $xmlSpecial="<ArticleCount>%s</ArticleCount>
							<Articles>%s</Articles>";
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,count($this->articles),$this->dumpArticlesXml($this->articles));
	}
	protected function specialItemsRespondXml(){
		return $this->specialItemsToXml();
	}
	protected function specialItemsRespondJson(){
		return sprintf('"{articles": [%s]}',$this->dumpArticlesJson($this->articles));
	}
	private function dumpArticlesXml(&$articles){
		$xml="";
		$n=0;
		foreach($articles as &$article){
			$xml.= $this->articleXml($article);
			if($n++==10)break;
		}
		return $xml;
	}
	private function articleXml($article){
		$tpl="<item>
			<Title><![CDATA[%s]]></Title>
			<Description><![CDATA[%s]]></Description>
			<PicUrl><![CDATA[%s]]></PicUrl>
			<Url><![CDATA[%s]]></Url>
			</item>";
		return sprintf($tpl,$article["title"],$article["description"],$article["picUrl"],$article["url"]);
	}
	private function dumpArticlesJson(&$articles){
		$json="";
		$n=0;
		foreach($articles as &$article){
			$json.= $this->articleJson($article).',';
			if($n++==10)break;
		}
		return rtrim($json,',');
	}
	private function articleJson($article){
		$tpl='{
	             "title":"%s",
	             "description":"%s",
	             "picurl":"%s",
	             "url":"%s"
         		}';
		return sprintf($tpl,$article["title"],$article["description"],$article["picUrl"],$article["url"]);
	}
}

/**
 * 关注/取消关注事件
 * 用户在关注与取消关注公众号事，微信会把这个事件推送到开发者填写的URL。
 * 方便开发者给用户下发欢迎消息或者做帐号的解绑。
 */
class weChatEventMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$event;		
		$this->event=WX_EVENT_TYPE::$subscribe;
	}
	/**事件类型，关注/取消关注事件,subscribe(订阅)、unsubscribe(取消订阅)*/
	public $event;
	protected $xmlSpecial="<Event><![CDATA[%s]]></Event>";
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->event);
	}
}
/**
 * 自定义菜单事件
 * 用户点击自定义菜单后，如果菜单按钮设置为click类型，则微信会把此次点击事件推送给开发者，
 * 注意view类型（跳转到URL）的菜单点击不会上报。
 */
class weChatMenuEventMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$event;	
		$this->event=WX_EVENT_TYPE::$click;
	}
	/**事件类型，CLICK*/
	public $event;
	/**事件KEY值，与自定义菜单接口中KEY值对应*/
	public $eventKey;
	protected $xmlSpecial="<Event><![CDATA[%s]]></Event><EventKey><![CDATA[%s]]></EventKey>";
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->event,$this->eventKey);
	}
}

/**
 * 扫描二维码事件
 * 用户扫描带场景值二维码时，可能推送以下两种事件：
 * 如果用户还未关注公众号，则用户可以关注公众号，关注后微信会将带场景值关注事件推送给开发者。
 * 如果用户已经关注公众号，则微信会将带场景值扫描事件推送给开发者。
 */
class weChatQREventMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$event;		
		$this->event=WX_EVENT_TYPE::$scan;
	}
	/**事件类型，未关注时subscribe(订阅)、已关注时scan*/
	public $event;
	/**事件KEY值，
	 * 未关注时是"qrscene_123123"，qrscene_为前缀，后面为二维码的参数值。
	 * 已关注时是一个32位无符号整数*/
	public $eventKey;
	/**二维码的ticket，可用来换取二维码图片*/
	public $ticket;
	protected $xmlSpecial="<Event><![CDATA[%s]]></Event>
							<EventKey><![CDATA[%s]]></EventKey>
							<Ticket><![CDATA[%s]]></Ticket>";
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->event,$this->eventKey,$this->ticket);
	}
}

/**用户同意上报地理位置后，每次进入公众号会话时，都会在进入时上报地理位置，
 * 或在进入会话后每5秒上报一次地理位置，公众号可以在公众平台网站中修改以上设置。
 * 上报地理位置时，微信会将上报地理位置事件推送到开发者填写的URL。
 */
class weChatLocationEventMessage extends weChatMessage {
	function __construct(){
		parent::__construct();
		$this->msgType=WX_MSG_TYPE::$event;		
		$this->event=WX_EVENT_TYPE::$location;
	}
	/**事件类型，LOCATION*/
	public $event;
	/**地理位置纬度*/
	public $latitude;
	/**地理位置经度*/
	public $longitude;
	/**地理位置精度*/
	public $precision;
	protected $xmlSpecial="<Event><![CDATA[%s]]></Event>
							<Latitude>%s</Latitude>
							<Longitude>%s</Longitude>
							<Precision>%s</Precision>";
	protected function specialItemsToXml(){
		return sprintf($this->xmlSpecial,$this->event,$this->latitude,$this->longitude,$this->precision);
	}
}

function testMessages(){
/*
	$msg=new weChatMessage();
	$msg->toUserName="toUser接收人";
	$msg->fromUserName="fromUser发送人";
	$msg->msgType="text";
	$msg->createTime=time();
	echo $msg->toXml().PHP_EOL;
	echo $msg->respondXml().PHP_EOL;
	
	$textMsg=new weChatTextMessage();
	echo $textMsg->toXml().PHP_EOL;
	$imageMsg=new weChatImageMessage();
	echo $imageMsg->toXml().PHP_EOL;
	echo $imageMsg->respondXml().PHP_EOL;
	$voiceMsg=new weChatVoiceMessage();
	echo $voiceMsg->toXml().PHP_EOL;
	$voiceRecognitionMsg=new weChatVoiceRecognitionMessage();
	echo $voiceRecognitionMsg->toXml().PHP_EOL;
	$videoMsg=new weChatVideoMessage();
	echo $videoMsg->toXml().PHP_EOL;
	$locationMsg=new weChatLocationMessage();
	echo $locationMsg->toXml().PHP_EOL;
	$linkMsg=new weChatTextMessage();
	echo $linkMsg->toXml().PHP_EOL;

	*/
	//Change the Messag type to test all kind of messages.
	$msg=new weChatNewsMessage();
	
	function setParams($msg){
		$articles=array(
				array("title"=>"标题1","description"=>"描述1","picUrl"=>"http://www.imdevice.com/10000/pic.jpg","url"=>"http://www.imdevice.com/10000"),
				array("title"=>"标题2","description"=>"描述2","picUrl"=>"http://www.imdevice.com/20000/pic.jpg","url"=>"http://www.imdevice.com/20000")
		);
		$msg->content="消息内容";
		$msg->eventKey="关键字";
		$msg->msgId="1213871409182349";
		$msg->ticket="二维码897140987123987410";
		$msg->latitude="23.137466";
		$msg->longitude="113.352425";
		$msg->precision="119.385040";
		$msg->location_X="23.137466";
		$msg->location_Y="113.352425";
		$msg->label="地理位置信息";
		$msg->picUrl="abc.com/pic.jpg";
		$msg->mediaId="MEDIA_ID";
		$msg->thumbMediaId="THUMB_MEDIA_ID";
		$msg->scale="20";
		$msg->format="如amr，speex等";
		$msg->recognition="语音识别结果，UTF8编码";
		$msg->articles=$articles;
		$msg->title="Title";
		$msg->description="description";
		$msg->url="http://imdevice.com";
		$msg->music_url="http://imdevice.com/song.mp3";
		$msg->hq_music_url="http://imdevice.com/hqsong.mp3";
		//$msg->event=WX_EVENT_TYPE::$unsubscribe;
	}
	setParams($msg);
	//$xmlMsg=simplexml_load_string($msg->toXml());
	//echo $xmlMsg->count().PHP_EOL;
	//var_dump(get_object_vars($xmlMsg));
	//var_dump(property_exists($xmlMsg, "Content"));
	echo $msg->respondJson();
	$xmlMsg=simplexml_load_string($msg->respondXml());
	Operator::operate($xmlMsg);
	echo $xmlMsg->asXML();
		
}

//testMessages();

function responseMsg(){
	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
	if (!empty($postStr)){
		$xmlMsg=simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		Operator::operate($xmlMsg);
	}else{
		echo "";
		exit;
	}
}

responseMsg();
?>
