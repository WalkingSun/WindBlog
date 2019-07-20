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

class LeetcodeController extends Controller
{

    /**
     * leetcode推送
     */
    public function actionSend(){

        $url_perssion = 'https://leetcode-cn.com/announcement/api/get_permission/';
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
            }
            $cookie = $list['cookie'][0];
            $cookieArray = Common::getCookieList($cookie);
        }

        sort($problems);
        $count = count($problems);
        $leetcodeFile = \Yii::$app->basePath . '/runtime/logs/leetcode.log';
        if( file_exists($leetcodeFile) ){
            file_put_contents($leetcodeFile,json_encode(['data'=>[]]));
        }
        $leetcode_log =  file_get_contents($leetcodeFile);
        if( is_null($leetcode_log) ){
            $leetcode_logs_exists = [];
        }else{
            $leetcode_logs_exists = json_decode($leetcode_log,1);
        }

        $randi = rand(0,$count);
        while(in_array($problems[$randi]['question_id'],$leetcode_logs_exists)){
            $randi = rand(0,$count);
        }
        $leetcode_logs_exists['data'][] = $problems[$randi]['question_id'];
        file_put_contents($leetcodeFile,json_encode($leetcode_logs_exists));

        //获取question内容
        $questionDataUrl = 'https://leetcode-cn.com/graphql';
        $questionHeader = [
            'accept: */*',
            'accept-encoding: gzip, deflate, br',
            'accept-language: zh-CN,zh;q=0.9',
            'content-type: application/json',
            'origin: https://leetcode-cn.com',
            'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36',
            "referer: https://leetcode-cn.com/problems/{$problems[$randi]['question__title_slug']}/",
            "x-csrftoken: {$cookieArray['csrftoken']}"
        ];
        $questionDataParams =  json_encode([
            'operationName'  => "questionData",
            'variables'  => ['titleSlug'=> $problems[$randi]['question__title_slug']],
            'query'  => "query questionData(\$titleSlug: String!) {
  question(titleSlug: \$titleSlug) {
    questionId
    questionFrontendId
    boundTopicId
    title
    titleSlug
    content
    translatedTitle
    translatedContent
    isPaidOnly
    difficulty
    likes
    dislikes
    isLiked
    similarQuestions
    contributors {
      username
      profileUrl
      avatarUrl
      __typename
    }
    langToValidPlayground
    topicTags {
      name
      slug
      translatedName
      __typename
    }
    companyTagStats
    codeSnippets {
      lang
      langSlug
      code
      __typename
    }
    stats
    hints
    solution {
      id
      canSeeDetail
      __typename
    }
    status
    sampleTestCase
    metaData
    judgerAvailable
    judgeType
    mysqlSchemas
    enableRunCode
    enableTestMode
    envInfo
    __typename
  }
}
"
        ]);

        $questionDataRes = Common::httpPostByCookie($questionDataUrl,$questionHeader,$questionDataParams,true,$cookie);

        print_r($questionDataRes);die;

    }





}