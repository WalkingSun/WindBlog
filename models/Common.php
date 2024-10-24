<?php
/**
 * Created by PhpStorm.
 * User: MW
 * Date: 2018/6/10
 * Time: 22:36
 */

namespace app\models;


class Common
{

    /***
     * Metaweblog 地址
     * @param $id  int    1 51cto;2 sina;3 csdn;4 163;5 oschina;6 cnblogs;7 chinaunix
     * @param $blogId string 博客id,有些博客需要，例如 cnblogs
     * 各大博客MetaWeblog地址
    http://imguowei.blog.51cto.com/xmlrpc.php	51cto
    http://upload.move.blog.sina.com.cn/blog_rebuild/blog/xmlrpc.php	sina
    http://write.blog.csdn.net/xmlrpc/index	csdn（每日20篇文章）
    http://os.blog.163.com/word/	163
    https://my.oschina.net/action/xmlrpc	oschina
    http://www.cnblogs.com/博客名称/services/metaweblog.aspx	cnblogs
    http://blog.chinaunix.net/xmlrpc.php?r=rpc/server	chinaunix
     */
    public static function MetaweblogUrl( $id='',$blogId='' ){

        $data = [
            1   =>  'http://imguowei.blog.51cto.com/xmlrpc.php',
            2   =>  'http://upload.move.blog.sina.com.cn/blog_rebuild/blog/xmlrpc.php',
            3   =>  'http://write.blog.csdn.net/xmlrpc/index',
            4   =>  'http://os.blog.163.com/word/',
            5   =>  'https://my.oschina.net/action/xmlrpc',
            6   =>  "https://rpc.cnblogs.com/metaweblog/{$blogId}",//'http://www.cnblogs.com/'.$blogId.'/services/metaweblog.aspx', 地址更改
            7   =>  ' http://blog.chinaunix.net/xmlrpc.php?r=rpc/server',
        ];

        if( $id ){
            return $data[$id];
        }

        return $data;
    }

    /**
     * blogType对应参数名称
     * @param $id int 1 51cto;2 sina;3 csdn;4 163;5 oschina;6 cnblogs;7 chinaunix
     */
    public static function blogParamName( $id='' ){
        $data = [
            1   =>    '51cto',
            2   =>    'sina',
            3   =>    'csdn',
            4   =>    '163',
            5   =>    'oschina',
            6   =>    'cnblogs',
            7   =>    'chinaunix',
        ];
        if( $id ) return $data[$id];
        return $data;
    }

    public  static function echoJson( $code,$msg,$data=[] ){

        $data = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];

