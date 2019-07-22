<?php
/**
 * Created by PhpStorm.
 * User: zhaoyu
 * Date: 2019/7/20
 * Time: 10:51 AM
 */

namespace app\commands;


use app\models\Common;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

/**
 * 抓取leetcode
 * Class LeetcodeController
 * @package app\commands
 */
class LeetcodeController extends Controller
{
    public  $tags;    //标签：

    public function options($actionID)
    {
        return ['tags'];
    }

    /**
     * leetcode推送 | tags：  stack 栈；heap 堆；greedy 贪心算法；sort 排序；tree 树；binary-search-tree 二叉搜索树；recursion 递归；queue 队列；array 数组；hash-table 哈希表；linked-list 链表；string 字符串；binary-search 二分查找
     */
    public function actionSend(  ){
        $url_perssion = 'https://leetcode-cn.com/announcement/api/get_permission/';
        try{
            $perssion = Common::httpGetByCookie($url_perssion,'',[],true);
            $cookie = $perssion['cookie'][0];

            $cookieArray = Common::getCookieList($cookie);

            //获取题目连接信息
            $problemUrl = 'https://leetcode-cn.com/api/problems/all/';
            $problemHeader = [
                'accept: application/json, text/javascript, */*; q=0.01',
                'accept-encoding: gzip, deflate, br',
                'accept-language: zh-CN,zh;q=0.9',
                'content-type: application/json',
                'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36',
                'x-requested-with: XMLHttpRequest',
            ];
            $problemRes = Common::httpGetByCookie($problemUrl, '',$problemHeader,false,$cookie);
            $problemRes = json_decode($problemRes,1);

            $problems = [];
            foreach ($problemRes['stat_status_pairs'] as $v){
                $problems[$v['stat']['question_id']] = [
                    'question_id'  => $v['stat']['question_id'],      //前端显示questionid
                    'frontend_question_id'  => $v['stat']['frontend_question_id'],      //前端显示questionid
                    'question__title_slug'  => $v['stat']['question__title_slug'],      //question标签
                    'question_url' => 'https://leetcode-cn.com/problems/'. $v['stat']['question__title_slug'],
                ];
            }

            //获取标题
            $listUrl = 'https://leetcode-cn.com/graphql';
            $header = [
                'content-type: application/json',
                'accept-encoding: gzip, deflate, br',
                'referer: https://leetcode-cn.com/problemset/all/',
                'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36',
                "x-csrftoken: {$cookieArray['csrftoken']}"
            ];
            $data = json_encode([
                'operationName'  => 'getQuestionTranslation',
                'variables'  => '',
                'query'  => "query getQuestionTranslation(\$lang: String) {
                            translations: allAppliedQuestionTranslations(lang: \$lang) {
                                title
                                content
                                questionId
                                __typename
                            }
                        }",
            ]);
            $list = Common::httpPostByCookie($listUrl,'',$header,$data,true,$cookie);
            if(  isset($list['response']) ){
                $listData = json_decode($list['response'],1);
                foreach ($listData['data']['translations'] as $v){
                    if(!isset($problems[$v['questionId']]))continue;
                    $problems[$v['questionId']]['title'] = $v['title'];
                    $problems[$v['questionId']]['content'] = $v['content'];
                }
                $cookie = $list['cookie'][0];
                $cookieArray = Common::getCookieList($cookie);
            }

            //获取标签信息
            $tagUrl = 'https://leetcode-cn.com/problems/api/tags/';
            $tagList = Common::httpGetByCookie($tagUrl,'',$header,false,$cookie);
            if( !$tagList ) throw new \Exception('tags not found');

            $tagList = json_decode($tagList,1);
            $tagLists = ArrayHelper::index($tagList['topics'],'slug');

            sort($problems);
            $count = count($problems);
            $leetcodeFile = \Yii::$app->basePath . '/runtime/logs/leetcode.log';
            if( !file_exists($leetcodeFile) ){
                file_put_contents($leetcodeFile,json_encode(['data'=>[]]));
            }
            $leetcode_log =  file_get_contents($leetcodeFile);
            if( is_null($leetcode_log) ){
                $leetcode_logs_exists = [];
            }else{
                $leetcode_logs_exists = json_decode($leetcode_log,1);
            }

            if( !$this->tags ){
                $randi = rand(0,$count);
                while(in_array($problems[$randi]['question_id'],$leetcode_logs_exists)){
                    $randi = rand(0,$count);
                }
            }else{
                $findtags = explode(',',$this->tags);
                if( !$findtags )
                    throw new \Exception('请输入标签信息');

                $questions = [];
                foreach ($findtags as $v){
                    if( !isset($tagLists[$v]) )
                        throw new \Exception('请输入正确的标签信息');
                    $questions += $tagLists[$v]['questions'];
                }
                $count = count($questions);
                $randj = rand(0,$count);
                while(in_array($questions[$randj],$leetcode_logs_exists)){
                    $randj = rand(0,$count);
                }
                $questionId = $questions[$randj];
                $randi = Common::findByIteration($problems,$questionId,'question_id');
            }

            $leetcode_logs_exists['data'][] = $problems[$randi]['question_id'];
            file_put_contents($leetcodeFile,json_encode($leetcode_logs_exists));

            //wx reboot
            $wxMsg = "【LeetCode】". $problems[$randi]['title'] ."\r\n\r\n". $problems[$randi]['question_url'];
            $wxRebotData = [
                'msgtype' => 'text',
                'text' => [
                    'content'=> $wxMsg,
//                'mentioned_list'=> ['高峰;'],//'@all'
                    'mentioned_mobile_list'=> [],//'@all' '15026852404'
                ]
            ];
//            Common::httpPost('https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=b17603f1-7181-4c3e-8167-bd6dcbe9d146',$wxRebotData);

            //推送邮件
            $JpKnowledgeRecoveryConfigModel = 'app\models\JpKnowledgeRecoveryConfig';
            $config = $JpKnowledgeRecoveryConfigModel::find()->where(['userId'=>'super','isDelete'=>0])->asArray()->one();
            \Yii::$app->mailer->setTransport([
                'class' => 'Swift_SmtpTransport',
                'host' => $config['setSmtp'],
                'username' => $config['setEmail'],
                'password' => $config['setEmailPwd'],
                'port' => '465',       //阿里对25端口限制
                'encryption' => 'ssl',  //MAIL_ENCRYPTION加密方式由‘tsl’改成‘ssl’php
            ]);
            \Yii::$app->mailer->compose('leetcode',['data'=>$problems[$randi]]) // compose()渲染一个视图作为邮件内容
            ->setFrom($config['setEmail'])
                ->setTo($config['sendEmail'])
                ->setSubject($problems[$randi]['title'])
                ->send();
        }catch (\Exception $e){
            var_dump($e->getMessage());
            Common::addLog('leetcode_error.log',$e->getMessage(),1);
        }

        print_r($problems[$randi]);die('success');

    }





}