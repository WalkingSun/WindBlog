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
            'icon' => 'data:image/vnd.microsoft.icon;base64,AAABAAEAICAAAAEAIACoEAAAFgAAACgAAAAgAAAAQAAAAAEAIAAAAAAAABAAABILAAASCwAAAAAAAAAAAABemgBJYZoA42GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgDjXpoASWGaAONhmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgDjYZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoB/4y2R/+605H/1+W//+Hs0P/X5sD/xdqi/6LDaf9nnQr/YZoA/2GaAP9hmgD/YZoA/2GaAP+Crzb/osNq/6LDav+iw2r/osNq/2SbBf9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/4eyPv/k7tX///////////////////////////////////////P37P+QuE3/YZoA/2GaAP9hmgD/YZoA/7HNgv//////////////////////aJ4M/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/8vfr//////////////////////////////////////////////////j69P9+rTD/YZoA/2GaAP9hmgD/sMyA//////////////////////9nngv/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP+nxnH///////r8+P+50o//iLNA/4KvNv+ty3z/+/36/////////////////83fr/9hmgD/YZoA/2GaAP+vy37//////////////////////2eeC/9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2ScBv/M3q7/fKss/2GaAP9hmgD/YZoA/2GaAP/F2qP/////////////////7fPj/2GaAP9hmgD/YZoA/63LfP//////////////////////Z54L/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/ZJsF/93pyf/////////////////u9OT/YZoA/2GaAP9hmgD/rMp6//////////////////////9nnQr/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/ZJsF/5W7Vf/f6sz//////////////////////9Tku/9hmgD/YZoA/2GaAP+ryXj//////////////////////2adCf9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/Zp0J/6jHdP/w9ef/////////////////////////////////jLZH/2GaAP9hmgD/YZoA/6rIdv//////////////////////ZZ0I/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/3ipJv/l7tb/////////////////////////////////+vz4/6DCZ/9hmgD/YZoA/2GaAP9hmgD/qMd0//////////////////////9knAb/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9lnAf/5u/X////////////////////////////9vnx/7vTkv90piD/YZoA/2GaAP9hmgD/YZoA/2GaAP+nx3L//////////////////////2SbBf9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/5S6U///////////////////////5+/Z/5u/Xv9mnQn/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/6bGcP//////////////////////YpsD/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/r8t+//////////////////n79v9qoBD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/pcVu//////////////////////9hmgH/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP+synr/////////////////9/rz/2qfD/9hmgD/YZoA/2GaAf+Vu1T/j7dL/2GaAP9hmgD/ap8P/3SmIP+ty3z//////////////////f79/3KlHf91pyH/dqci/2GaAf9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/4ayPf//////////////////////8fbp/8ncqf/P4LL/7PPh///////m79j/YpoC/2GaAP+lxW//////////////////////////////////////////////////Z50K/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/8LYnv////////////////////////////////////////////////+YvVn/YZoA/6TFbf////////////////////////////////////////////////9pnw3/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/ZJsF/7zUlP/5+/b////////////////////////////9/v3/zuCx/3+tMv9hmgD/osNq/////////////////////////////////////////////////2qfD/9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/26iFf+avl3/rct8/7rTkP+qyXf/l7xY/3SmH/9hmgD/YZoA/2GaAP9roBH/eqop/7XQif//////////////////////eako/3qqKf97qyv/YpoC/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/rMp6//////////////////7+/v9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP+wzID//////////////////f79/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/6fHcv//////////////////////b6MX/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/jrdK///////////////////////E2aH/iLNA/6bGcP90ph//YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9voxf/+Pv1/////////////////////////////////63LfP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP+nxnH/////////////////////////////////5e7W/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAf+YvVr/6PDa/////////////////+705P++1Zf/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/Z50K/3WnIf9pnw7/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgDjYZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA416aAElhmgDjYZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAP9hmgD/YZoA/2GaAONemgBJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',
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
        $type = $config['type']??$config['id']??1;
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
            case 4:
                self::$instance = new ArtitleGithub();
                break;
            default:
                break;
        }
        return self::$instance;
    }

}