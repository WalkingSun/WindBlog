<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/18
 * Time: 18:02
 */

namespace app\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class ArticleFactory
{
    static private $instance;
    public static $blogs = [
         [
            'id' => '1',
            'name' => '博客园',
            'icon' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGYAAABmCAIAAAC2vXM1AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NTc3MiwgMjAxNC8wMS8xMy0xOTo0NDowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjlBNjZGODJBNDAyMTExRTZCOEUyOTJCQTE1RTY4NTA5IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjlBNjZGODJCNDAyMTExRTZCOEUyOTJCQTE1RTY4NTA5Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OUE2NkY4Mjg0MDIxMTFFNkI4RTI5MkJBMTVFNjg1MDkiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6OUE2NkY4Mjk0MDIxMTFFNkI4RTI5MkJBMTVFNjg1MDkiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz69bBYBAAAII0lEQVR42uyc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',
             'bgcolor' => '#3983D6'
        ],
         [
            'id' => '2',
            'name' => '思否',
            'icon' => 'https://cdn.segmentfault.com/v-5c19e300/global/img/favicon.ico',
             'bgcolor' => '#009A61'
         ],
        [
            'id' => '3',
            'name' => '掘金',
            'icon' => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8IS0tIENyZWF0b3I6IENvcmVsRFJBVyBYNyAtLT4NCjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iOC4zODU3bW0iIGhlaWdodD0iOC4xOTIzbW0iIHZlcnNpb249IjEuMSIgc3R5bGU9InNoYXBlLXJlbmRlcmluZzpnZW9tZXRyaWNQcmVjaXNpb247IHRleHQtcmVuZGVyaW5nOmdlb21ldHJpY1ByZWNpc2lvbjsgaW1hZ2UtcmVuZGVyaW5nOm9wdGltaXplUXVhbGl0eTsgZmlsbC1ydWxlOmV2ZW5vZGQ7IGNsaXAtcnVsZTpldmVub2RkIg0Kdmlld0JveD0iMCAwIDUwOSA0OTciDQogeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPg0KIDxkZWZzPg0KICA8c3R5bGUgdHlwZT0idGV4dC9jc3MiPg0KICAgPCFbQ0RBVEFbDQogICAgLmZpbDAge2ZpbGw6IzAwNkNGRn0NCiAgICAuZmlsMSB7ZmlsbDp3aGl0ZX0NCiAgIF1dPg0KICA8L3N0eWxlPg0KIDwvZGVmcz4NCiA8ZyBpZD0i5Zu+5bGCX3gwMDIwXzEiPg0KICA8bWV0YWRhdGEgaWQ9IkNvcmVsQ29ycElEXzBDb3JlbC1MYXllciIvPg0KICA8cmVjdCBjbGFzcz0iZmlsMCIgd2lkdGg9IjUwOSIgaGVpZ2h0PSI0OTciLz4NCiAgPHBhdGggaWQ9IkZpbGwtMS1Db3B5IiBjbGFzcz0iZmlsMSIgZD0iTTI4NSAxMzhsLTMxIC0yNCAtMzMgMjUgLTIgMiAzNSAyNyAzNCAtMjcgLTMgLTN6bTExOSA5NWwtMTUwIDExNiAtMTUxIC0xMTYgLTIyIDE3IDE3MyAxMzQgMTczIC0xMzQgLTIzIC0xN3ptLTE1MCA5bC04MiAtNjMgLTIzIDE3IDEwNSA4MSAxMDQgLTgxIC0yMiAtMTcgLTgyIDYzeiIvPg0KIDwvZz4NCjwvc3ZnPg0K',
            'bgcolor' => '#007fff'
        ],
//        '4'  => '开源中国',
    ];

    private function __construct($config){

    }

    public static function init(array $config = [])
    {
        $type = $config['type']?:1;
        switch ($type){
            case 1:
                self::$instance = new ArtitleCnblogs();
                break;
            case 2:
                self::$instance = new ArtitleSegment();
                break;
            case 3:
                self::$instance = new ArtitleJuejin();
                break;
            default:
                break;
        }
        return self::$instance;
    }

}