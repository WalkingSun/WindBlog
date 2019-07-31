<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/18
 * Time: 18:14
 */

namespace app\models;


use PHPHtmlParser\Dom;

class ArtitleJuejin implements Article
{
    use \app\models\HttpRequestTrait;

//var r = ["架构", "开源", "算法", "GitHub", "面试", "代码规范", "产品", "掘金翻译计划"];
//e.a = {
//home: r,
//frontend: ["前端", "CSS", "JavaScript", "HTML", "React.js", "Vue.js", "Webpack", "微信", "TypeScript"],
//android: ["Android", "Kotlin", "Android Studio", "gradle", "RxJava", "React Native", "Material Design"],
//backend: ["后端", "Java", "数据库", "Node.js", "Linux", "PHP", "MySQL", "Redis", "Python", "MongoDB"],
//ios: ["Mac", "Apple", "Swift", "Xcode", "Objective-C", "macOS"],
//freebie: r,
//article: r,
//ai: ["Python", "机器学习", "NLP", "数据挖掘", "人工智能", "OpenAI", "神经网络", "深度学习", "TensorFlow"],
//devops: ["运维", "Linux", "Nginx", "服务器", "容器", "Docker", "Kubernetes", "云计算", "连续集成"]
//}

    public $tag = [
        'all' => '推荐',
        '5562b415e4b00c57d9b94ac8' => ['id'=>'5562b415e4b00c57d9b94ac8','name'=>'前端','title'=>'frontend'],
        '5562b410e4b00c57d9b94a92' => ['id'=>'5562b410e4b00c57d9b94a92','name'=>'Android','title'=>'android'],
        '5562b419e4b00c57d9b94ae2' => ['id'=>'5562b419e4b00c57d9b94ae2','name'=>'后端','title'=>'backend'],
        '57be7c18128fe1005fa902de' => ['id'=>'57be7c18128fe1005fa902de','name'=>'人工智能','title'=>'ai'],
        '5562b405e4b00c57d9b94a41' => ['id'=>'5562b405e4b00c57d9b94a41','name'=>'iOS','title'=>'ios'],
        '5562b422e4b00c57d9b94b53' => ['id'=>'5562b422e4b00c57d9b94b53','name'=>'工具资源','title'=>'freebie'],
        '5562b428e4b00c57d9b94b9d' => ['id'=>'5562b428e4b00c57d9b94b9d','name'=>'阅读','title'=>'article'],
        '5b34a478e1382338991dd3c1' => ['id'=>'5b34a478e1382338991dd3c1','name'=>'运维','title'=>'devops'],
    ];



    public function list( $data=[] ){
        $result = [];
        $tag = !empty($data['tag'])?$data['tag']:'5562b419e4b00c57d9b94ae2';//'all';
        $limit = !empty($data['limit'])?$data['limit']:20;

        $url = "https://timeline-merger-ms.juejin.im/v1/get_entry_by_rank?src=web&limit={$limit}&category={$tag}";
        $info = Common::httpGet($url);
        $info = json_decode($info,1);
        $result['list'] = $this->analysis( $info);
        $result['tag'] = $this->getTag();

        return $result;
    }

    public function analysis( $data=[] ){
        $result = [];
        if( $data['m']=='ok' ){
            $k=0;
            foreach ($data['d']['entrylist'] as $v){
                $result[$k]['title'] = $v['title'];
                $result[$k]['content'] = $v['content'];
                $result[$k]['tags'] = $v['tags'];
                $result[$k]['link'] = $v['originalUrl'];
                $result[$k]['published'] = date("Y-m-d H:i",strtotime($v['updatedAt']));

                $result[$k]['author']['name'] = $v['user']['username'];
                $result[$k]['author']['uri'] = '';
                $result[$k]['author']['avatar'] = $v['user']['avatarLarge'];
                $result[$k]['diggs'] = $v['collectionCount'];

                $k++;
            }
        }

        return $result;
    }

    /**
     * 获取标签
     */
    public function getTag(){
        //todo  抓取所有分类id

        return $this->tag;
    }

    /**
     * 拉取文章
     */
    public function pull($url=null):void{
        //收藏集文章
        $collectionUrl = 'https://collection-set-ms.juejin.im/v1/getUserCollectionSet?src=web&page=0&pageSize=30&targetUserId=5ba33eb86fb9a05cd24d8f2e';
        $collections = $this->httpGet( $collectionUrl );
        $collections = json_decode($collections,1);
        if( isset($collections['d']['collectionSets']) ){
            foreach ($collections['d']['collectionSets'] as $v){

                $collectionPage = 'https://juejin.im/collection/'.$v['csId'];
                $dom = new Dom();
                $dom->load( $this->httpGet( $collectionPage) );
                $t = $dom->find('.title-row a');
                $data[] = ['userId'=>'super','title'=>$t->text,'content'=>'','href'=>'https://juejin.im'.$t->href,'tag'=>$v['title'],'type'=>'','remark'=>'来源Juejin','createtime'=>date('Y-m-d H:i:s')];
            }

            $model_new =  new \app\models\JpKnowledgeRecovery;
            foreach ( $data as $v ){
                $model_new->saveData($v);
            }
        }
    }
}