        echo json_encode($data);
        exit();
    }

    /**
     * @param $file  日志文件名称
     * @param string $msg   消息
     * @param int $end  中断 1 是，0 否
     */
    public static function addLog( $file , $msg='', $end=0 ){

        $msg = is_string($msg) ? $msg : print_r($msg,1);

        error_log(date("Y-m-d H:i:s") . "：{$msg}\r\n\r\n", 3, \Yii::$app->basePath . '/runtime/logs/'.date('Ymd').$file);

        if( $end ){
            exit();
        }
    }


    /**
     * http psot
     * @param $url String url
     * @param $port String 端口号
     * @param $header Array 头信息
     * @param $data Array 数据
     */
    public static function httpPostByCookie($url,$port='',$header=[],$data='',$returnHeader=false,$cookie=[]){
        $result = [];

        if( is_array($data) ){
            $data = http_build_query($data);
        }

        $curl = curl_init();
        $dd =  array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => ($data),
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_FOLLOWLOCATION =>  1,
//            CURLOPT_COOKIEJAR => \Yii::$app->basePath.'/cookie.txt',
//            CURLOPT_COOKIEJAR => self::$cookie
        );
        if($port) $dd[CURLOPT_PORT] = $port;
        if( $returnHeader ) $dd[CURLOPT_HEADER] = 1;   //返回头部信息
        if( $cookie ) $dd[CURLOPT_COOKIE] = $cookie;        //发送cookie

        curl_setopt_array($curl, $dd);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);//Common::addLog('sign.log',$response);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            preg_match_all("/Set-Cookie:(.*)\n/iU",$response,$str); //正则匹配//            print_r($str);die;
            $result['cookie'] = isset($str[1]) ?$str[1]:''; ;
            preg_match("/{.+}/",$response,$str1);
            $result['response'] =  isset($str1) ?array_pop($str1):'';
            return $result;
        }

    }


    /**
     * http get
     * @param $url String url
     * @param $port String 端口号
     * @param $header Array 头信息
     */
    public static function httpGetByCookie($url,$port='',$header=[],$returnHeader=false,$cookie=[]){
        $result = [];
        $curl = curl_init();
        $dd =  array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_FOLLOWLOCATION =>  1,
//            CURLOPT_COOKIEJAR => \Yii::$app->basePath.'/cookie.txt',
        );
        if($port) $dd[CURLOPT_PORT] = $port;
        if( $returnHeader ) $dd[CURLOPT_HEADER] = 1;   //返回头部信息
        if( $cookie ) $dd[CURLOPT_COOKIE] = $cookie;        //发送cookie

        curl_setopt_array($curl, $dd);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);//        Common::addLog('sign.log',$response);

        if ($err) {
            echo "cURL Error #:" . $err;
        } elseif($returnHeader) {
            preg_match_all("/Set-Cookie:(.*)\n/iU",$response,$str); //正则匹配
            $result['cookie'] = isset($str[1]) ?$str[1]:''; ;
            preg_match("/{.+}/",$response,$str1);
            $result['response'] =  isset($str1) ?array_pop($str1):''; ;
            return $result;
        }else{
            return $response;
        }

    }

    public static function excepDeal( $msg ){
        //todo 发送邮件

        Common::addLog('error.log',$msg);
    }

    public static function httpGet( $url ){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 4fa2ee01-6bf0-4975-9523-0a69e8812210",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
//        var_dump($url,$response,$err,file_get_contents($url));die;
        if ($err) {
            throw new \Exception("cURL Error #:" . $err);
            return false;
        } else {
            return $response;
        }
    }

    public static function filter($val,$type='',$de=''){
        $val=Common::daddslashes($val);   //使用反斜线引用字符串 (对提交数据的过滤)
        //过滤字符
        $filterList = [ ';','#','%','select','from','insert','update','delete'];
        $val = str_replace($filterList,'',$val);
        switch ($type) {

            case 'int':
                return intval($val);
                break;

            case 'float':
                return floatval($val);
                break;

            default:
                return htmlspecialchars($val,ENT_QUOTES);   //把预定义的字符转换为 HTML 实体
                break;
        }
    }

    public static function daddslashes($string, $force = 1) {
        if(is_array($string)) {
            $keys = array_keys($string);
            foreach($keys as $key) {
                $val = $string[$key];
                unset($string[$key]);
                $string[addslashes($key)] = Common::daddslashes($val, $force);
            }
        } else {
            $string = addslashes($string);           //在预定义字符之前添加反斜杠的字符串
        }
        return $string;
    }

    public static function sendEmail( $host,$usernamae,$password,$port=25,$encryption,$fromEmail,$toEmail,$title,$content,$body='' ){
        \Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => $host,
            'username' => $usernamae,
            'password' => $password,
            'port' => $port,       //465 阿里对25端口限制
            'encryption' => $encryption,  //MAIL_ENCRYPTION加密方式由‘tsl’改成‘ssl’
        ]);

        \Yii::$app->mailer->compose() // compose()渲染一个视图作为邮件内容
        ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setSubject($title)
            ->setTextBody($content)
            ->setHtmlBody($body)
            ->send();

    }


    public static function httpPost( $url, $msg ){

        if( is_array($msg) ){
            $msg = json_encode($msg);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $msg,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            throw new \Exception("cURL Error #:" . $err);
        } else {
            return $response;
        }
    }

    /**解析原始cookie信息
     * @param $cookiestr
     * @return mixed
     */
    public static function getCookieList( $cookiestr ){
        $cookies = explode(';',$cookiestr);
        $cookieArray = [];
        foreach ($cookies as $v){
            $t = explode('=',$v);
            if( count($t)<2 ) continue;
            $cookieArray[trim($t[0])] = trim($t[1]);
        }
        return $cookieArray;
    }

    /**
     * @param $array
     * @param $find
     * @return int|string
     */
    public static function findByIteration($data,$find,$fileds=null)
    {
        foreach ($data as $key => $v)
        {
            if( !$fileds ){
                if($v==$find)
                {
                    return $key;
                }
            }else{
                if($v[$fileds]==$find)
                {
                    return $key;
                }
            }

        }
    }
}