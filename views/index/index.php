<?php
/**
 * Created by PhpStorm.
 * User: WalkingSun
 * Date: 2018/12/10
 * Time: 20:41
 */
$data = $result['list'];
$this->title = '技术文章';
?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>新标签页</title>
    <style type="text/css">
        /*! normalize.scss v0.1.0 | MIT License | based on git.io/normalize */
        html {
            font-family: sans-serif;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
            display: block
        }

        audio, canvas, progress, video {
            display: inline-block;
            vertical-align: baseline
        }

        audio:not([controls]) {
            display: none;
            height: 0
        }

        [hidden], template {
            display: none
        }

        a {
            background-color: transparent
        }

        a:active, a:hover {
            outline: 0
        }

        abbr[title] {
            border-bottom: 1px dotted
        }

        b, strong {
            font-weight: 700
        }

        dfn {
            font-style: italic
        }

        h1 {
            font-size: 2em;
            margin: .67em 0
        }

        mark {
            background: #ff0;
            color: #000
        }

        small {
            font-size: 80%
        }

        sub, sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sup {
            top: -.5em
        }

        sub {
            bottom: -.25em
        }

        img {
            border: 0
        }

        svg:not(:root) {
            overflow: hidden
        }

        figure {
            margin: 1em 40px
        }

        hr {
            box-sizing: content-box;
            height: 0
        }

        pre {
            overflow: auto
        }

        code, kbd, pre, samp {
            font-family: monospace, monospace;
            font-size: 1em
        }

        button, input, optgroup, select, textarea {
            color: inherit;
            font: inherit;
            margin: 0
        }

        button {
            overflow: visible
        }

        button, select {
            text-transform: none
        }

        button, html input[type=button], input[type=reset], input[type=submit] {
            -webkit-appearance: button;
            cursor: pointer
        }

        button[disabled], html input[disabled] {
            cursor: default
        }

        button::-moz-focus-inner, input::-moz-focus-inner {
            border: 0;
            padding: 0
        }

        input {
            line-height: normal
        }

        input[type=checkbox], input[type=radio] {
            box-sizing: border-box;
            padding: 0
        }

        input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button {
            height: auto
        }

        input[type=search] {
            -webkit-appearance: textfield;
            box-sizing: content-box
        }

        input[type=search]::-webkit-search-cancel-button, input[type=search]::-webkit-search-decoration {
            -webkit-appearance: none
        }

        fieldset {
            border: 1px solid silver;
            margin: 0 2px;
            padding: .35em .625em .75em
        }

        legend {
            border: 0;
            padding: 0
        }

        textarea {
            overflow: auto
        }

        optgroup {
            font-weight: 700
        }

        table {
            border-collapse: collapse;
            border-spacing: 0
        }

        td, th {
            padding: 0
        }

        .iScrollVerticalScrollbar {
            position: absolute;
            top: 0;
            right: 1px;
            bottom: 0;
            width: 5px;
            overflow: hidden
        }

        .iScrollIndicator {
            position: absolute;
            width: 100%
        }

        .iScrollIndicator:after {
            content: "";
            position: absolute;
            top: 1px;
            left: 0;
            right: 0;
            bottom: 1px;
            border-radius: 4px;
            background-color: rgba(0, 0, 0, .05)
        }

        body, html, input {
            font-size: 12px;
            font-family: PingFang SC, -apple-system, Arial, Microsoft YaHei, Microsoft JhengHei, Helvetica Neue, sans-serif;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1
        }

        body {
            position: absolute;
            width: 100%;
            height: 100%;
            min-width: 960px;
            overflow: hidden
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none
        }

        a {
            color: inherit;
            text-decoration: none
        }

        * {
            box-sizing: border-box
        }

        .layout {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            /*position: absolute;*/
            width: 100%;
            height: 100%;
            background-color: #eceff1;
            overflow: hidden
        }

        .navbar {
            -ms-flex: 0 0 auto;
            flex: 0 0 auto
        }

        .main-area {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            display: -ms-flexbox;
            display: flex;
            position: relative;
            margin: 1.8rem 1.2rem 0 1.8rem;
            overflow: hidden
        }

        .main-area .other-source {
            margin-left: 1.2rem
        }

        .source-navbar {
            margin-right: .8rem !important
        }

        .source-icon {
            width: 2.833rem;
            height: 2.833rem;
            border-radius: 2px
        }

        .entry-list {
            position: relative;
            overflow-y: hidden;
            padding-right: .8rem
        }

        .entry-list .loading {
            display: none
        }

        .entry-list .list {
            padding-bottom: 6rem
        }

        .entry-list .list.fetching .loading {
            display: block
        }

        .entry-list .list.failed, .entry-list .list.filled, .entry-list .list.syncing {
            position: relative;
            padding-bottom: 6rem
        }

        .entry-list .list.failed:after, .entry-list .list.filled:after, .entry-list .list.syncing:after {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 6rem;
            font-size: 1.2rem;
            line-height: 5rem;
            letter-spacing: 0;
            text-align: center;
            color: #c2c5cd
        }

        .entry-list .list.filled:after {
            content: "\2014\2014   \5DF2\663E\793A\5168\90E8\5185\5BB9   \2014\2014"
        }

        .entry-list .list.failed:after {
            content: "\2014\2014   \5185\5BB9\83B7\53D6\5931\8D25   \2014\2014"
        }

        .entry-list .list.syncing:after {
            content: "\6B63\5728\540C\6B65\5185\5BB9"
        }

        .img {
            background-color: hsla(219, 9%, 51%, .05)
        }

        .layout:not(.equalize) .gold-source {
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            width: 33.97rem
        }

        .layout:not(.equalize) .other-source {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }

        .layout.equalize .main-area {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: distribute;
            justify-content: space-around;
            width: 90rem;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto
        }

        .layout.equalize .main-area .gold-source, .layout.equalize .main-area .other-source {
            width: 45%
        }

        .layout.equalize .main-area > {
            margin: 0
        }

        .source-navbar {
            min-height: 3.5rem;
            background-color: #fff;
            border-radius: 2px;
            z-index: 250;
            -ms-flex-align: center
        }

        .source-navbar, .source-navbar .source-box {
            display: -ms-flexbox;
            display: flex;
            align-items: center
        }

        .source-navbar .source-box {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            height: 3.5rem;
            -ms-flex-align: center
        }

        .source-navbar .order-selector {
            margin-right: .8rem
        }

        .modal-box {
            position: fixed;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .2);
            z-index: 1000;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: row;
            flex-direction: row;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .app-transition {
            transition: opacity .15s linear;
            opacity: 1
        }

        .app-enter {
            opacity: 0
        }</style>
    <style type="text/css">
        .welcome-modal-box[_v-173f9211] {
            position: fixed;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .2);
            z-index: 1000;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: row;
            flex-direction: row;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .modal[_v-173f9211] {
            width: 60.667rem;
            min-width: 60.667rem;
            background-color: #fff;
            border-radius: 3px;
            overflow: hidden
        }

        .header[_v-173f9211] {
            position: relative;
            height: 12.833rem;
            background-color: #007fff;
            background: url(data:image/png;base64,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) 50%/cover
        }

        .header .close-btn[_v-173f9211] {
            float: right;
            padding: 1rem 1.4rem;
            font-size: 2rem;
            color: #fff;
            cursor: pointer;
            opacity: .2
        }

        .header .close-btn[_v-173f9211]:hover {
            transform: scale(1.1);
            opacity: .4
        }

        .body[_v-173f9211] {
            -ms-flex-direction: column;
            flex-direction: column;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .area-title[_v-173f9211] {
            font-size: 1.833rem;
            text-align: center;
            line-height: 4
        }

        .channel-box[_v-173f9211] {
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding: 0 8.6rem
        }

        .channel-box .channel-item[_v-173f9211], .channel-box[_v-173f9211] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .channel-box .channel-item[_v-173f9211] {
            width: 13.334rem;
            height: 3.834rem;
            margin: 0 0 1.5rem;
            border: 1px solid #e6edf4;
            border-radius: 2px;
            cursor: pointer
        }

        .channel-box .channel-item .icon[_v-173f9211] {
            width: 3.167rem;
            height: 3.167rem;
            margin: 0 1.1rem
        }

        .channel-box .channel-item .title[_v-173f9211] {
            font-size: 1.334rem
        }

        .channel-box .channel-item.active[_v-173f9211] {
            background-color: #f1f5fa;
            box-shadow: 0 0 0 2px #007fff
        }

        .channel-box .channel-item[_v-173f9211]:hover:not(.active) {
            background-color: rgba(241, 245, 250, .5);
            box-shadow: 0 0 0 1px rgba(0, 127, 255, .5)
        }

        .start-btn[_v-173f9211] {
            margin: 1.2rem 0 3.6rem;
            width: 28.917rem;
            height: 4.167rem;
            font-size: 1.5rem;
            color: #fff;
            background-color: #007fff;
            border: 0;
            border-radius: 4px;
            outline: 0
        }

        .start-btn[disabled][_v-173f9211] {
            background-color: #c2c5cd
        }</style>
    <style type="text/css">
        .modal[_v-8c48346e] {
            width: 40rem;
            min-width: 40rem;
            background-color: #fff;
            border-radius: 3px;
            overflow: hidden
        }

        .header[_v-8c48346e] {
            position: relative;
            padding: 0 .5rem 0 1.5rem;
            height: 4rem;
            color: #fff;
            font-size: 1.5rem;
            line-height: 4rem;
            background-color: #007fff
        }

        .header .close-btn[_v-8c48346e] {
            float: right;
            padding: 0 1rem;
            font-size: 2rem;
            color: #fff;
            cursor: pointer;
            opacity: .8
        }

        .header .close-btn[_v-8c48346e]:hover {
            transform: scale(1.1);
            opacity: 1
        }

        .body[_v-8c48346e] {
            position: relative;
            padding: 1.5rem;
            -ms-flex-direction: column;
            flex-direction: column;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .content[_v-8c48346e], .email[_v-8c48346e] {
            margin-bottom: 1.5rem;
            padding: .5em;
            width: 100%;
            max-width: 100%;
            font-size: 1.25rem;
            line-height: 1.5;
            border: 1px solid #e6edf4;
            border-radius: 2px;
            outline: 0
        }

        .content[disabled][_v-8c48346e], .email[disabled][_v-8c48346e] {
            background-color: #fff
        }

        .tag-box[_v-8c48346e] {
            margin-bottom: 1.5rem;
            width: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: row;
            flex-direction: row;
            -ms-flex-pack: justify;
            justify-content: space-between
        }

        .tag-box .tag[_v-8c48346e] {
            -ms-flex: 1 0 auto;
            flex: 1 0 auto;
            padding: .8rem 1.5rem;
            font-size: 1.25rem;
            text-align: center;
            color: #767e8d;
            border: 1px solid #e6edf4;
            border-radius: 2px;
            cursor: pointer
        }

        .tag-box .tag.active[_v-8c48346e] {
            color: #000;
            background-color: #f1f5fa;
            border-color: #007fff
        }

        .tag-box .tag[_v-8c48346e]:not(:last-child) {
            margin-right: .5em
        }

        .content[_v-8c48346e] {
            height: 12rem;
            overflow: hidden;
            resize: none
        }

        .ctrl[_v-8c48346e] {
            width: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: row;
            flex-direction: row;
            -ms-flex-pack: justify;
            justify-content: space-between
        }

        .btn[_v-8c48346e] {
            margin-top: 1rem;
            width: 48.5%;
            height: 3.5rem;
            font-size: 1.3rem;
            border-radius: 2px;
            outline: 0
        }

        .btn[disabled][_v-8c48346e] {
            color: #767e8d;
            background-color: #c2c5cd;
            border: 1px solid #c2c5cd
        }

        .cancel-btn[_v-8c48346e] {
            color: #000;
            background-color: #fff;
            border: 1px solid #e6edf4
        }

        .submit-btn[_v-8c48346e] {
            color: #fff;
            background-color: #007fff;
            border: 1px solid #007fff
        }

        .message-box[_v-8c48346e] {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: column;
            flex-direction: column
        }

        .message-box .message[_v-8c48346e] {
            font-size: 1.25rem;
            color: #333
        }</style>
    <style type="text/css">
        .modal[_v-0d7475de] {
            width: 50rem;
            min-width: 50rem;
            background-color: #fff;
            border-radius: 3px;
            overflow: hidden
        }

        .header[_v-0d7475de] {
            position: relative;
            padding: 0 .5rem 0 1.5rem;
            height: 4rem;
            color: #fff;
            font-size: 1.5rem;
            line-height: 4rem;
            background-color: #007fff
        }

        .header .close-btn[_v-0d7475de] {
            float: right;
            padding: 0 1rem;
            font-size: 2rem;
            color: #fff;
            cursor: pointer;
            opacity: .8
        }

        .header .close-btn[_v-0d7475de]:hover {
            transform: scale(1.1);
            opacity: 1
        }

        .body[_v-0d7475de] {
            position: relative;
            padding: 1.5rem;
            -ms-flex-direction: column;
            flex-direction: column;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .content[_v-0d7475de] {
            position: relative;
            width: 100%;
            height: 28rem;
            overflow: hidden
        }

        .item .question[_v-0d7475de] {
            display: -ms-flexbox;
            display: flex;
            margin: 1em 0 .5em;
            font-size: 1.3rem;
            line-height: 2;
            font-weight: 700
        }

        .item .question .icon[_v-0d7475de] {
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            margin: .5em 1em 0 0;
            width: 1em;
            height: 1em;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: cover;
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8IS0tIENyZWF0b3I6IENvcmVsRFJBVyBYNyAtLT4NCjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iOC4zODU3bW0iIGhlaWdodD0iOC4xOTIzbW0iIHZlcnNpb249IjEuMSIgc3R5bGU9InNoYXBlLXJlbmRlcmluZzpnZW9tZXRyaWNQcmVjaXNpb247IHRleHQtcmVuZGVyaW5nOmdlb21ldHJpY1ByZWNpc2lvbjsgaW1hZ2UtcmVuZGVyaW5nOm9wdGltaXplUXVhbGl0eTsgZmlsbC1ydWxlOmV2ZW5vZGQ7IGNsaXAtcnVsZTpldmVub2RkIg0Kdmlld0JveD0iMCAwIDUwOSA0OTciDQogeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPg0KIDxkZWZzPg0KICA8c3R5bGUgdHlwZT0idGV4dC9jc3MiPg0KICAgPCFbQ0RBVEFbDQogICAgLmZpbDAge2ZpbGw6IzAwNkNGRn0NCiAgICAuZmlsMSB7ZmlsbDp3aGl0ZX0NCiAgIF1dPg0KICA8L3N0eWxlPg0KIDwvZGVmcz4NCiA8ZyBpZD0i5Zu+5bGCX3gwMDIwXzEiPg0KICA8bWV0YWRhdGEgaWQ9IkNvcmVsQ29ycElEXzBDb3JlbC1MYXllciIvPg0KICA8cmVjdCBjbGFzcz0iZmlsMCIgd2lkdGg9IjUwOSIgaGVpZ2h0PSI0OTciLz4NCiAgPHBhdGggaWQ9IkZpbGwtMS1Db3B5IiBjbGFzcz0iZmlsMSIgZD0iTTI4NSAxMzhsLTMxIC0yNCAtMzMgMjUgLTIgMiAzNSAyNyAzNCAtMjcgLTMgLTN6bTExOSA5NWwtMTUwIDExNiAtMTUxIC0xMTYgLTIyIDE3IDE3MyAxMzQgMTczIC0xMzQgLTIzIC0xN3ptLTE1MCA5bC04MiAtNjMgLTIzIDE3IDEwNSA4MSAxMDQgLTgxIC0yMiAtMTcgLTgyIDYzeiIvPg0KIDwvZz4NCjwvc3ZnPg0K)
        }

        .item .question[_v-0d7475de]:first-child {
            margin-top: 0
        }

        .item .answer[_v-0d7475de] {
            padding: 0 0 1em 2.08em;
            font-size: 1.25rem;
            line-height: 2
        }

        .ctrl[_v-0d7475de] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: end;
            justify-content: flex-end;
            width: 100%
        }

        .ctrl .btn[_v-0d7475de] {
            margin-top: 1.5rem;
            margin-left: 1.5rem;
            width: 12rem;
            height: 3.5rem;
            font-size: 1.3rem;
            border-radius: 2px;
            outline: 0
        }

        .ctrl .btn[disabled][_v-0d7475de] {
            color: #c2c5cd;
            background-color: #fff
        }

        .ctrl .close-btn[_v-0d7475de] {
            color: #fff;
            background-color: #007fff;
            border: 1px solid #007fff
        }</style>
    <style type="text/css">
        .modal[_v-e056c89e] {
            width: 40rem;
            min-width: 40rem;
            background-color: #fff;
            border-radius: 3px;
            overflow: hidden
        }

        .header[_v-e056c89e] {
            position: relative;
            padding: 0 .5rem 0 1.5rem;
            height: 4rem;
            color: #fff;
            font-size: 1.5rem;
            line-height: 4rem;
            background-color: #007fff
        }

        .header .close-btn[_v-e056c89e] {
            float: right;
            padding: 0 1rem;
            font-size: 2rem;
            color: #fff;
            cursor: pointer;
            opacity: .8
        }

        .header .close-btn[_v-e056c89e]:hover {
            transform: scale(1.1);
            opacity: 1
        }

        .body[_v-e056c89e] {
            position: relative;
            padding: 1.5rem;
            -ms-flex-direction: column;
            flex-direction: column;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .title[_v-e056c89e] {
            width: 100%;
            margin-bottom: 1.5rem;
            padding: .834em;
            font-size: 1.5rem;
            font-weight: 700;
            color: #007fff;
            background-color: #fbfbfb
        }

        .title[_v-e056c89e]:before {
            content: "$ "
        }

        .title[_v-e056c89e]:after {
            content: " _";
            animation: cursor 1s infinite
        }

        @keyframes cursor {
            0% {
                opacity: 1
            }
            50% {
                opacity: 1
            }
            51% {
                opacity: 0
            }
            to {
                opacity: 0
            }
        }

        .content[_v-e056c89e] {
            position: relative;
            width: 100%;
            height: 30rem;
            overflow: hidden
        }

        .table[_v-e056c89e] {
            width: 100%;
            font-size: 1.25rem;
            line-height: 2.8;
            text-align: left;
            background-color: #fbfbfb
        }

        .table .head[_v-e056c89e] {
            padding: 0 1em
        }

        .table .name[_v-e056c89e] {
            width: 62%
        }

        .table .item[_v-e056c89e] {
            border-top: 1px solid #e6edf4
        }

        .table .item .license[_v-e056c89e], .table .item .name[_v-e056c89e] {
            padding: 0 1em;
            cursor: pointer
        }

        .table .item:hover .license[_v-e056c89e], .table .item:hover .name[_v-e056c89e] {
            color: #007fff
        }

        .ctrl[_v-e056c89e] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: end;
            justify-content: flex-end;
            width: 100%
        }

        .ctrl .btn[_v-e056c89e] {
            margin-top: 1.5rem;
            margin-left: 1.5rem;
            width: 12rem;
            height: 3.5rem;
            font-size: 1.3rem;
            border-radius: 2px;
            outline: 0
        }

        .ctrl .btn[disabled][_v-e056c89e] {
            color: #c2c5cd;
            background-color: #fff
        }

        .ctrl .close-btn[_v-e056c89e] {
            color: #fff;
            background-color: #007fff;
            border: 1px solid #007fff
        }</style>
    <style type="text/css">
        .navbar[_v-1d5c1ab1] {
            position: relative;
            padding: 0 2.5rem 0 1.8rem;
            height: 4.5rem;
            background-color: #fff;
            z-index: 500;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .navbar .logo[_v-1d5c1ab1] {
            display: block;
            width: 5rem;
            height: 3rem;
            cursor: pointer;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSI2NHB4IiBoZWlnaHQ9IjQwcHgiIHZpZXdCb3g9IjAgMCA2NCA0MCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjcuMSAoMjgyMTUpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT4wRTY2M0JBQi1CQ0IxLTQyNkItOUI1NC05MTlEQjk2NDkxRjQ8L3RpdGxlPg0KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBza2V0Y2h0b29sLjwvZGVzYz4NCiAgICA8ZGVmcz48L2RlZnM+DQogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+DQogICAgICAgIDxnIGlkPSJqdWVqaW5fY2hyb21lX2V4dGVuc2lvbl9kZXNpZ25lciIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTIyLjAwMDAwMCwgLTEyLjAwMDAwMCkiIGZpbGw9IiMwMDZDRkYiPg0KICAgICAgICAgICAgPGcgaWQ9Ikdyb3VwLTYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDIyLjAwMDAwMCwgMTIuMDAwMDAwKSI+DQogICAgICAgICAgICAgICAgPHBhdGggZD0iTTUyLjExMDc1NjksMzQgTDU1LjQwNzc4NDEsMzQgTDU1LjY5MTI4NDEsMzQgTDU1LjY5MTI4NDEsMzQuMjgzNSBMNTUuNjkxMjg0MSwzNS41Nzc1ODc3IEw1NS42OTEyODQxLDM1Ljg2MTA4NzcgTDU1LjQwNzc4NDEsMzUuODYxMDg3NyBMMzcuMjgzNSwzNS44NjEwODc3IEwzNywzNS44NjEwODc3IEwzNywzNS41Nzc1ODc3IEwzNywzNC4yODM1IEwzNywzNCBMMzcuMjgzNSwzNCBMNDAuMDAyMDczLDM0IEwzOC4wNDgxODYyLDIyLjU4NjQ4ODkgTDM4LDIyLjMwNTAxMjIgTDM4LjI4MTgyMDEsMjIuMjU4ODc2NSBMMzkuNTg1NDI0OCwyMi4wNDU0NjgzIEwzOS44NjMxNjgyLDIyIEwzOS45MTA2NjAzLDIyLjI3NzQwNDUgTDQxLjkxNzU4NzUsMzQgTDQ1LDM0IEw0NSwxOS44NjEwODc3IEwzNi4yODM1LDE5Ljg2MTA4NzcgTDM2LDE5Ljg2MTA4NzcgTDM2LDE5LjU3NzU4NzcgTDM2LDE4LjI4MzUgTDM2LDE4IEwzNi4yODM1LDE4IEw0NSwxOCBMNDUsMTEuODYxMDg3NyBMMzkuMjgzNSwxMS44NjEwODc3IEwzOSwxMS44NjEwODc3IEwzOSwxMS41Nzc1ODc3IEwzOSwxMC4yODM1IEwzOSwxMCBMMzkuMjgzNSwxMCBMNTIuODQzMTE5MiwxMCBMNTMuMTI2NjE5MiwxMCBMNTMuMTI2NjE5MiwxMC4yODM1IEw1My4xMjY2MTkyLDExLjU3NzU4NzcgTDUzLjEyNjYxOTIsMTEuODYxMDg3NyBMNTIuODQzMTE5MiwxMS44NjEwODc3IEw0Ni44ODg2MzA3LDExLjg2MTA4NzcgTDQ2Ljg4ODYzMDcsMTggTDU2LjY3NjU5NywxOCBMNTYuOTYwMDk3LDE4IEw1Ni45NjAwOTcsMTguMjgzNSBMNTYuOTYwMDk3LDE5LjU3NzU4NzcgTDU2Ljk2MDA5NywxOS44NjEwODc3IEw1Ni42NzY1OTcsMTkuODYxMDg3NyBMNDYuODg4NjMwNywxOS44NjEwODc3IEw0Ni44ODg2MzA3LDM0IEw1MC4xOTUyNjI2LDM0IEw1Mi4yMDE0MjI5LDIyLjI3NzQyNTEgTDUyLjI0ODkwMDUsMjIgTDUyLjUyNjY2MTQsMjIuMDQ1NDcxMiBMNTMuODMwMjY2MSwyMi4yNTg4NzkzIEw1NC4xMTIwNjg1LDIyLjMwNTAxMjEgTDU0LjA2MzkwMzEsMjIuNTg2NDc0MSBMNTIuMTEwNzU2OSwzNCBaIE0yNS42NDQ1OTMxLDMzLjM5NDAwMyBMMjUuNjQ0NTkzMSwyNC4yODMxODQ1IEwyOS45ODUyNDM2LDI0LjI4MzE4NDUgTDMwLjI2ODc0MzYsMjQuMjgzMTg0NSBMMzAuMjY4NzQzNiwyMy45OTk2ODQ1IEwzMC4yNjg3NDM2LDE0LjcyMzY1MDkgTDMwLjI2ODc0MzYsMTQuNDQwMTUwOSBMMjkuOTg1MjQzNiwxNC40NDAxNTA5IEwyOC42NjM2MTMsMTQuNDQwMTUwOSBMMjguMzgwMTEzLDE0LjQ0MDE1MDkgTDI4LjM4MDExMywxNC43MjM2NTA5IEwyOC4zODAxMTMsMjIuNDIyMDk2OCBMMjUuNjQ0NTkzMSwyMi40MjIwOTY4IEwyNS42NDQ1OTMxLDE0LjE0MzE5NjMgTDI1LjY0NDU5MzEsMTMuODU5Njk2MyBMMjUuMzYxMDkzMSwxMy44NTk2OTYzIEwyNC4wMzk0NjI0LDEzLjg1OTY5NjMgTDIzLjc1NTk2MjQsMTMuODU5Njk2MyBMMjMuNzU1OTYyNCwxNC4xNDMxOTYzIEwyMy43NTU5NjI0LDIyLjQyMjA5NjggTDIxLjA2MzIxMzMsMjIuNDIyMDk2OCBMMjEuMDYzMjEzMywxNC43MjM2NTA5IEwyMS4wNjMyMTMzLDE0LjQ0MDE1MDkgTDIwLjc3OTcxMzMsMTQuNDQwMTUwOSBMMTkuNDU3MjYzMiwxNC40NDAxNTA5IEwxOS4xNzM3NjMyLDE0LjQ0MDE1MDkgTDE5LjE3Mzc2MzIsMTQuNzIzNjUwOSBMMTkuMTczNzYzMiwyMy45OTk2ODQ1IEwxOS4xNzM3NjMyLDI0LjI4MzE4NDUgTDE5LjQ1NzI2MzIsMjQuMjgzMTg0NSBMMjMuNzU1OTYyNCwyNC4yODMxODQ1IEwyMy43NTU5NjI0LDMzLjM5NDAwMyBMMjEuMDYzMjEzMywzMy4zOTQwMDMgTDIxLjA2MzIxMzMsMjUuODE3NTA0NyBMMjEuMDYzMjEzMywyNS41MzQwMDQ3IEwyMC43Nzk3MTMzLDI1LjUzNDAwNDcgTDE5LjQ1NzI2MzIsMjUuNTM0MDA0NyBMMTkuMTczNzYzMiwyNS41MzQwMDQ3IEwxOS4xNzM3NjMyLDI1LjgxNzUwNDcgTDE5LjE3Mzc2MzIsMzQuOTcxNTkwNyBMMTkuMTczNzYzMiwzNS4yNTUwOTA3IEwxOS40NTcyNjMyLDM1LjI1NTA5MDcgTDI5Ljk4NTI0MzYsMzUuMjU1MDkwNyBMMzAuMjY4NzQzNiwzNS4yNTUwOTA3IEwzMC4yNjg3NDM2LDM0Ljk3MTU5MDcgTDMwLjI2ODc0MzYsMjUuODE3NTA0NyBMMzAuMjY4NzQzNiwyNS41MzQwMDQ3IEwyOS45ODUyNDM2LDI1LjUzNDAwNDcgTDI4LjY2MzYxMywyNS41MzQwMDQ3IEwyOC4zODAxMTMsMjUuNTM0MDA0NyBMMjguMzgwMTEzLDI1LjgxNzUwNDcgTDI4LjM4MDExMywzMy4zOTQwMDMgTDI1LjY0NDU5MzEsMzMuMzk0MDAzIFogTTkuODc1MDcxNDQsMjQuMjg0MzgxMSBMOC41Mzk1NTMzMywyNS41OTUwMzM3IEw4LjM0MTQ2NjYxLDI1Ljc4OTQzMjMgTDguMTQyOTA0NjUsMjUuNTk1NTE5MSBMNy4yMDcxOTM0MiwyNC42ODE3MTUxIEw3LDI0LjQ3OTM3MjYgTDcuMjA2NzExMDQsMjQuMjc2NTM3MyBMOS44NzUwNzE0NCwyMS42NTgyMDc1IEw5Ljg3NTA3MTQ0LDEwLjc5NjE5MTEgTDcuODI3NTY4OTIsMTAuNzk2MTkxMSBMNy41NDQwNjg5MiwxMC43OTYxOTExIEw3LjU0NDA2ODkyLDEwLjUxMjY5MTEgTDcuNTQ0MDY4OTIsOS4yMTg2MDMzOSBMNy41NDQwNjg5Miw4LjkzNTEwMzM5IEw3LjgyNzU2ODkyLDguOTM1MTAzMzkgTDkuODc1MDcxNDQsOC45MzUxMDMzOSBMOS44NzUwNzE0NCw0LjI4Mzc0MDY5IEw5Ljg3NTA3MTQ0LDQuMDAwMjQwNjkgTDEwLjE1ODU3MTQsNC4wMDAyNDA2OSBMMTEuNDgxMDIxNSw0LjAwMDI0MDY5IEwxMS43NjQ1MjE1LDQuMDAwMjQwNjkgTDExLjc2NDUyMTUsNC4yODM3NDA2OSBMMTEuNzY0NTIxNSw4LjkzNTEwMzM5IEwxNC4yMDcxMjAzLDguOTM1MTAzMzkgTDE0LjQ5MDYyMDMsOC45MzUxMDMzOSBMMTQuNDkwNjIwMyw5LjIxODYwMzM5IEwxNC40OTA2MjAzLDEwLjUxMjY5MTEgTDE0LjQ5MDYyMDMsMTAuNzk2MTkxMSBMMTQuMjA3MTIwMywxMC43OTYxOTExIEwxMS43NjQ1MjE1LDEwLjc5NjE5MTEgTDExLjc2NDUyMTUsMTkuODA0MTgzOSBMMTMuMzQ3MDA4NywxOC4yNTEzNjc2IEwxMy41NDUxODIsMTguMDU2OTEgTDEzLjc0MzczMjcsMTguMjUwOTgyMSBMMTQuNjc4NjI0NiwxOS4xNjQ3ODYxIEwxNC44ODU2MjQ5LDE5LjM2NzExNzIgTDE0LjY3OTAzMTcsMTkuNTY5ODY0IEwxMS43NjQ1MjE1LDIyLjQzMDExIEwxMS43NjQ1MjE1LDI2LjQ1MDkwOTcgQzExLjc2NDUyMTUsMjguNTAzMzkxNyAxMS40NDYwNjA5LDMwLjQ2OTA5MzkgMTAuOTEyMjQ0NiwzMi4yODQ5NjQ4IEMxMC41ODQ2Mjk4LDMzLjM5OTQwNDUgMTAuMjU3MzAzLDM0LjIxMDgwMTkgMTAuMDAxMDk5NiwzNC43MzMxNzk5IEw5LjcxMTg2NDgzLDM1LjMxNDgzNzQgTDkuNTg3ODE1NTEsMzUuNTY0MzAzMyBMOS4zMzYyMjc2LDM1LjQ0NDYxNjIgTDguMTQ4OTcyMjgsMzQuODc5ODA2NiBMNy44ODkzNTEzMywzNC43NTYyOTc5IEw4LjAxNjQ4NzAzLDM0LjQ5ODQzMzcgTDguMzAzNzg0NTQsMzMuOTE1NzI1MiBDOC4zNDUxMDU4NywzMy44MzI3ODE4IDguNDQwMTIxMDMsMzMuNjE5ODE1MyA4LjU1MTM4MDQsMzMuMzQxNTkzMSBDOC43MzU5Mjc1LDMyLjg4MDEwMjkgOC45MjAzMDkzNSwzMi4zNTIyNTk5IDkuMDkyMTg0MDksMzEuNzY2OTE0MiBDOS41ODE3MzE0NywzMC4wOTk2ODU3IDkuODc1MDcxNDQsMjguMzA0NTkyNyA5Ljg3NTA3MTQ0LDI2LjQ1MDkwOTcgTDkuODc1MDcxNDQsMjQuMjg0MzgxMSBaIE0xNS45MTg5ODY4LDM1LjQyMDIwNjcgTDE1Ljk3NTkxNDYsMzUuMTQ0NjM1IEwxNi4xMDcwMTI1LDM0LjUxMDAyNjYgQzE2Ljg5NTIyODksMzAuNjk3MzE2OCAxNy4xOTA4NzY0LDIyLjQxOTQ1NTggMTcuMTU2NzQwMiwxMi4zMzg3NDY5IEwzMC43OTc0Nzc4LDEyLjMzODc0NjkgTDMwLjc5NzQ3NzgsNCBMMTUuNDU2NTY1Miw0IEwxNS4xNjY2Njk4LDQgTDE1LjE3MzEzNTcsNC4yODk4MjMyIEwxNS4xODc4ODQyLDQuOTUwOTA3MDYgQzE1LjIwMTc3NTcsNS41ODExMzMyMSAxNS4yMjQzOTA3LDYuOTc3NTIzNjQgMTUuMjQxMTUwMyw4LjY1NTUzMjE2IEMxNS4yNjg3NTE1LDExLjQxOTAwODYgMTUuMjc0MTE2MywxNC4yODMxNzAzIDE1LjI0ODE1MTIsMTcuMTAwNjE5NCBDMTUuMTc0MzYxMiwyNS4xMDc1MTA1IDE0Ljg2NjI2MzQsMzEuMTg1NzExMiAxNC4yNTU1MjA2LDM0LjEzODUxODIgTDE0LjEyNTE3MTUsMzQuNzcyNjY2NiBMMTQuMDY3NzIwNSwzNS4wNTIxNjYyIEwxNC4zNDc1ODY1LDM1LjEwNzgwNDkgTDE1LjY0Mjk5NzYsMzUuMzY1MzM4OCBMMTUuOTE4OTg2OCwzNS40MjAyMDY3IFogTTE3LjE1MTAwMDcsMTAuNDc3NjU5MiBMMTcuMDg5NTA3Nyw1Ljg2MTA4NzcyIEwyOC45MDg4NDcyLDUuODYxMDg3NzIgTDI4LjkwODg0NzIsMTAuNDc3NjU5MiBMMTcuMTUxMDAwNywxMC40Nzc2NTkyIFogTTU2LjM2MTIyNzMsMTIuNDE4ODgwMSBMNTYuNTUxODA5NiwxMi4yMTY5MzE3IEw1Ny40NDkwMTA4LDExLjI2NjIyMjUgTDU3LjY0NzY5MTYsMTEuMDU1NjkyNyBMNTcuNDMzMDYzMSwxMC44NjE0NDY5IEw0OS45MzI2MjQ3LDQuMDczMzAyOTUgTDQ5Ljc0MjM4OTUsNCBMNDEuOTA0Mzc0LDQgTDQxLjcxNDEyNzQsNC4wNzMzMTMyOSBMMzQuMjE0NTA4NCwxMC44NjE0NTcyIEwzNCwxMS4wNTU2MTU2IEwzNC4xOTg0ODMzLDExLjI2NjEyODUgTDM1LjA5NDg2NTIsMTIuMjE2ODM3NyBMMzUuMjg1NDMxNCwxMi40MTg5NTM2IEwzNS40OTEzODM1LDEyLjIzMjUzOTkgTDQyLjYxMTYzOCw1Ljg2MTA4NzcyIEw0OS4wMzU5MzI5LDUuODYxMDg3NzIgTDU2LjE1NTM2OCwxMi4yMzI1MjkgTDU2LjM2MTIyNzMsMTIuNDE4ODgwMSBaIiBpZD0iQ29tYmluZWQtU2hhcGUiPjwvcGF0aD4NCiAgICAgICAgICAgIDwvZz4NCiAgICAgICAgPC9nPg0KICAgIDwvZz4NCjwvc3ZnPg==)
        }

        .navbar .slogan-bar[_v-1d5c1ab1] {
            -ms-flex: 1 0 auto;
            flex: 1 0 auto;
            margin: 0 0 0 1rem;
            height: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .navbar .slogan-bar .slogan[_v-1d5c1ab1] {
            display: inline-block;
            width: 15rem;
            height: 1.5rem;
            cursor: pointer;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIxNzBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMTcwIDIwIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPg0KICAgIDwhLS0gR2VuZXJhdG9yOiBza2V0Y2h0b29sIDMuNy4xICgyODIxNSkgLSBodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2ggLS0+DQogICAgPHRpdGxlPjU5QzE2ODNCLTJCOTItNDFBQi1BMENFLUQyQkJFODlCMDgwMzwvdGl0bGU+DQogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIHNrZXRjaHRvb2wuPC9kZXNjPg0KICAgIDxkZWZzPjwvZGVmcz4NCiAgICA8ZyBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIiBmb250LXdlaWdodD0ibm9ybWFsIiBmb250LWZhbWlseT0iQXJpYWxOYXJyb3csIEFyaWFsIE5hcnJvdyIgbGV0dGVyLXNwYWNpbmc9Ii0wLjMxMzUyOTM3MiIgZm9udC1zaXplPSIxMyI+DQogICAgICAgIDxnIGlkPSJqdWVqaW5fY2hyb21lX2V4dGVuc2lvbl9kZXNpZ25lciIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTk2LjAwMDAwMCwgLTIyLjAwMDAwMCkiIGZpbGw9IiMwMDZDRkYiPg0KICAgICAgICAgICAgPGcgaWQ9Ikdyb3VwLTciIHRyYW5zZm9ybT0idHJhbnNsYXRlKDk2LjAwMDAwMCwgMjIuMDAwMDAwKSI+DQogICAgICAgICAgICAgICAgPHRleHQgaWQ9IlRFQ0gtwrctREVTSUdOLcK3LVBST0QiPg0KICAgICAgICAgICAgICAgICAgICA8dHNwYW4geD0iNSIgeT0iMTUiPlRFQ0ggwrcgREVTSUdOIMK3IFBST0RVQ1Q8L3RzcGFuPg0KICAgICAgICAgICAgICAgIDwvdGV4dD4NCiAgICAgICAgICAgIDwvZz4NCiAgICAgICAgPC9nPg0KICAgIDwvZz4NCjwvc3ZnPg==);
            background-position: 0
        }

        .navbar .slogan-bar .banner[_v-1d5c1ab1] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            position: relative;
            padding: .8rem 2.5rem;
            background-color: #47c459;
            border-radius: 2px;
            cursor: pointer
        }

        .navbar .slogan-bar .banner[_v-1d5c1ab1]:hover {
            background-color: #47d459
        }

        .navbar .slogan-bar .banner[_v-1d5c1ab1]:before {
            content: attr(text);
            display: block;
            font-size: 1.2rem;
            color: #fff
        }

        .navbar .slogan-bar .banner .close[_v-1d5c1ab1] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 2px;
            width: 11px;
            height: 11px;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWBAMAAAA2mnEIAAAAD1BMVEUAAAD///////////////+PQt5oAAAABHRSTlMA1BVYaxbEpAAAAD5JREFUGNNjoBAYAbEyhMnsqMDAJGIAYgJpIQZFIB8EgAwlIJcBKiEIEoZKuECFEWyEGnS9CDMRdiG7gTIAAGw/BqX4+epIAAAAAElFTkSuQmCC);
            opacity: .8
        }

        .navbar .slogan-bar .banner .close[_v-1d5c1ab1]:hover {
            transform: scale(1.3);
            transition: .15s;
            opacity: 1
        }</style>
    <style type="text/css">
        .channel-seletor[_v-208eeacb] {
            position: relative;
            margin: 0 2rem 0 0;
            height: 100%;
            font-size: 1.25rem;
            color: #767e8d;
            cursor: pointer;
            opacity: .8
        }

        .channel-seletor .curr[_v-208eeacb] {
            height: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: row;
            flex-direction: row;
            -ms-flex-pack: end;
            justify-content: flex-end
        }

        .channel-seletor.active[_v-208eeacb] {
            opacity: 1
        }

        .channel-seletor.active .arrow[_v-208eeacb] {
            transform: rotate(180deg)
        }

        .channel-seletor.active .channel-list[_v-208eeacb] {
            display: block
        }

        .channel-seletor[_v-208eeacb]:hover {
            opacity: 1
        }

        .channel-seletor .icon[_v-208eeacb] {
            margin-left: 1rem;
            width: 2.25rem;
            height: 2.25rem
        }

        .channel-seletor .title[_v-208eeacb] {
            margin: 0 1rem
        }

        .channel-seletor .arrow[_v-208eeacb] {
            width: 1.5rem;
            height: 1.5rem;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIxOHB4IiBoZWlnaHQ9IjE4cHgiIHZpZXdCb3g9IjAgMCAxOCAxOCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5hcnJvdzwvdGl0bGU+DQogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIHNrZXRjaHRvb2wuPC9kZXNjPg0KICAgIDxkZWZzPjwvZGVmcz4NCiAgICA8ZyBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4NCiAgICAgICAgPGcgaWQ9Imp1ZWppbl9jaHJvbWVfZXh0ZW5zaW9uX2Rlc2lnbmVyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTg5LjAwMDAwMCwgLTEwMi4wMDAwMDApIiBmaWxsPSIjQTlCM0M3Ij4NCiAgICAgICAgICAgIDxnIGlkPSJHcm91cC00IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMjMuMDAwMDAwLCA5OC4wMDAwMDApIj4NCiAgICAgICAgICAgICAgICA8ZyBpZD0iR3JvdXAtOCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjYuMDAwMDAwLCA0LjAwMDAwMCkiPg0KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNSw3IEwxMyw3IEw5LDExIEw1LDcgWiIgaWQ9IlJlY3RhbmdsZS0yMyI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDwvZz4NCiAgICAgICAgICAgIDwvZz4NCiAgICAgICAgPC9nPg0KICAgIDwvZz4NCjwvc3ZnPg==)
        }

        .channel-list[_v-208eeacb] {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            border-top: 1px solid rgba(0, 0, 0, .1);
            border-radius: 2px;
            box-shadow: 0 1px 2px 0 rgba(34, 42, 48, .1);
            overflow: hidden;
            display: none
        }

        .channel-list .item[_v-208eeacb] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            height: 4rem;
            width: 16rem
        }

        .channel-list .item .icon[_v-208eeacb] {
            margin: 0 1rem
        }

        .channel-list .item .title[_v-208eeacb] {
            margin: 0
        }

        .channel-list .item.active[_v-208eeacb] {
            color: #000;
            background-color: #fbfbfb
        }

        .channel-list .item[_v-208eeacb]:hover {
            color: #fff;
            background-color: #007fff
        }</style>
    <style type="text/css">
        .download-button[_v-77db9aaa] {
            position: relative;
            -ms-flex: 0 0 1.66667rem;
            flex: 0 0 1.66667rem;
            margin: 0 2.2rem 0 0;
            height: 100%;
            cursor: pointer;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: row;
            flex-direction: row
        }

        .download-button.active .title[_v-77db9aaa] {
            opacity: 1
        }

        .download-button.active .panel[_v-77db9aaa] {
            display: block
        }

        .download-button:hover .title[_v-77db9aaa] {
            opacity: 1
        }

        .download-button .title[_v-77db9aaa] {
            position: relative;
            padding-left: 1.4rem;
            opacity: .8;
            font-size: 1.25rem;
            color: #007fff;
            white-space: nowrap
        }

        .download-button .title[_v-77db9aaa]:before {
            content: "";
            position: absolute;
            margin: -11px .5rem 0 0;
            top: 50%;
            left: 0;
            width: 1rem;
            height: 1.83333rem;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMyIgaGVpZ2h0PSIyMiIgdmlld0JveD0iMCAwIDEzIDIyIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHJlY3Qgd2lkdGg9IjEzIiBoZWlnaHQ9IjIyIiBmaWxsPSIjMDA3RkZGIiByeD0iMiIvPgogICAgICAgIDxjaXJjbGUgY3g9IjQuNSIgY3k9IjEuNSIgcj0iMSIgZmlsbD0iI0ZGRiIvPgogICAgICAgIDxjaXJjbGUgY3g9IjYuNSIgY3k9IjIwIiByPSIxIiBmaWxsPSIjRkZGIi8+CiAgICAgICAgPHJlY3Qgd2lkdGg9IjMiIGhlaWdodD0iMSIgeD0iNiIgeT0iMSIgZmlsbD0iI0ZGRiIgcng9Ii41Ii8+CiAgICAgICAgPHBhdGggZmlsbD0iI0ZGRiIgZD0iTTEgM2gxMXYxNUgxeiIvPgogICAgICAgIDxyZWN0IHdpZHRoPSI2IiBoZWlnaHQ9IjEiIHg9IjMuNSIgeT0iOS41IiBmaWxsPSIjMDA3RkZGIiByeD0iLjUiIHRyYW5zZm9ybT0icm90YXRlKDkwIDYuNSAxMCkiLz4KICAgICAgICA8cmVjdCB3aWR0aD0iNiIgaGVpZ2h0PSIxIiB4PSIzLjUiIHk9IjEzIiBmaWxsPSIjMDA3RkZGIiByeD0iLjUiIHRyYW5zZm9ybT0icm90YXRlKC0xODAgNi41IDEzLjUpIi8+CiAgICAgICAgPHJlY3Qgd2lkdGg9IjQiIGhlaWdodD0iMSIgeD0iMy40MTUiIHk9IjEwLjkwOCIgZmlsbD0iIzAwN0ZGRiIgcng9Ii41IiB0cmFuc2Zvcm09InJvdGF0ZSg0NSA1LjQxNSAxMS40MDgpIi8+CiAgICAgICAgPHJlY3Qgd2lkdGg9IjQiIGhlaWdodD0iMSIgeD0iNS42NjQiIHk9IjEwLjg1OSIgZmlsbD0iIzAwN0ZGRiIgcng9Ii41IiB0cmFuc2Zvcm09InJvdGF0ZSgxMzUgNy42NjQgMTEuMzU5KSIvPgogICAgPC9nPgo8L3N2Zz4K)
        }

        .download-button .panel[_v-77db9aaa] {
            position: absolute;
            top: 100%;
            left: 50%;
            margin-top: 11px;
            margin-left: -5rem;
            padding: 1.66667rem .83333rem;
            text-align: center;
            background-color: rgba(0, 0, 0, .8);
            border-radius: 4px;
            cursor: default;
            display: none
        }

        .download-button .panel[_v-77db9aaa]:before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 100%;
            border: .7rem solid transparent;
            border-bottom-color: rgba(0, 0, 0, .8);
            transform: translate(-50%)
        }

        .download-button .panel .qrcode[_v-77db9aaa] {
            margin: 0 auto;
            width: 8.33333rem
        }</style>
    <style type="text/css">
        .book-banner[_v-dc0f286a] {
            position: relative;
            -ms-flex: 0 0 1.66667rem;
            flex: 0 0 1.66667rem;
            margin: 0 2.2rem 0 0;
            height: 100%;
            cursor: pointer;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: row;
            flex-direction: row
        }

        .book-banner:hover .panel[_v-dc0f286a] {
            display: block
        }

        .book-banner:hover .title[_v-dc0f286a] {
            opacity: 1
        }

        .book-banner .title[_v-dc0f286a] {
            position: relative;
            padding-left: 20px;
            opacity: .8;
            font-size: 1.25rem;
            color: #007fff;
            white-space: nowrap
        }

        .book-banner .title[_v-dc0f286a]:before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            margin-top: -11px;
            width: 16px;
            height: 22px;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIyMSIgdmlld0JveD0iMCAwIDE2IDIxIj4NCiAgICA8ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPg0KICAgICAgICA8cGF0aCBmaWxsPSIjMDI3RUZGIiBkPSJNMiAxaDEyYTEgMSAwIDAgMSAxIDF2MTdhMSAxIDAgMCAxLTEgMUgyYTEgMSAwIDAgMS0xLTFWMmExIDEgMCAwIDEgMS0xeiIvPg0KICAgICAgICA8cGF0aCBmaWxsPSIjRkZGIiBkPSJNOC44NCAxdjdsMi4wMjYtMS41NDVMMTIuODkgOFYxeiIvPg0KICAgIDwvZz4NCjwvc3ZnPg0K)
        }

        .book-banner .panel[_v-dc0f286a] {
            position: absolute;
            top: 100%;
            left: -30px;
            padding-top: 11px;
            width: 450px;
            display: none
        }

        .book-banner .panel .panner--inner[_v-dc0f286a] {
            background-color: #fff;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .19);
            padding: 13px;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: center;
            justify-content: center;
            position: relative
        }

        .book-banner .panel .panner--inner[_v-dc0f286a]:before {
            content: "";
            display: block;
            position: absolute;
            top: 0;
            left: 80px;
            width: 1rem;
            height: 1rem;
            transform: translate(-50%, -50%) rotate(45deg);
            background: #fff;
            border-top: 1px solid #f4f5f5;
            border-left: 1px solid #f4f5f5
        }

        .book-banner .panel .poster[_v-dc0f286a] {
            display: block;
            height: 125px
        }

        .book-banner .panel .poster .img[_v-dc0f286a] {
            max-width: 89px;
            max-height: 100%;
            display: block;
            box-shadow: 5px 2px 9px 0 rgba(30, 30, 30, .1)
        }

        .book-banner .panel .info[_v-dc0f286a] {
            overflow: hidden;
            margin-left: 14px
        }

        .book-banner .panel .info > .name[_v-dc0f286a] {
            font-size: 16px;
            line-height: 22px
        }

        .book-banner .panel .info > .name .title-link[_v-dc0f286a] {
            display: inline;
            font-weight: 700;
            color: #000
        }

        .book-banner .panel .info > .name .new[_v-dc0f286a] {
            display: inline-block;
            vertical-align: middle;
            padding-left: 3px;
            padding-right: 3px;
            height: 16px;
            margin-top: -3px;
            line-height: 16px;
            color: #fff;
            font-size: 12px;
            cursor: default;
            margin-right: 8px;
            border-radius: 2px;
            background-color: #fc4544
        }

        .book-banner .panel .info > .name .new span[_v-dc0f286a] {
            transform: scale(.8);
            display: block
        }

        .book-banner .panel .info .desc[_v-dc0f286a] {
            display: block;
            margin-top: 5px;
            height: 18px;
            line-height: 18px;
            color: #71777b;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .book-banner .panel .info .author[_v-dc0f286a] {
            margin-top: 5px;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .book-banner .panel .info .author .user-info[_v-dc0f286a] {
            -ms-flex-negative: 0;
            flex-shrink: 0;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -ms-flex-align: center;
            align-items: center
        }

        .book-banner .panel .info .author .user-info .avater[_v-dc0f286a] {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-repeat: no-repeat;
            background-position: 50%;
            overflow: hidden;
            margin-right: 10px
        }

        .book-banner .panel .info .author .user-desc[_v-dc0f286a] {
            margin-left: 10px;
            color: #71777b;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .book-banner .panel .info .other[_v-dc0f286a] {
            margin-top: 5px;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            color: #a9adb0
        }

        .book-banner .panel .info .other .price[_v-dc0f286a] {
            color: #ed7b11;
            margin-right: 8px;
            font-size: 16px
        }

        .book-banner .panel .info .other .bought[_v-dc0f286a]:before {
            content: "\B7";
            margin-left: 5px;
            margin-right: 5px
        }

        .book-banner .panel .info .consume[_v-dc0f286a] {
            margin-top: 6px
        }

        .book-banner .panel .info .consume .btn[_v-dc0f286a] {
            cursor: pointer;
            display: inline-block;
            padding: 6px 20px;
            line-height: 1;
            margin-right: 5px
        }

        .book-banner .panel .info .consume .btn-buy[_v-dc0f286a] {
            background-color: #007fff;
            border-radius: 2px;
            border: 1px solid #007fff;
            color: #fff
        }

        .book-banner .panel .info .consume .btn-read[_v-dc0f286a] {
            color: #71777b;
            border: 1px solid #ccc;
            border-radius: 2px;
            background-color: #fff
        }</style>
    <style type="text/css">
        .app-menu[_v-710e44f3] {
            position: relative;
            height: 100%;
            font-size: 1.25rem;
            color: #767e8d;
            cursor: pointer;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: row;
            flex-direction: row
        }

        .app-menu.active .icon[_v-710e44f3], .app-menu:hover .icon[_v-710e44f3] {
            opacity: 1
        }

        .app-menu.active .item-list[_v-710e44f3] {
            display: block
        }

        .app-menu .icon[_v-710e44f3] {
            width: 1.66667rem;
            height: 1.66667rem;
            opacity: .8;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIxOHB4IiBoZWlnaHQ9IjRweCIgdmlld0JveD0iMCAwIDE4IDQiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+DQogICAgPCEtLSBHZW5lcmF0b3I6IFNrZXRjaCAzLjcuMiAoMjgyNzYpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5Hcm91cCA1PC90aXRsZT4NCiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCiAgICA8ZGVmcz48L2RlZnM+DQogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+DQogICAgICAgIDxnIGlkPSJqdWVqaW5fY2hyb21lX2V4dGVuc2lvbl9pb3MiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMzkzLjAwMDAwMCwgLTMwLjAwMDAwMCkiIGZpbGw9IiNCQ0MyQ0QiPg0KICAgICAgICAgICAgPGcgaWQ9Ikdyb3VwLTUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEzODYuMDAwMDAwLCAxNy4wMDAwMDApIj4NCiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNOSwxNyBDMTAuMTA0NTY5NSwxNyAxMSwxNi4xMDQ1Njk1IDExLDE1IEMxMSwxMy44OTU0MzA1IDEwLjEwNDU2OTUsMTMgOSwxMyBDNy44OTU0MzA1LDEzIDcsMTMuODk1NDMwNSA3LDE1IEM3LDE2LjEwNDU2OTUgNy44OTU0MzA1LDE3IDksMTcgWiBNMTYsMTcgQzE3LjEwNDU2OTUsMTcgMTgsMTYuMTA0NTY5NSAxOCwxNSBDMTgsMTMuODk1NDMwNSAxNy4xMDQ1Njk1LDEzIDE2LDEzIEMxNC44OTU0MzA1LDEzIDE0LDEzLjg5NTQzMDUgMTQsMTUgQzE0LDE2LjEwNDU2OTUgMTQuODk1NDMwNSwxNyAxNiwxNyBaIE0yMywxNyBDMjQuMTA0NTY5NSwxNyAyNSwxNi4xMDQ1Njk1IDI1LDE1IEMyNSwxMy44OTU0MzA1IDI0LjEwNDU2OTUsMTMgMjMsMTMgQzIxLjg5NTQzMDUsMTMgMjEsMTMuODk1NDMwNSAyMSwxNSBDMjEsMTYuMTA0NTY5NSAyMS44OTU0MzA1LDE3IDIzLDE3IFoiIGlkPSJDb21iaW5lZC1TaGFwZSI+PC9wYXRoPg0KICAgICAgICAgICAgPC9nPg0KICAgICAgICA8L2c+DQogICAgPC9nPg0KPC9zdmc+)
        }

        .item-list[_v-710e44f3] {
            position: absolute;
            top: 100%;
            right: -2.2rem;
            background-color: #fff;
            border-top: 1px solid rgba(0, 0, 0, .1);
            border-radius: 2px;
            box-shadow: 0 1px 2px 0 rgba(34, 42, 48, .1);
            overflow: hidden;
            display: none
        }

        .item-list .item[_v-710e44f3] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 0 1.5rem;
            height: 4rem;
            width: 18rem
        }

        .item-list .item.active[_v-710e44f3], .item-list .item[_v-710e44f3]:hover:not(.share):not(.divider):not(.section) {
            color: #000;
            background-color: #fbfbfb
        }

        .item-list .item.divider[_v-710e44f3] {
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, .05)
        }

        .item-list .item.section[_v-710e44f3] {
            display: block;
            height: 3rem;
            line-height: 3rem;
            font-size: 1rem;
            color: #c2c5cd;
            cursor: default
        }

        .item-list .item.share[_v-710e44f3] {
            padding: 0
        }

        .item-list .item.share[_v-710e44f3], .switch[_v-710e44f3] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .switch[_v-710e44f3] {
            position: relative;
            margin: 0 .2em;
            width: 2em;
            height: .9em;
            background-color: #e6edf4;
            border-radius: .5em/.5em
        }

        .switch[_v-710e44f3]:before {
            content: "";
            position: absolute;
            left: -.2em;
            width: 1.2em;
            height: 1.2em;
            border-radius: 50%;
            background-color: #c2c5cd
        }

        .switch.on[_v-710e44f3] {
            background-color: rgba(0, 127, 255, .3)
        }

        .switch.on[_v-710e44f3]:before {
            left: auto;
            right: -.2em;
            background-color: #39f
        }

        .share-icon[_v-710e44f3] {
            -ms-flex: 1 0 auto;
            flex: 1 0 auto;
            height: 100%;
            background-position: 50%;
            background-size: 1.5em 1.5em;
            background-repeat: no-repeat
        }

        .share-icon[_v-710e44f3]:hover {
            background-color: #fbfbfb
        }

        .share-icon.weibo[_v-710e44f3] {
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIzMnB4IiBoZWlnaHQ9IjMycHgiIHZpZXdCb3g9IjAgMCAzMiAzMiIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDMuNy4yICgyODI3NikgLSBodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2ggLS0+DQogICAgPHRpdGxlPmV4dGVuc2lvbl93ZWlibzwvdGl0bGU+DQogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIFNrZXRjaC48L2Rlc2M+DQogICAgPGRlZnM+PC9kZWZzPg0KICAgIDxnIGlkPSJ2NCIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+DQogICAgICAgIDxnIGlkPSJleHRlbnNpb24iIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0yNC4wMDAwMDAsIC0xNS4wMDAwMDApIiBmaWxsPSIjRDUyQjJBIj4NCiAgICAgICAgICAgIDxnIGlkPSJHcm91cC0yIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyNi4wMDAwMDAsIDIwLjAwMDAwMCkiPg0KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMC4yODU0NjM5LDEwLjUzNTI1MTcgQzE5LjkwNTg1NTgsMTAuNDIxNDkzMyAxOS42NDU1MDQ3LDEwLjM0NDI0NTcgMTkuODQ0NTc2OCw5Ljg0NjE5MzE3IEMyMC4yNzQ5Njg3LDguNzY0ODExNTMgMjAuMzE5NjU4Myw3LjgzMTgzOTkyIDE5Ljg1MjcwMjIsNy4xNjY0NDU4MSBDMTguOTc3NTI5OCw1LjkxNzgwNzEgMTYuNTgzMTYzLDUuOTg1NDE5ODcgMTMuODM4NjQyNiw3LjEzMjgwODQ2IEMxMy44Mzg2NDI2LDcuMTMxMjg3MTcgMTIuOTc2ODQzMyw3LjUwOTMyNzA0IDEzLjE5Njk5MDYsNi44MjY2MDcxNiBDMTMuNjE5MzQxNyw1LjQ3MTU2Mjg3IDEzLjU1NTc3NzQsNC4zMzYxNzU1NCAxMi44OTg3MjEsMy42ODEwMDc4NiBDMTEuNDA5NDg5LDIuMTkzMTA0NDkgNy40NDk4ODQwMSwzLjczNzEyNjQ2IDQuMDU0NDAxMjUsNy4xMjY3MjMzMSBDMS41MTE0OTIxNiw5LjY2NjQyNzczIDAuMDM0OTU2MTEyOSwxMi4zNTc2NjkzIDAuMDM0OTU2MTEyOSwxNC42ODQ5MDA2IEMwLjAzNDk1NjExMjksMTkuMTM2MzU1OSA1Ljc1MTY3NzEyLDIxLjg0MjcyNTggMTEuMzQ0MzE2NiwyMS44NDI3MjU4IEMxOC42NzYwNDM5LDIxLjg0MjcyNTggMjMuNTUyOTcxOCwxNy41ODkyMDY4IDIzLjU1Mjk3MTgsMTQuMjEyMjAyOCBDMjMuNTUyOTcxOCwxMi4xNzE5MDMyIDIxLjgzMTkxMjIsMTEuMDEzOTUwMSAyMC4yODU0NjM5LDEwLjUzNTI1MTcgTDIwLjI4NTQ2MzksMTAuNTM1MjUxNyBaIE0xMS4zNTkzODI0LDIwLjI0NzIzMzYgQzYuODk2NTk1NjEsMjAuNjg3MDU0NiAzLjA0NDMxMzQ4LDE4LjY3MjcwMTMgMi43NTQ0MjMyLDE1Ljc0Njc1OSBDMi40NjQ1MzI5MiwxMi44MjE2NjE4IDUuODQ4NTA0NywxMC4wOTM0MDIzIDEwLjMxMDY5OTEsOS42NTI3MzYxNSBDMTQuNzczOTA5MSw5LjIxMjE1NDQ4IDE4LjYyNjQ0NTEsMTEuMjI2NTA3NyAxOC45MTU3NDI5LDE0LjE1MTA5NzggQzE5LjIwNTEyNTQsMTcuMDc3ODAwOCAxNS44MjI2NzcxLDE5LjgwNjM5ODQgMTEuMzU5MzgyNCwyMC4yNDcyMzM2IEwxMS4zNTkzODI0LDIwLjI0NzIzMzYgWiIgaWQ9IkZpbGwtMSI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0yNS4xNTQxODE4LDIuMzg4OTI3OTYgQzIzLjM4MzYwODIsMC40Mjg4MzM5NTEgMjAuNzcyMDU2NCwtMC4zMTg0NTYxMTUgMTguMzYxNjA4MiwwLjE5MzM3MjUwMyBMMTguMzYwNTkyNSwwLjE5MzM3MjUwMyBDMTcuODAyNzMzNSwwLjMxMjUzOTk5OCAxNy40NDcxNjMsMC44NjA1NDE0NDQgMTcuNTY2NTg5MywxLjQxNjQwMjg3IEMxNy42ODU1MDc4LDEuOTcyODU1OTIgMTguMjM0MDU2NCwyLjMyODQxNDUzIDE4Ljc5MTkxNTQsMi4yMDk2Njk2MiBDMjAuNTA2NzExNiwxLjg0NTk5NzQ3IDIyLjM2MjYwMTksMi4zNzc4NTYzNyAyMy42MjExOTEyLDMuNzcwMjU2NzEgQzI0Ljg3ODY4MDMsNS4xNjI1NzI1NCAyNS4yMjAyMDA2LDcuMDYxNjQ2MDMgMjQuNjgxNjM5NSw4LjcyNjQ0MTI5IEwyNC42ODE4OTM0LDguNzI2Nzc5MzUgQzI0LjUwNjQzNTcsOS4yNjkwMzM3MiAyNC44MDM1MjA0LDkuODQ5MjM1NzQgMjUuMzQ3MjQ0NSwxMC4wMjQ0MzczIEMyNS44ODg3NjgsMTAuMTk5NjM4OSAyNi40NzEwMDMxLDkuOTAzMzI1OTUgMjYuNjQ2NzE0Nyw5LjM2MjMzOTMzIEMyNi42NDY3MTQ3LDkuMzYxMzI1MTQgMjYuNjQ2NzE0Nyw5LjM1OTI5Njc1IDI2LjY0NzA1MzMsOS4zNTgzNjcwOCBDMjcuNDAyNjMwMSw3LjAxNjU5OTAyIDI2LjkyNTI2MzMsNC4zNDcxNjI2MSAyNS4xNTQxODE4LDIuMzg4OTI3OTYiIGlkPSJGaWxsLTIiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMjIuNDM1MjIyNiw0LjgzOTA0NTQ3IEMyMS41NzM1MDc4LDMuODg0MzUzMjUgMjAuMzAxMDM3NiwzLjUyMTc3OTgxIDE5LjEyNjQ5NTMsMy43NzExODYzOSBDMTguNjQ2NDIwMSwzLjg3MzM2NjE4IDE4LjM0MDQ0ODMsNC4zNDUxMzQyMyAxOC40NDMzNjk5LDQuODI0OTMxMyBDMTguNTQ2MDM3Niw1LjMwMjY5OTk5IDE5LjAxODE1NjcsNS42MDk2NjE5NCAxOS40OTcxMzE3LDUuNTA1NjIyOCBMMTkuNDk3MTMxNyw1LjUwNjU1MjQ3IEMyMC4wNzEyNDE0LDUuMzg1MzU2NTkgMjAuNjkzODQ5NSw1LjU2MjE2Mzk3IDIxLjExNTEwMDMsNi4wMjc5MzEzOSBDMjEuNTM2ODU4OSw2LjQ5NDcxMzAxIDIxLjY1MDE5MTIsNy4xMzA2OTU1NiAyMS40NjkyMzIsNy42ODg3NTQ0MSBMMjEuNDcwMTYzLDcuNjg4NzU0NDEgQzIxLjMxOTY3NCw4LjE1NDUyMTgzIDIxLjU3NTAzMTMsOC42NTUzNjMzNyAyMi4wNDE5MDI4LDguODA2MzA4ODcgQzIyLjUwODk0MzYsOC45NTU1NjQwNCAyMy4wMDk4NDAxLDguNzAxMzQwMDUgMjMuMTYwNTgzMSw4LjIzNDM4OTQxIEMyMy41Mjk2OTU5LDcuMDkzNzYyMDkgMjMuMjk4NzE0Nyw1Ljc5MzQ4NDE0IDIyLjQzNTIyMjYsNC44MzkwNDU0NyIgaWQ9IkZpbGwtMyI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xMS44MDUzNDgsMTEuOTA0NDEwMiBDOS42ODE2NTgzMSwxMS4zNTI2OSA3LjI4MTM2Njc3LDEyLjQwOTQ3NzUgNi4zNTg5NjU1MiwxNC4yNzc5NTYzIEM1LjQxOTU1MTcyLDE2LjE4MzUzNzUgNi4zMjc5MDI4MiwxOC4yOTg5NzE4IDguNDczNTE0MTEsMTguOTkwMzk2OCBDMTAuNjk1OTc4MSwxOS43MDYwNzc5IDEzLjMxNTU3MDUsMTguNjA5Mzk4OSAxNC4yMjYyOTE1LDE2LjU1MjQ0OTYgQzE1LjEyNDU3MDUsMTQuNTQxODE1MSAxNC4wMDMwMTI1LDEyLjQ3MTUxMjIgMTEuODA1MzQ4LDExLjkwNDQxMDIgTDExLjgwNTM0OCwxMS45MDQ0MTAyIFogTTEwLjE4MzczOTgsMTYuNzcwOTIzMyBDOS43NTE5OTM3MywxNy40NTg1NDUyIDguODI3NjQ1NzcsMTcuNzU5OTI5IDguMTMxNDg1ODksMTcuNDQyNDg3MSBDNy40NDUzMTM0OCwxNy4xMzA0NTQyIDcuMjQyNzcxMTYsMTYuMzMxODYzIDcuNjc0NDMyNiwxNS42NjEzMTM0IEM4LjEwMDg0NjM5LDE0Ljk5MzU1MjggOC45OTQyMTYzLDE0LjY5NjE0MTIgOS42ODUyMTMxNywxNC45ODU0MzkzIEMxMC4zODQ0MjAxLDE1LjI4MjkzNTUgMTAuNjA3NjE0NCwxNi4wNzY0NTU4IDEwLjE4MzczOTgsMTYuNzcwOTIzMyBMMTAuMTgzNzM5OCwxNi43NzA5MjMzIFogTTExLjYwNTc2OCwxNC45NDg1MDU4IEMxMS40NDk2MDgyLDE1LjIxNDgxNTYgMTEuMTA0NjE3NiwxNS4zNDMxMTA4IDEwLjgzNDI3OSwxNS4yMzIwNTY5IEMxMC41Njg1MTEsMTUuMTIyODYyMiAxMC40ODUxNDExLDE0LjgyNDY5IDEwLjYzNjIyMjYsMTQuNTYyOTQ0IEMxMC43OTE3MDUzLDE0LjMwMjQ2NTkgMTEuMTIzMjM4MiwxNC4xNzUyNjk0IDExLjM4ODQxMzgsMTQuMjgwMzIyNyBDMTEuNjU3ODIxMywxNC4zNzg2OTkzIDExLjc1NDY0ODksMTQuNjgwMDgzMiAxMS42MDU3NjgsMTQuOTQ4NTA1OCBMMTEuNjA1NzY4LDE0Ljk0ODUwNTggWiIgaWQ9IkZpbGwtNCI+PC9wYXRoPg0KICAgICAgICAgICAgPC9nPg0KICAgICAgICA8L2c+DQogICAgPC9nPg0KPC9zdmc+)
        }

        .share-icon.weixin[_v-710e44f3] {
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIzMnB4IiBoZWlnaHQ9IjMycHgiIHZpZXdCb3g9IjAgMCAzMiAzMiIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDMuNy4yICgyODI3NikgLSBodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2ggLS0+DQogICAgPHRpdGxlPmV4dGVuc2lvbl93ZWl4aW48L3RpdGxlPg0KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KICAgIDxkZWZzPjwvZGVmcz4NCiAgICA8ZyBpZD0idjQiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPg0KICAgICAgICA8cGF0aCBkPSJNMTEuNjEwOTgyOSwzLjAwMTMxOTgxIEM1LjgxNTYxMzQ3LDIuOTEzOTc5NjIgMSw3LjE3MzU1Mjk4IDEsMTIuMTk3MjM3MSBDMSwxNS4wOTcwODYgMi4zNjM1ODkwNiwxNy42MTI3OTI2IDUuMDAzMTE3ODIsMTkuNDU5NzY3MSBDNS4wMDMxMTc4MiwxOS40NTk3NjcxIDQuMDM1NzI4NiwyMi42NTMwMTcyIDQuMDQ5NDg2NjEsMjIuNzE3MDE1MiBDNC4wNjMyNDQ2MiwyMi43ODExNjc3IDQuMjczNzg4NTksMjIuOTA2OTk5NCA0LjM0NzA2MTYsMjIuODY1ODggQzQuNDIwMzM0NjEsMjIuODI0NzYwNSA3Ljg0NDA3MDA3LDIwLjc4MjU0NTkgNy44NDQwNzAwNywyMC43ODI1NDU5IEMxMC40Njc5ODU4LDIxLjY4MzQ2MzggMTEuOTk3NTk4NSwyMS4zODM4NzkyIDEyLjA4NTA5MzMsMjEuMzc3ODUwNSBDMTEuODIzMjI3MywyMC42MTA5NTcyIDExLjY1MTYzODYsMTkuNDE2NzkyNyAxMS44NDcwMzMzLDE4LjI5MTI2MzYgQzEyLjg2OTkxODMsMTIuNDAwODI0NyAxOC44OTk0ODMyLDEwLjU2ODUzNTcgMjIuMjA0MDM0LDEwLjg4MTU2OTIgQzIxLjI5MTUyMjMsNi42Mjc1NjA4NSAxNy4zMjc4MjM1LDMuMDg3NDIzMzMgMTEuNjEwOTgyOSwzLjAwMTMxOTgxIFogTTIxLjY5ODg1MjIsMTEuNTg3MjQ3IEMxNi41ODc1MTg4LDExLjU4NzI0NyAxMi41MTA4MTg4LDE0Ljk1ODI2OTIgMTIuNTEwODE4OCwxOS4yNjE3NDQ1IEMxMi41MTA4MTg4LDIzLjU3MzEwMzYgMTYuMzg4NDE0LDI3LjE0MjMwMyAyMS43MDQ3MjY0LDI3LjE3MTUxOTUgQzIyLjc3NDc1OTcsMjcuMTc3NTQ4MyAyNC4zNjg1MjQ5LDI2LjkwMjM4OCAyNS40NDMxOTU3LDI2LjQ1MzMyMDMgQzI1LjQ0MzE5NTcsMjYuNDUzMzIwMyAyOC4wMTIyMzQsMjguMDExMzc2NiAyOC4xNTYxNTIxLDI3Ljk5OTkzNzMgQzI4LjI5OTkxNTYsMjcuOTg4MzQzNSAyOC4zNzM2NTIzLDI3Ljg3NDQxNDggMjguMzc5MzcyLDI3Ljc3NjcxNzQgQzI4LjM4NTA5MTYsMjcuNjc5MDIwMSAyNy41NjA4NDc1LDI1LjI0NzA5ODIgMjcuNTYwODQ3NSwyNS4yNDcwOTgyIEMyOS43NjY3NjcsMjMuNTE5MTUzNyAzMC42ODczMTcyLDIxLjYxNTEzNzUgMzAuNjg3MzE3MiwxOS4xODc1NDQgQzMwLjY4NzMxNzIsMTQuODgzNzU5NSAyNi41MjYyMTQxLDExLjU4NzI0NyAyMS42OTg4NTIyLDExLjU4NzI0NyBaIE03LjU4MjgyMjQyLDcuODM2MTAxNzUgQzYuODIyNTc2Myw3LjgzNjEwMTc1IDYuMjA2NDAyODUsOC40NTI1ODQzNyA2LjIwNjQwMjg1LDkuMjEzMTM5NjYgQzYuMjA2NDAyODUsOS45NzM2OTQ5NCA2LjgyMjU3NjMsMTAuNTkwMTc3NiA3LjU4MjgyMjQyLDEwLjU5MDE3NzYgQzguMzQzMDY4NTQsMTAuNTkwMTc3NiA4Ljk1OTM5NjU3LDkuOTczNjk0OTQgOC45NTkzOTY1Nyw5LjIxMzEzOTY2IEM4Ljk1OTM5NjU3LDguNDUyNTg0MzcgOC4zNDMwNjg1NCw3LjgzNjEwMTc1IDcuNTgyODIyNDIsNy44MzYxMDE3NSBaIE0xNS45MTYwMDQxLDcuODM2MTAxNzUgQzE1LjE1NTkxMjYsNy44MzYxMDE3NSAxNC41Mzk1ODQ1LDguNDUyNTg0MzcgMTQuNTM5NTg0NSw5LjIxMzEzOTY2IEMxNC41Mzk1ODQ1LDkuOTczNjk0OTQgMTUuMTU1OTEyNiwxMC41OTAxNzc2IDE1LjkxNjAwNDEsMTAuNTkwMTc3NiBDMTYuNjc2MjUwMiwxMC41OTAxNzc2IDE3LjI5MjU3ODIsOS45NzM2OTQ5NCAxNy4yOTI1NzgyLDkuMjEzMTM5NjYgQzE3LjI5MjU3ODIsOC40NTI1ODQzNyAxNi42NzY0MDQ4LDcuODM2MTAxNzUgMTUuOTE2MDA0MSw3LjgzNjEwMTc1IFogTTE4LjMzNDYzMTcsMTUuMTU4MTQ2OCBDMTcuNjYyMDM1LDE1LjE1ODE0NjggMTcuMTE2ODE1OCwxNS43MDQ0NDgxIDE3LjExNjgxNTgsMTYuMzc4NTkwNyBDMTcuMTE2ODE1OCwxNy4wNTI0MjQxIDE3LjY2MjAzNSwxNy41OTg4OCAxOC4zMzQ2MzE3LDE3LjU5ODg4IEMxOS4wMDcyMjg1LDE3LjU5ODg4IDE5LjU1MjQ0NzcsMTcuMDUyNTc4NyAxOS41NTI0NDc3LDE2LjM3ODU5MDcgQzE5LjU1MjQ0NzcsMTUuNzA0NDQ4MSAxOS4wMDcyMjg1LDE1LjE1ODE0NjggMTguMzM0NjMxNywxNS4xNTgxNDY4IFogTTI0Ljg0NjY1NDUsMTUuMTU4MTQ2OCBDMjQuMTc0MDU3NywxNS4xNTgxNDY4IDIzLjYyODgzODUsMTUuNzA0NDQ4MSAyMy42Mjg4Mzg1LDE2LjM3ODU5MDcgQzIzLjYyODgzODUsMTcuMDUyNDI0MSAyNC4xNzQwNTc3LDE3LjU5ODg4IDI0Ljg0NjY1NDUsMTcuNTk4ODggQzI1LjUxOTQwNTgsMTcuNTk4ODggMjYuMDY0NjI1LDE3LjA1MjU3ODcgMjYuMDY0NjI1LDE2LjM3ODU5MDcgQzI2LjA2NDYyNSwxNS43MDQ0NDgxIDI1LjUxOTQwNTgsMTUuMTU4MTQ2OCAyNC44NDY2NTQ1LDE1LjE1ODE0NjggWiIgaWQ9IkNvbWJpbmVkLVNoYXBlIiBmaWxsPSIjMDBDODBDIj48L3BhdGg+DQogICAgPC9nPg0KPC9zdmc+)
        }

        .share-icon.moment[_v-710e44f3] {
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIzMnB4IiBoZWlnaHQ9IjMycHgiIHZpZXdCb3g9IjAgMCAzMiAzMiIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDMuNy4yICgyODI3NikgLSBodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2ggLS0+DQogICAgPHRpdGxlPmV4dGVuc2lvbl9tb21lbnQ8L3RpdGxlPg0KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KICAgIDxkZWZzPjwvZGVmcz4NCiAgICA8ZyBpZD0idjQiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPg0KICAgICAgICA8ZyBpZD0iZXh0ZW5zaW9uIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTUyLjAwMDAwMCwgLTE1LjAwMDAwMCkiPg0KICAgICAgICAgICAgPGcgaWQ9IkltcG9ydGVkLUxheWVycy0yIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxNTUuMDAwMDAwLCAxOC4wMDAwMDApIj4NCiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTIuNzUsMC4wNDA0NzYxOTA1IEM1LjcwODM0NTU0LDAuMDQwNDc2MTkwNSAwLDUuNzMwNyAwLDEyLjc1IEMwLDE5Ljc2OTMgNS43MDgzNDU1NCwyNS40NTk1MjM4IDEyLjc1LDI1LjQ1OTUyMzggQzE5Ljc5MTY1NDUsMjUuNDU5NTIzOCAyNS41LDE5Ljc2OTMgMjUuNSwxMi43NSBDMjUuNSw1LjczMDcgMTkuNzkxNjU0NSwwLjA0MDQ3NjE5MDUgMTIuNzUsMC4wNDA0NzYxOTA1IEwxMi43NSwwLjA0MDQ3NjE5MDUgWiBNMTIuODcxODE1MywxNi42MzU3MTQzIEMxMC42OTY1MTkxLDE2LjYzNTcxNDMgOC45MzMxMjEwMiwxNC44Nzc5MTQzIDguOTMzMTIxMDIsMTIuNzA5NTIzOCBDOC45MzMxMjEwMiwxMC41NDExMzMzIDEwLjY5NjUxOTEsOC43ODMzMzMzMyAxMi44NzE4MTUzLDguNzgzMzMzMzMgQzE1LjA0NzExMTUsOC43ODMzMzMzMyAxNi44MTA1MDk2LDEwLjU0MTEzMzMgMTYuODEwNTA5NiwxMi43MDk1MjM4IEMxNi44MTA1MDk2LDE0Ljg3NzkxNDMgMTUuMDQ3MTExNSwxNi42MzU3MTQzIDEyLjg3MTgxNTMsMTYuNjM1NzE0MyBMMTIuODcxODE1MywxNi42MzU3MTQzIFoiIGlkPSJGaWxsLTEiIGZpbGw9IiNGRkZGRkYiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTcuNjM0MjI0NSwxLjc0MDQ3NjE5IEwxNy42MzQyMjQ1LDEzLjM5NzYxOSBMMjMuNTYyNTY4NSw3LjU2OTA0NzYyIEMyMy41NjI1Njg1LDcuNTY5MDQ3NjIgMjIuMDExMTI5LDMuNjY0NTUyMzggMTcuNjM0MjI0NSwxLjc0MDQ3NjE5IiBpZD0iRmlsbC0yIiBmaWxsPSIjRkZFRTJFIj48L3BhdGg+DQogICAgICAgICAgICAgICAgPHBhdGggZD0iTTE2LjY1OTcwMjIsMS4zMzU3MTQyOSBDMTYuNjU5NzAyMiwxLjMzNTcxNDI5IDEyLjg0MDMwNTcsLTAuMjM0NTE5MDQ4IDguMzgwNTY2ODgsMS40OTAwOTA0OCBMMTYuNjQ5NzEzNCw5LjczMjkwNDc2IEwxNi42NTk3MDIyLDEuMzM1NzE0MjkiIGlkPSJGaWxsLTMiIGZpbGw9IiNGMTc2NUEiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNy4zMjA1MzAyNSwxLjk4MzMzMzMzIEM3LjMyMDUzMDI1LDEuOTgzMzMzMzMgMy42MDA2OTc0NSwzLjYxMDggMS42NjkyNzU0OCw3Ljk3MzgwOTUyIEwxMy4zNzEwOTU1LDcuOTczODA5NTIgTDcuMzIwNTMwMjUsMS45ODMzMzMzMyIgaWQ9IkZpbGwtNCIgZmlsbD0iI0YxQjM1QSI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xLjMxMDk3NjExLDguOTQ1MjM4MSBDMS4zMTA5NzYxMSw4Ljk0NTIzODEgLTAuMjMyMDE3NTE2LDEyLjc1MjUwOTUgMS40OTkyMjEzNCwxNy4xOTgwOTA1IEw5Ljc3MzY0NjUsOC45NTUyNzYxOSBMMS4zMTA5NzYxMSw4Ljk0NTIzODEiIGlkPSJGaWxsLTUiIGZpbGw9IiNGMURENUEiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNy45NzAyMTE3OCwyMy44NDA0NzYyIEw3Ljk3MDIxMTc4LDEyLjE4MzMzMzMgTDEuOTYwNjU3NjQsMTguMTczODA5NSBDMS45NjA2NTc2NCwxOC4xNzM4MDk1IDMuNTkzMzg4NTQsMjEuOTE2NCA3Ljk3MDIxMTc4LDIzLjg0MDQ3NjIiIGlkPSJGaWxsLTYiIGZpbGw9IiNCQUYxNUEiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNOC45NDQ3MzQwOCwyNC4xNjQyODU3IEM4Ljk0NDczNDA4LDI0LjE2NDI4NTcgMTIuNzY0MTMwNiwyNS43MzQ1MTkgMTcuMjIzOTUwNiwyNC4wMDk5MDk1IEw4Ljk1NDgwNDE0LDE1Ljc2NzA5NTIgTDguOTQ0NzM0MDgsMjQuMTY0Mjg1NyIgaWQ9IkZpbGwtNyIgZmlsbD0iIzVFRjE1QSI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xOC4wNDAyNzU1LDIzLjUxNjY2NjcgQzE4LjA0MDI3NTUsMjMuNTE2NjY2NyAyMS45MjI2MDk5LDIxLjk3MDE1MjQgMjMuODU0MDMxOCwxNy42MDcxNDI5IEwxMi4xNTIxMzA2LDE3LjYwNzE0MjkgTDE4LjA0MDI3NTUsMjMuNTE2NjY2NyIgaWQ9IkZpbGwtOCIgZmlsbD0iIzVBRTVGMSI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0yNC4wMjQwODYsOC4zODI4NjE5IEwxNS43NDk2NjA4LDE2LjYyNTY3NjIgTDI0LjEzMTAzOTgsMTYuNjM1NzE0MyBDMjQuMTMxMDM5OCwxNi42MzU3MTQzIDI1Ljc1NTI0MzYsMTIuODI4NDQyOSAyNC4wMjQwODYsOC4zODI4NjE5IiBpZD0iRmlsbC05IiBmaWxsPSIjNkM1QUYxIj48L3BhdGg+DQogICAgICAgICAgICA8L2c+DQogICAgICAgIDwvZz4NCiAgICA8L2c+DQo8L3N2Zz4=)
        }

        .qrcode-box[_v-710e44f3] {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, .8);
            cursor: default;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: column;
            flex-direction: column
        }

        .qrcode-box .qrcode[_v-710e44f3] {
            width: 16rem
        }

        .qrcode-box .title[_v-710e44f3] {
            margin-top: 3rem;
            font-size: 2rem;
            color: #fff
        }

        .qrcode-box .desc[_v-710e44f3] {
            margin: 3rem 0;
            font-size: 1.2rem;
            color: #fbfbfb
        }</style>
    <style type="text/css">
        .source[_v-50254422] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-50254422] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-50254422] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }

        .item:hover .badge[_v-50254422] {
            color: #007fff;
            background-color: #e8f1ff
        }

        .item .badge[_v-50254422] {
            color: #e8f1ff;
            background-color: #007fff
        }</style>
    <style type="text/css">
        .category-box[_v-257b13ec] {
            -ms-flex-positive: 1;
            flex-grow: 1
        }</style>
    <style type="text/css">
        .source-selector[_v-09d73f71] {
            position: relative;
            height: 100%;
            font-size: 1.35rem;
            font-family: Verdana, Geneva, Microsoft YaHei, Microsoft JhengHei, Helvetica Neue, sans-serif;
            color: #646c7b
        }

        .source-selector.active .arrow[_v-09d73f71] {
            transform: rotate(180deg);
            opacity: 1
        }

        .source-selector.active .source-list[_v-09d73f71] {
            display: block
        }

        .curr[_v-09d73f71] {
            height: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .curr .title[_v-09d73f71] {
            margin: 0 1rem 0 0;
            opacity: 1
        }

        .curr .arrow[_v-09d73f71] {
            width: 1.5rem;
            height: 1.5rem;
            opacity: .8;
            display: none;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIxOHB4IiBoZWlnaHQ9IjE4cHgiIHZpZXdCb3g9IjAgMCAxOCAxOCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5hcnJvdzwvdGl0bGU+DQogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIHNrZXRjaHRvb2wuPC9kZXNjPg0KICAgIDxkZWZzPjwvZGVmcz4NCiAgICA8ZyBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4NCiAgICAgICAgPGcgaWQ9Imp1ZWppbl9jaHJvbWVfZXh0ZW5zaW9uX2Rlc2lnbmVyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTg5LjAwMDAwMCwgLTEwMi4wMDAwMDApIiBmaWxsPSIjQTlCM0M3Ij4NCiAgICAgICAgICAgIDxnIGlkPSJHcm91cC00IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMjMuMDAwMDAwLCA5OC4wMDAwMDApIj4NCiAgICAgICAgICAgICAgICA8ZyBpZD0iR3JvdXAtOCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjYuMDAwMDAwLCA0LjAwMDAwMCkiPg0KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNSw3IEwxMyw3IEw5LDExIEw1LDcgWiIgaWQ9IlJlY3RhbmdsZS0yMyI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDwvZz4NCiAgICAgICAgICAgIDwvZz4NCiAgICAgICAgPC9nPg0KICAgIDwvZz4NCjwvc3ZnPg==)
        }

        .icon[_v-09d73f71] {
            margin: 0 1rem 0 .4rem
        }

        .icon.syncing[_v-09d73f71] {
            animation: syncing .5s ease-in-out alternate infinite
        }

        @keyframes syncing {
            0% {
                border-radius: 2px
            }
            to {
                border-radius: 8px
            }
        }

        .multiple[_v-09d73f71] {
            cursor: pointer
        }

        .multiple .curr[_v-09d73f71] {
            padding-right: .5rem
        }

        .multiple .title[_v-09d73f71] {
            margin-right: .5rem
        }

        .multiple .arrow[_v-09d73f71] {
            display: block;
            opacity: .8
        }

        .multiple:hover .arrow[_v-09d73f71], .multiple:hover .title[_v-09d73f71] {
            opacity: 1
        }

        .source-list[_v-09d73f71] {
            position: absolute;
            background-color: #fff;
            border-top: 1px solid rgba(0, 0, 0, .05);
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            box-shadow: 0 1px 2px 0 rgba(34, 42, 48, .1);
            overflow: hidden;
            display: none
        }

        .item[_v-09d73f71] {
            width: 18rem;
            height: 4rem;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .item .icon[_v-09d73f71] {
            margin: 0 1rem 0 .4rem;
            border-radius: 2px
        }

        .item.active[_v-09d73f71] {
            color: #000;
            background-color: #fbfbfb
        }

        .item[_v-09d73f71]:hover {
            color: #fff;
            background-color: #007fff
        }

        .item:hover .title[_v-09d73f71] {
            opacity: 1
        }</style>
    <style type="text/css">
        .hottest[_v-e3db0b5a], .latest[_v-e3db0b5a] {
            display: inline-block;
            margin: 0 .1rem;
            width: 3.6rem;
            height: 3.5rem;
            font-size: 1.25rem;
            text-align: center;
            line-height: 3.5rem;
            color: #646c7b;
            opacity: .3;
            cursor: pointer
        }

        .hottest.active[_v-e3db0b5a], .latest.active[_v-e3db0b5a] {
            opacity: .8
        }

        .hottest.active[_v-e3db0b5a]:hover, .hottest[_v-e3db0b5a]:hover, .latest.active[_v-e3db0b5a]:hover, .latest[_v-e3db0b5a]:hover {
            opacity: 1
        }</style>
    <style type="text/css">
        .category-selector[_v-251ce02d] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            position: relative;
            width: 8rem;
            height: 2.5rem;
            border-radius: 2px;
            color: #646c7b;
            background-color: #f8f9fb;
            cursor: pointer
        }

        .category-selector.active[_v-251ce02d] {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            box-shadow: 0 1px 2px 0 rgba(34, 42, 48, .1)
        }

        .category-selector.active .title[_v-251ce02d] {
            opacity: 1
        }

        .category-selector.active .arrow[_v-251ce02d] {
            transform: rotate(180deg)
        }

        .category-selector.active .category-list[_v-251ce02d] {
            display: block
        }

        .category-selector:hover .title[_v-251ce02d] {
            opacity: 1
        }

        .category-selector .title[_v-251ce02d] {
            -ms-flex-positive: 1;
            flex-grow: 1;
            margin: 0 0 0 1rem;
            opacity: .8
        }

        .category-selector .arrow[_v-251ce02d] {
            -ms-flex-preferred-size: 2.5rem;
            flex-basis: 2.5rem;
            width: 1.5rem;
            height: 1.5rem;
            background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIxOHB4IiBoZWlnaHQ9IjE4cHgiIHZpZXdCb3g9IjAgMCAxOCAxOCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5hcnJvdzwvdGl0bGU+DQogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIHNrZXRjaHRvb2wuPC9kZXNjPg0KICAgIDxkZWZzPjwvZGVmcz4NCiAgICA8ZyBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4NCiAgICAgICAgPGcgaWQ9Imp1ZWppbl9jaHJvbWVfZXh0ZW5zaW9uX2Rlc2lnbmVyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTg5LjAwMDAwMCwgLTEwMi4wMDAwMDApIiBmaWxsPSIjQTlCM0M3Ij4NCiAgICAgICAgICAgIDxnIGlkPSJHcm91cC00IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMjMuMDAwMDAwLCA5OC4wMDAwMDApIj4NCiAgICAgICAgICAgICAgICA8ZyBpZD0iR3JvdXAtOCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjYuMDAwMDAwLCA0LjAwMDAwMCkiPg0KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNSw3IEwxMyw3IEw5LDExIEw1LDcgWiIgaWQ9IlJlY3RhbmdsZS0yMyI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDwvZz4NCiAgICAgICAgICAgIDwvZz4NCiAgICAgICAgPC9nPg0KICAgIDwvZz4NCjwvc3ZnPg==) no-repeat 50%;
            background-size: contain
        }

        .category-selector .category-list[_v-251ce02d] {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #f8f9fb;
            box-shadow: 0 1px 2px 0 rgba(34, 42, 48, .1);
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            z-index: 750;
            overflow: hidden;
            display: none
        }

        .category-selector .category-list .item[_v-251ce02d] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            height: 2.5rem
        }

        .category-selector .category-list .item .title[_v-251ce02d] {
            margin: 0 0 0 1rem
        }

        .category-selector .category-list .item.active[_v-251ce02d] {
            color: #646c7b;
            background-color: #e9f3fd
        }

        .category-selector .category-list .item[_v-251ce02d]:hover {
            color: #fff;
            background-color: #007fff
        }</style>
    <style type="text/css">
        .item[_v-16727261] {
            cursor: pointer
        }

        .item:hover .badge[_v-16727261] {
            color: #007fff;
            background-color: #e8f1ff
        }

        .item:hover .meta .action[_v-16727261] {
            display: block
        }

        .item .item-content[_v-16727261] {
            display: -ms-flexbox;
            display: flex;
            padding: .4rem 1.25rem .4rem .4rem;
            margin-bottom: .8rem;
            background-color: #fff;
            border-radius: 2px
        }

        .item .badge[_v-16727261] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            width: 2.834rem;
            height: 3.667rem;
            border-radius: 2px;
            transition: all .2s ease;
            color: #e8f1ff;
            background-color: #007fff;
            overflow: hidden
        }

        .item .badge .icon[_v-16727261] {
            margin-bottom: .1rem;
            font-size: 1.3rem
        }

        .item .badge .text[_v-16727261] {
            font-family: Helvetica Neue;
            font-size: 1rem;
            font-weight: 700
        }

        .item .badge.img[_v-16727261] {
            width: 4.889rem;
            background-position: 50%;
            background-size: cover
        }

        .entry-info[_v-16727261] {
            -ms-flex-positive: 1;
            flex-grow: 1;
            position: relative;
            margin-left: 1.2rem;
            height: 3.667rem;
            min-width: 0;
            cursor: pointer
        }

        .entry-info .title[_v-16727261] {
            max-width: 100%;
            font-size: 1.25rem;
            line-height: 1.8;
            color: #333;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .entry-info .meta[_v-16727261] {
            display: -ms-flexbox;
            display: flex;
            font-size: 1rem;
            line-height: 1;
            color: #c2c5cd;
            white-space: nowrap;
            opacity: .8
        }

        .entry-info .meta .list[_v-16727261] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            display: -ms-flexbox;
            display: flex;
            padding: 0;
            min-width: 0;
            overflow: hidden
        }

        .entry-info .meta .list .meta-item[_v-16727261] {
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            margin-right: 1rem;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden
        }

        .entry-info .meta .list .meta-item[_v-16727261]:last-child {
            -ms-flex: 0 1 auto;
            flex: 0 1 auto
        }

        .entry-info .meta .list .meta-item.hoverable .text.hover[_v-16727261] {
            display: none
        }

        .entry-info .meta .list .meta-item.hoverable[_v-16727261]:hover {
            color: #007fff
        }

        .entry-info .meta .list .meta-item.hoverable:hover .text[_v-16727261] {
            display: none
        }

        .entry-info .meta .list .meta-item.hoverable:hover .text.hover[_v-16727261] {
            display: block
        }

        .entry-info .meta .action[_v-16727261] {
            margin-left: 3rem;
            display: none
        }

        .filled .item[_v-16727261]:last-child {
            margin-bottom: 0
        }</style>
    <style type="text/css">
        .spinner[_v-7bc83f1e] {
            position: absolute;
            padding: 2rem 0;
            left: 0;
            bottom: 1rem;
            width: 100%;
            height: 5rem;
            text-align: center
        }

        .spinner > div[_v-7bc83f1e] {
            display: inline-block;
            margin: 0 3px;
            height: 100%;
            width: 4px;
            background-color: rgba(0, 0, 0, .15);
            animation: sk-stretchdelay 1.2s infinite ease-in-out
        }

        .spinner .rect2[_v-7bc83f1e] {
            animation-delay: -1.1s
        }

        .spinner .rect3[_v-7bc83f1e] {
            animation-delay: -1s
        }

        .spinner .rect4[_v-7bc83f1e] {
            animation-delay: -.9s
        }

        .spinner .rect5[_v-7bc83f1e] {
            animation-delay: -.8s
        }

        @keyframes sk-stretchdelay {
            0%, 40%, to {
                transform: scaleY(.4)
            }
            20% {
                transform: scaleY(1)
            }
        }</style>
    <style type="text/css">
        .source[_v-ac4e867c] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-ac4e867c] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-ac4e867c] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .period-selector[_v-33fd25cd] {
            margin-left: .8rem
        }</style>
    <style type="text/css">
        .list-selector[_v-28cd1351] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            position: relative;
            width: 8rem;
            height: 2.5rem;
            border-radius: 2px;
            color: #646c7b;
            background-color: #f8f9fb;
            cursor: pointer
        }

        .list-selector.active[_v-28cd1351] {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            box-shadow: 0 1px 2px 0 rgba(34, 42, 48, .1)
        }

        .list-selector.active .title[_v-28cd1351] {
            opacity: 1
        }

        .list-selector.active .arrow[_v-28cd1351] {
            transform: rotate(180deg)
        }

        .list-selector.active .list[_v-28cd1351] {
            display: block
        }

        .list-selector:hover .title[_v-28cd1351] {
            opacity: 1
        }

        .list-selector .title[_v-28cd1351] {
            -ms-flex-positive: 1;
            flex-grow: 1;
            margin: 0 0 0 1rem;
            opacity: .8
        }

        .list-selector .arrow[_v-28cd1351] {
            -ms-flex-preferred-size: 2.5rem;
            flex-basis: 2.5rem;
            width: 1.5rem;
            height: 1.5rem;
            background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIxOHB4IiBoZWlnaHQ9IjE4cHgiIHZpZXdCb3g9IjAgMCAxOCAxOCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5hcnJvdzwvdGl0bGU+DQogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIHNrZXRjaHRvb2wuPC9kZXNjPg0KICAgIDxkZWZzPjwvZGVmcz4NCiAgICA8ZyBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4NCiAgICAgICAgPGcgaWQ9Imp1ZWppbl9jaHJvbWVfZXh0ZW5zaW9uX2Rlc2lnbmVyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTg5LjAwMDAwMCwgLTEwMi4wMDAwMDApIiBmaWxsPSIjQTlCM0M3Ij4NCiAgICAgICAgICAgIDxnIGlkPSJHcm91cC00IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMjMuMDAwMDAwLCA5OC4wMDAwMDApIj4NCiAgICAgICAgICAgICAgICA8ZyBpZD0iR3JvdXAtOCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjYuMDAwMDAwLCA0LjAwMDAwMCkiPg0KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNSw3IEwxMyw3IEw5LDExIEw1LDcgWiIgaWQ9IlJlY3RhbmdsZS0yMyI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDwvZz4NCiAgICAgICAgICAgIDwvZz4NCiAgICAgICAgPC9nPg0KICAgIDwvZz4NCjwvc3ZnPg==) no-repeat 50%;
            background-size: contain
        }

        .list-selector .list[_v-28cd1351] {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #f8f9fb;
            box-shadow: 0 1px 2px 0 rgba(34, 42, 48, .1);
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            z-index: 750;
            overflow: hidden;
            display: none
        }

        .list-selector .list .item[_v-28cd1351] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            height: 2.5rem
        }

        .list-selector .list .item .title[_v-28cd1351] {
            margin: 0 0 0 1rem
        }

        .list-selector .list .item.disabled[_v-28cd1351] {
            color: #c2c5cd;
            cursor: default
        }

        .list-selector .list .item.active[_v-28cd1351] {
            color: #646c7b;
            background-color: #e9f3fd
        }

        .list-selector .list .item[_v-28cd1351]:hover:not(.disabled) {
            color: #fff;
            background-color: #007fff
        }</style>
    <style type="text/css">
        .lang-selector[_v-1de3dbca] {
            -ms-flex: 0 0 auto;
            flex: 0 0 auto;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -ms-flex-align: center;
            align-items: center;
            position: relative;
            margin-left: .5rem;
            height: 3.5rem;
            font-size: 1.15rem;
            color: #646c7b
        }

        .lang-selector.active .title[_v-1de3dbca] {
            opacity: 1
        }

        .lang-selector.active .arrow[_v-1de3dbca] {
            transform: rotate(180deg)
        }

        .lang-selector.active .lang-panel[_v-1de3dbca] {
            display: block
        }

        .lang-selector:hover .title[_v-1de3dbca] {
            opacity: 1
        }

        .lang-selector .curr[_v-1de3dbca] {
            height: 100%;
            cursor: pointer;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .lang-selector .title[_v-1de3dbca] {
            margin: 0 .5rem;
            opacity: .8
        }

        .lang-selector .arrow[_v-1de3dbca] {
            margin: 0 .8rem 0 0;
            width: 1.5rem;
            height: 1.5rem;
            color: #000;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIxOHB4IiBoZWlnaHQ9IjE4cHgiIHZpZXdCb3g9IjAgMCAxOCAxOCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5hcnJvdzwvdGl0bGU+DQogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIHNrZXRjaHRvb2wuPC9kZXNjPg0KICAgIDxkZWZzPjwvZGVmcz4NCiAgICA8ZyBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4NCiAgICAgICAgPGcgaWQ9Imp1ZWppbl9jaHJvbWVfZXh0ZW5zaW9uX2Rlc2lnbmVyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTg5LjAwMDAwMCwgLTEwMi4wMDAwMDApIiBmaWxsPSIjQTlCM0M3Ij4NCiAgICAgICAgICAgIDxnIGlkPSJHcm91cC00IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMjMuMDAwMDAwLCA5OC4wMDAwMDApIj4NCiAgICAgICAgICAgICAgICA8ZyBpZD0iR3JvdXAtOCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjYuMDAwMDAwLCA0LjAwMDAwMCkiPg0KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNSw3IEwxMyw3IEw5LDExIEw1LDcgWiIgaWQ9IlJlY3RhbmdsZS0yMyI+PC9wYXRoPg0KICAgICAgICAgICAgICAgIDwvZz4NCiAgICAgICAgICAgIDwvZz4NCiAgICAgICAgPC9nPg0KICAgIDwvZz4NCjwvc3ZnPg==)
        }

        .lang-panel[_v-1de3dbca] {
            position: absolute;
            top: 100%;
            right: 0;
            width: 20rem;
            background-color: #fff;
            border-top: 1px solid rgba(0, 0, 0, .05);
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            box-shadow: 0 1px 2px 0 rgba(34, 42, 48, .1);
            overflow: hidden;
            display: none
        }

        .lang-panel .filter-field-holder[_v-1de3dbca] {
            position: relative;
            border-bottom: 1px solid #e6edf4
        }

        .lang-panel .filter-field[_v-1de3dbca] {
            padding: 1rem 1.5rem;
            width: 100%;
            font-size: 1.15rem;
            border: none;
            outline: 0
        }

        .lang-panel .list-holder[_v-1de3dbca] {
            position: relative;
            max-height: 30rem;
            overflow: hidden
        }

        .lang-panel .channel-lang-list[_v-1de3dbca] {
            border-bottom: 1px solid #e6edf4
        }

        .lang-panel .lang-item[_v-1de3dbca] {
            padding: 1rem 1.5rem;
            cursor: pointer
        }

        .lang-panel .lang-item.active[_v-1de3dbca] {
            background-color: #fbfbfb
        }

        .lang-panel .lang-item.selected[_v-1de3dbca] {
            color: #fff;
            background-color: #007fff
        }

        .lang-panel .divider[_v-1de3dbca] {
            height: 0;
            border-bottom: 1px solid #e6edf4
        }</style>
    <style type="text/css">
        .list[_v-72127795] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap
        }

        .list .item-row[_v-72127795] {
            position: relative;
            margin: 0 .8rem .8rem 0
        }

        @media (max-width: 1300px) {
            .list .item-row[_v-72127795] {
                width: calc((100% - .8rem * 0) / 1)
            }

            .list .item-row[_v-72127795]:nth-child(1n) {
                margin-right: 0
            }
        }

        @media (min-width: 1300px) {
            .list .item-row[_v-72127795] {
                width: calc((100% - .8rem * 1) / 2)
            }

            .list .item-row[_v-72127795]:nth-child(2n) {
                margin-right: 0
            }
        }

        .list .item-row .item-box[_v-72127795] {
            position: relative;
            border-radius: 2px;
            background-color: #fff
        }

        .item[_v-72127795] {
            display: -ms-flexbox;
            display: flex;
            position: relative;
            padding: 24px 30px;
            font-family: PingFang SC, -apple-system, Arial, Microsoft YaHei, Microsoft JhengHei, Helvetica Neue, sans-serif;
            box-sizing: border-box;
            cursor: pointer
        }

        @media (max-width: 1380px) {
            .item[_v-72127795] {
                padding-left: 20px;
                padding-right: 20px
            }
        }

        .repo-user[_v-72127795] {
            margin-right: 15px
        }

        .repo-user .user[_v-72127795] {
            height: 48px;
            width: 48px;
            overflow: hidden;
            border-radius: 3px;
            display: block
        }

        .repo-user .user img[_v-72127795] {
            width: 100%
        }

        @media (max-width: 1380px) {
            .repo-user .user[_v-72127795] {
                height: 30px;
                width: 30px
            }
        }

        @media (max-width: 1300px) {
            .repo-user .user[_v-72127795] {
                height: 48px;
                width: 48px
            }
        }

        .repo-aside[_v-72127795] {
            width: 130px;
            height: 130px;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            background-color: #ccc
        }

        .repo-content[_v-72127795] {
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 0;
            overflow: hidden
        }

        .repo-content .repo-header[_v-72127795] {
            margin-bottom: 8px
        }

        .repo-content .repo-header .title[_v-72127795] {
            display: -ms-flexbox;
            display: flex;
            margin: 0;
            padding: 0;
            font-size: 1.334rem;
            font-weight: 600;
            line-height: 1.2;
            color: #0366d6;
            overflow: hidden;
            margin-right: 20px
        }

        .repo-content .repo-header .title .title-text[_v-72127795] {
            color: inherit;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .repo-content .repo-header .title .title-text[_v-72127795]:hover {
            text-decoration: underline
        }

        .repo-desc[_v-72127795] {
            color: #2e3135;
            font-size: 14px;
            line-height: 20px;
            height: 60px;
            margin-right: 20px;
            color: #333;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            overflow: hidden
        }

        @media (max-width: 1380px) {
            .repo-desc[_v-72127795] {
                margin-right: 10px
            }
        }

        @media (max-width: 1300px) {
            .repo-desc[_v-72127795] {
                margin-right: 20px
            }
        }

        .repo-meta[_v-72127795] {
            margin-top: 15px;
            font-size: 1.167rem;
            font-weight: 700;
            color: #666;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .repo-meta .icon[_v-72127795] {
            margin-right: 5px
        }

        .repo-meta > span[_v-72127795]:not(:last-child) {
            margin-right: 25px
        }

        .repo-meta .lang .lang-color[_v-72127795] {
            display: -ms-inline-flexbox;
            display: inline-flex;
            width: 12px;
            height: 12px;
            border-radius: 50%
        }

        .repo-meta .time[_v-72127795] {
            color: #b4b6b8;
            font-size: 12px;
            font-weight: 400
        }</style>
    <style type="text/css">
        .source[_v-1aef2d3a] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-1aef2d3a] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-1aef2d3a] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .source[_v-7fe72fbc] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-7fe72fbc] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-7fe72fbc] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .list[_v-22598b6b] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap
        }

        .list .item-row[_v-22598b6b] {
            position: relative;
            margin: 0 .8rem .8rem 0
        }

        @media (max-width: 1148px) {
            .list .item-row[_v-22598b6b] {
                width: calc((100% - .8rem * 1) / 2)
            }

            .list .item-row[_v-22598b6b]:nth-child(2n) {
                margin-right: 0
            }
        }

        @media (min-width: 1148px) and (max-width: 1448px) {
            .list .item-row[_v-22598b6b] {
                width: calc((100% - .8rem * 2) / 3)
            }

            .list .item-row[_v-22598b6b]:nth-child(3n) {
                margin-right: 0
            }
        }

        @media (min-width: 1448px) and (max-width: 1848px) {
            .list .item-row[_v-22598b6b] {
                width: calc((100% - .8rem * 3) / 4)
            }

            .list .item-row[_v-22598b6b]:nth-child(4n) {
                margin-right: 0
            }
        }

        @media (min-width: 1848px) {
            .list .item-row[_v-22598b6b] {
                width: calc((100% - .8rem * 4) / 5)
            }

            .list .item-row[_v-22598b6b]:nth-child(5n) {
                margin-right: 0
            }
        }

        .list .item-row .item-box[_v-22598b6b] {
            position: relative;
            padding-top: 75%;
            border-radius: 2px;
            background-color: #fff
        }

        .item[_v-22598b6b] {
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            overflow: hidden
        }

        .item:hover .board[_v-22598b6b] {
            bottom: 0
        }

        .entry-img[_v-22598b6b] {
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: cover;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden
        }

        .board[_v-22598b6b] {
            position: absolute;
            bottom: -4.6rem;
            padding: 0 1rem;
            width: 100%;
            height: 4.6rem;
            line-height: 3rem;
            font-size: 1.1rem;
            color: #646c7b;
            background-color: hsla(0, 0%, 100%, .95);
            transition: all .2s ease;
            z-index: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .title[_v-22598b6b] {
            font-weight: 700
        }

        .entry-info[_v-22598b6b] {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 2.4rem
        }

        .entry-info .like-count[_v-22598b6b], .entry-info .view-count[_v-22598b6b], .entry-info[_v-22598b6b] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .entry-info .icon[_v-22598b6b] {
            margin-right: .4rem
        }

        .entry-info .view-count .icon[_v-22598b6b] {
            font-size: 1.4rem
        }

        .entry-info .like-count[_v-22598b6b] {
            margin-left: 1.3rem
        }

        .entry-info .like-count .icon[_v-22598b6b] {
            font-size: 1.1rem
        }</style>
    <style type="text/css">
        .lazur {
            display: inline-block;
            position: relative;
            overflow: hidden
        }

        .lazur-image {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-repeat: no-repeat;
            background-position: 50%;
            background-size: cover
        }</style>
    <style type="text/css">
        .source[_v-94eddc5c] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-94eddc5c] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-94eddc5c] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .source[_v-4a6ed8e6] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-4a6ed8e6] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-4a6ed8e6] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .source[_v-7c966dc2] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-7c966dc2] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-7c966dc2] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .source[_v-156c8cdc] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-156c8cdc] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-156c8cdc] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .source[_v-89744f24] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-89744f24] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-89744f24] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .list[_v-7c4e49b0] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap
        }

        .list .item-row[_v-7c4e49b0] {
            position: relative;
            margin: 0 .8rem .8rem 0
        }

        @media (max-width: 1148px) {
            .list .item-row[_v-7c4e49b0] {
                width: calc((100% - .8rem * 1) / 2)
            }

            .list .item-row[_v-7c4e49b0]:nth-child(2n) {
                margin-right: 0
            }
        }

        @media (min-width: 1148px) and (max-width: 1448px) {
            .list .item-row[_v-7c4e49b0] {
                width: calc((100% - .8rem * 2) / 3)
            }

            .list .item-row[_v-7c4e49b0]:nth-child(3n) {
                margin-right: 0
            }
        }

        @media (min-width: 1448px) and (max-width: 1848px) {
            .list .item-row[_v-7c4e49b0] {
                width: calc((100% - .8rem * 3) / 4)
            }

            .list .item-row[_v-7c4e49b0]:nth-child(4n) {
                margin-right: 0
            }
        }

        @media (min-width: 1848px) {
            .list .item-row[_v-7c4e49b0] {
                width: calc((100% - .8rem * 4) / 5)
            }

            .list .item-row[_v-7c4e49b0]:nth-child(5n) {
                margin-right: 0
            }
        }

        .list .item-row .item-box[_v-7c4e49b0] {
            position: relative;
            padding-top: calc(75% + 11.5rem);
            min-height: 28rem;
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            background-color: #fff
        }

        .item[_v-7c4e49b0] {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden
        }

        .img-box[_v-7c4e49b0] {
            display: block;
            position: relative;
            padding-top: 75%;
            overflow: hidden
        }

        .img-box .img[_v-7c4e49b0] {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-position: 50%;
            background-size: cover;
            cursor: pointer
        }

        .info[_v-7c4e49b0] {
            position: relative;
            padding: .8rem 1.2rem;
            font-size: 1.1rem;
            border-top: .3rem solid #eceff1
        }

        .name[_v-7c4e49b0] {
            display: block;
            padding: 1rem 0;
            font-size: 1.3rem;
            font-weight: 700;
            cursor: pointer;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .tagline[_v-7c4e49b0] {
            line-height: 1.5;
            max-height: 3.3rem;
            overflow: hidden
        }

        .meta[_v-7c4e49b0] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: end;
            justify-content: flex-end;
            position: absolute;
            right: 1.2rem;
            bottom: 1.2rem;
            color: hsla(219, 9%, 51%, .8);
            cursor: pointer
        }

        .meta .comments-count[_v-7c4e49b0], .meta .votes-count[_v-7c4e49b0] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .meta .icon[_v-7c4e49b0] {
            margin: 0 .4rem 0 1rem
        }

        .meta .votes-count .icon[_v-7c4e49b0] {
            font-size: 1.5em
        }</style>
    <style type="text/css">
        .source[_v-63f9f2e2] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-63f9f2e2] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-63f9f2e2] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .source[_v-80da173c] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-80da173c] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-80da173c] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .source[_v-e9b4e394] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-e9b4e394] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-e9b4e394] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .source[_v-485df7bc] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-485df7bc] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-485df7bc] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .waterfall-holder[_v-00b9db1c] {
            position: relative;
            margin-top: -.4rem;
            margin-left: -.4rem;
            width: calc(100% + .8rem)
        }

        .item[_v-00b9db1c] {
            position: absolute;
            top: .4rem;
            left: .4rem;
            right: .4rem;
            bottom: .4rem;
            border-radius: 2px;
            cursor: pointer;
            overflow: hidden;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: cover
        }

        .item:hover .info[_v-00b9db1c] {
            opacity: 1;
            transition: all .2s ease
        }

        .info[_v-00b9db1c] {
            position: absolute;
            width: 100%;
            height: 100%;
            color: #fff;
            background-color: rgba(0, 0, 0, .5);
            opacity: 0;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: column;
            flex-direction: column
        }

        .avatar[_v-00b9db1c] {
            margin-bottom: 1rem;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50% 50%;
            background-color: rgba(236, 239, 241, .5);
            opacity: .8;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: cover
        }

        .name[_v-00b9db1c] {
            text-align: center;
            line-height: 1.5;
            letter-spacing: .1em
        }

        .item-move[_v-00b9db1c] {
            transition: all .5s cubic-bezier(.55, 0, .1, 1)
        }</style>
    <style type="text/css">
        .vue-waterfall {
            position: relative
        }</style>
    <style type="text/css">
        .vue-waterfall-slot {
            position: absolute;
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }</style>
    <style type="text/css">
        .source[_v-79a61122] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-79a61122] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-79a61122] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">
        .waterfall-holder[_v-067eb3ba] {
            position: relative;
            margin-top: -.4rem;
            margin-left: -.4rem;
            width: calc(100% + .8rem)
        }

        .item[_v-067eb3ba] {
            position: absolute;
            top: .4rem;
            left: .4rem;
            right: .4rem;
            bottom: .4rem;
            border-radius: 2px;
            cursor: pointer;
            overflow: hidden;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: cover
        }

        .item:hover .info[_v-067eb3ba] {
            opacity: 1;
            transition: all .2s ease
        }

        .info[_v-067eb3ba] {
            position: absolute;
            width: 100%;
            height: 100%;
            color: #fff;
            background-color: rgba(0, 0, 0, .5);
            opacity: 0;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: column;
            flex-direction: column
        }

        .avatar[_v-067eb3ba] {
            margin-bottom: 1rem;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50% 50%;
            background-color: rgba(236, 239, 241, .5);
            opacity: .8;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: cover
        }

        .name[_v-067eb3ba] {
            text-align: center;
            line-height: 1.5;
            letter-spacing: .1em
        }

        .item-move[_v-067eb3ba] {
            transition: all .5s cubic-bezier(.55, 0, .1, 1)
        }</style>
    <style type="text/css">
        .source[_v-4cdfcf70] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-4cdfcf70] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-4cdfcf70] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">.list[_v-e816425e] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap
        }

        .list .item-row[_v-e816425e] {
            position: relative;
            margin: 0 .8rem .8rem 0
        }

        @media (max-width: 1148px) {
            .list .item-row[_v-e816425e] {
                width: calc((100% - .8rem * 1) / 2)
            }

            .list .item-row[_v-e816425e]:nth-child(2n) {
                margin-right: 0
            }
        }

        @media (min-width: 1148px) and (max-width: 1448px) {
            .list .item-row[_v-e816425e] {
                width: calc((100% - .8rem * 2) / 3)
            }

            .list .item-row[_v-e816425e]:nth-child(3n) {
                margin-right: 0
            }
        }

        @media (min-width: 1448px) and (max-width: 1848px) {
            .list .item-row[_v-e816425e] {
                width: calc((100% - .8rem * 3) / 4)
            }

            .list .item-row[_v-e816425e]:nth-child(4n) {
                margin-right: 0
            }
        }

        @media (min-width: 1848px) {
            .list .item-row[_v-e816425e] {
                width: calc((100% - .8rem * 4) / 5)
            }

            .list .item-row[_v-e816425e]:nth-child(5n) {
                margin-right: 0
            }
        }

        .list .item-row .item-box[_v-e816425e] {
            position: relative;
            padding-top: calc(75% + 11.5rem);
            min-height: 28rem;
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            background-color: #fff
        }

        .item[_v-e816425e] {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden
        }

        .img-box[_v-e816425e] {
            position: relative;
            padding-top: 75%;
            overflow: hidden
        }

        .img-box .img[_v-e816425e] {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            border-top-left-radius: 2px;
            border-top-right-radius: 2px;
            background-repeat: no-repeat;
            background-position: 50%;
            background-size: cover;
            cursor: pointer
        }

        .info[_v-e816425e] {
            position: relative;
            padding: .8rem 1.2rem;
            font-size: 1.1rem;
            border-top: .3rem solid #eceff1
        }

        .title[_v-e816425e] {
            padding: 1rem 0;
            font-size: 1.3rem;
            font-weight: 700;
            cursor: pointer;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .desc[_v-e816425e] {
            line-height: 1.5;
            max-height: 3.3rem;
            overflow: hidden
        }

        .meta[_v-e816425e] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: end;
            justify-content: flex-end;
            position: absolute;
            right: 1.2rem;
            bottom: 1.2rem;
            color: hsla(219, 9%, 51%, .8)
        }

        .meta .likes[_v-e816425e], .meta .views[_v-e816425e] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .meta .icon[_v-e816425e] {
            margin: 0 .4rem 0 1rem
        }

        .meta .views .icon[_v-e816425e] {
            font-size: 1.4em
        }</style>
    <style type="text/css">.source[_v-507f75a2] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-507f75a2] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-507f75a2] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">.list[_v-50e8d046] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap
        }

        .list .item-row[_v-50e8d046] {
            position: relative;
            margin: 0 .8rem .8rem 0
        }

        @media (max-width: 1148px) {
            .list .item-row[_v-50e8d046] {
                width: calc((100% - .8rem * 1) / 2)
            }

            .list .item-row[_v-50e8d046]:nth-child(2n) {
                margin-right: 0
            }
        }

        @media (min-width: 1148px) and (max-width: 1448px) {
            .list .item-row[_v-50e8d046] {
                width: calc((100% - .8rem * 2) / 3)
            }

            .list .item-row[_v-50e8d046]:nth-child(3n) {
                margin-right: 0
            }
        }

        @media (min-width: 1448px) and (max-width: 1848px) {
            .list .item-row[_v-50e8d046] {
                width: calc((100% - .8rem * 3) / 4)
            }

            .list .item-row[_v-50e8d046]:nth-child(4n) {
                margin-right: 0
            }
        }

        @media (min-width: 1848px) {
            .list .item-row[_v-50e8d046] {
                width: calc((100% - .8rem * 4) / 5)
            }

            .list .item-row[_v-50e8d046]:nth-child(5n) {
                margin-right: 0
            }
        }

        .list .item-row .item-box[_v-50e8d046] {
            position: relative;
            padding-top: calc(75% + 11.5rem);
            min-height: 28rem;
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            background-color: #fff
        }

        .item[_v-50e8d046] {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden
        }

        .img-box[_v-50e8d046] {
            position: relative;
            padding-top: 75%;
            overflow: hidden
        }

        .img-box .img[_v-50e8d046] {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            border-top-left-radius: 2px;
            border-top-right-radius: 2px;
            background-repeat: no-repeat;
            background-position: 50%;
            background-size: cover;
            cursor: pointer
        }

        .info[_v-50e8d046] {
            position: relative;
            padding: .8rem 1.2rem;
            font-size: 1.1rem;
            border-top: .3rem solid #eceff1
        }

        .title[_v-50e8d046] {
            padding: 1rem 0;
            font-size: 1.3rem;
            font-weight: 700;
            cursor: pointer;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .desc[_v-50e8d046] {
            line-height: 1.5;
            max-height: 3.3rem;
            overflow: hidden
        }

        .meta[_v-50e8d046] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: end;
            justify-content: flex-end;
            position: absolute;
            right: 1.2rem;
            bottom: 1.2rem;
            color: hsla(219, 9%, 51%, .8)
        }

        .meta .likes[_v-50e8d046], .meta .views[_v-50e8d046] {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center
        }

        .meta .icon[_v-50e8d046] {
            margin: 0 .4rem 0 1rem
        }

        .meta .views .icon[_v-50e8d046] {
            font-size: 1.4em
        }</style>
    <style type="text/css">.source[_v-6abc1eca] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-6abc1eca] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-6abc1eca] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">.source[_v-c0beb0fc] {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .source .source-navbar[_v-c0beb0fc] {
            margin: 0 0 1.2rem
        }

        .source .entry-list[_v-c0beb0fc] {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto
        }</style>
    <style type="text/css">.update-layout[_v-77e8ca13] {
            background-color: #eceff1;
            z-index: 2000;
            cursor: default;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .update-layout .wrap[_v-77e8ca13] {
            position: absolute;
            width: 100%;
            height: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-direction: column;
            flex-direction: column
        }

        .logo[_v-77e8ca13] {
            width: 6rem
        }

        .words[_v-77e8ca13] {
            font-size: 1.4rem;
            line-height: 4;
            color: #646c7b
        }

        .action[_v-77e8ca13] {
            margin-top: 2rem;
            width: 12rem;
            font-size: 1.4rem;
            line-height: 2.5;
            color: #fff;
            background-color: #007fff;
            outline: 0;
            border: 0;
            border-radius: 4px
        }

        .action[disabled][_v-77e8ca13] {
            background-color: #767e8d
        }

        .store[_v-77e8ca13] {
            display: block;
            position: relative;
            margin-top: 2rem;
            width: 2rem
        }

        .store img[_v-77e8ca13] {
            width: 100%
        }</style>

<body>

<div id="app" class="app-transition" style="">
    <div class="layout source-layout equalize">
        <!--        <div class="navbar" _v-1d5c1ab1="">-->
        <!---->
        <!--        </div>-->
        <div class="main-area">
            <div class="source gold-source" style="width: 100%;" _v-50254422="">
                <div class="source-navbar" _v-257b13ec="" _v-50254422="">
                    <div class="source-selector" _v-09d73f71="" _v-257b13ec="">
                        <div class="curr" _v-09d73f71="">
                            <img class="icon source-icon" _v-09d73f71="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGYAAABmCAIAAAC2vXM1AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NTc3MiwgMjAxNC8wMS8xMy0xOTo0NDowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjlBNjZGODJBNDAyMTExRTZCOEUyOTJCQTE1RTY4NTA5IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjlBNjZGODJCNDAyMTExRTZCOEUyOTJCQTE1RTY4NTA5Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OUE2NkY4Mjg0MDIxMTFFNkI4RTI5MkJBMTVFNjg1MDkiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6OUE2NkY4Mjk0MDIxMTFFNkI4RTI5MkJBMTVFNjg1MDkiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz69bBYBAAAII0lEQVR42uyc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">
                            <div class="title" _v-09d73f71="" style="color: rgb(4, 74, 171);">
                                <?php
                                $selection = Yii::$app->request->get('type')?:1;
                                echo \yii\helpers\Html::dropDownList('type', $selection, $blogs, ['class' => 'dropdownlist','onChange'=>"change()",'style'=>'border: none;']); ?>
                            </div>

                            <div class="arrow" _v-09d73f71=""></div>
                        </div>
                    </div>
                    <div class="category-box" _v-257b13ec="">
<!--                        <div class="category-selector" _v-251ce02d="" _v-257b13ec="">-->
<!--                            <div class="title" _v-251ce02d="">产品</div>-->
<!--                            <div class="arrow" _v-251ce02d=""></div>-->
<!--                            <ul class="category-list" _v-251ce02d="">-->
<!--                                <li class="item" _v-251ce02d=""><span class="title" _v-251ce02d="">首页</span></li>-->
<!--                                <li class="item" _v-251ce02d=""><span class="title" _v-251ce02d="">Android</span></li>-->
<!--                                <li class="item" _v-251ce02d=""><span class="title" _v-251ce02d="">前端</span></li>-->
<!--                                <li class="item active" _v-251ce02d=""><span class="title" _v-251ce02d="">产品</span></li>-->
<!--                                <li class="item" _v-251ce02d=""><span class="title" _v-251ce02d="">设计</span></li>-->
<!--                                <li class="item" _v-251ce02d=""><span class="title" _v-251ce02d="">iOS</span></li>-->
<!--                                <li class="item" _v-251ce02d=""><span class="title" _v-251ce02d="">后端</span></li>-->
<!--                                <li class="item" _v-251ce02d=""><span class="title" _v-251ce02d="">人工智能</span></li>-->
<!--                                <li class="item" _v-251ce02d=""><span class="title" _v-251ce02d="">阅读</span></li>-->
<!--                                <li class="item" _v-251ce02d=""><span class="title" _v-251ce02d="">工具资源</span></li>-->
<!--                            </ul>-->
<!--                        </div>-->
                    </div>
                    <div class="order-selector" _v-e3db0b5a="" _v-257b13ec="">
<!--                        <div class="hottest" _v-e3db0b5a="">热门</div>-->
                        <div class="latest active" _v-e3db0b5a="">最新</div>
                    </div>
                </div>
                <div class="entry-list" _v-16727261="" _v-50254422="">
                    <ul class="list" _v-16727261="" style="transform: translate(0px, 0px) translateZ(0px);">

                        <?php if( $data ){
                            foreach ($data as $v){
                                echo " <li class=\"item\" _v-16727261=\"\"><a class=\"item-content\" _v-16727261=\"\" href=\"{$v['link']}\"target=\"_blank\">
                                <div class=\"badge\" _v-16727261=\"\" title=\"至少已有 {$v['diggs']} 人喜欢\">
                                    <div class=\"icon ion-arrow-up-b\" _v-16727261=\"\"></div>
                                    <div class=\"text\" _v-16727261=\"\">{$v['diggs']}</div>
                                </div>
                                <div class=\"entry-info\" _v-16727261=\"\">
                                    <div class=\"title\" _v-16727261=\"\" title=\"{$v['title']}\">{$v['title']}</div>
                                    <div class=\"meta\" _v-16727261=\"\">
                                        <div class=\"list\" _v-16727261=\"\">
                                            <div class=\"meta-item\" _v-16727261=\"\">
                                            <span class=\"text\" _v-16727261=\"\"                                                                              title=\"{$v['published']}\">{$v['published']}</span>
                                            </div>
                                            <div class=\"meta-item\" _v-16727261=\"\"><span onclick111='window.open(\"{{$v['author']['uri']}}\")' class=\"text\" _v-16727261=\"\" title=\"访问 {$v['author']['name']} 的主页\">{$v['author']['name']}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a></li>
";
                            }
                        }
                        ?>
                        <div class="loading spinner" _v-7bc83f1e="" _v-16727261="">
                            <div class="rect1" _v-7bc83f1e=""></div>
                            <div class="rect2" _v-7bc83f1e=""></div>
                            <div class="rect3" _v-7bc83f1e=""></div>
                            <div class="rect4" _v-7bc83f1e=""></div>
                            <div class="rect5" _v-7bc83f1e=""></div>
                        </div>
                    </ul>
                    <div class="iScrollVerticalScrollbar iScrollLoneScrollbar" style="overflow: hidden;">
                        <div class="iScrollIndicator"
                             style="transition-duration: 0ms; display: block; height: 8px; transform: translate(0px, 0px) translateZ(0px);"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-box" _v-8c48346e="" style="display: none;">
        <div class="modal feedback-modal" _v-8c48346e="">
            <div class="header" _v-8c48346e="">意见反馈
                <div title="关闭这个窗口" class="close-btn ion-android-close" _v-8c48346e=""></div>
            </div>
            <div class="body" _v-8c48346e="">
                <div class="tag-box" _v-8c48346e=""><span class="tag active" _v-8c48346e="">虚空</span><span class="tag"
                                                                                                           _v-8c48346e="">提意见</span><span
                            class="tag" _v-8c48346e="">有BUG</span><span class="tag" _v-8c48346e="">要投诉</span></div>
                <textarea maxlength="512" class="content" _v-8c48346e=""
                          placeholder="你可以在这里畅所欲言，甚至谈天论地，因为我们从来都不看。"></textarea><input maxlength="64" class="email"
                                                                                       _v-8c48346e=""
                                                                                       placeholder="你的邮箱，即一个永远不会被回复的地址">
                <div class="ctrl" _v-8c48346e="">
                    <button class="btn cancel-btn" _v-8c48346e="">取消</button>
                    <button class="btn submit-btn" _v-8c48346e="" disabled="">提交</button>
                </div>
                <div class="message-box" _v-8c48346e="" style="display: none;">
                    <div class="message" _v-8c48346e=""></div>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-modal-box" _v-173f9211="" style="display: none;">
        <div class="modal" _v-173f9211="">
            <div class="header" _v-173f9211="">
                <div title="关闭这个窗口" class="close-btn ion-android-close" _v-173f9211=""></div>
            </div>
            <div class="body" _v-173f9211="">
                <div class="channel-area" _v-173f9211="">
                    <div class="area-title" _v-173f9211="">选择你感兴趣的分类</div>
                    <div class="channel-box" _v-173f9211="">
                        <div class="channel-item" _v-173f9211=""><img class="icon" _v-173f9211=""
                                                                      src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIyN3B4IiBoZWlnaHQ9IjI3cHgiIHZpZXdCb3g9IjAgMCAyNyAyNyIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5hbmRyb2lkPC90aXRsZT4NCiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggc2tldGNodG9vbC48L2Rlc2M+DQogICAgPGRlZnM+PC9kZWZzPg0KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPg0KICAgICAgICA8ZyBpZD0ianVlamluX2Nocm9tZV9leHRlbnNpb25fZm9udC1lbmQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMjE1LjAwMDAwMCwgLTgyLjAwMDAwMCkiPg0KICAgICAgICAgICAgPGcgaWQ9IlNoYXBlLSstUGF0aC0rLVBhdGgtKy1hcnRpY2xlIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMjE1LjAwMDAwMCwgODIuMDAwMDAwKSI+DQogICAgICAgICAgICAgICAgPGcgaWQ9IlNoYXBlLSstUGF0aC0rLVBhdGgiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDUuNjg0MjExLCAzLjU1MjYzMikiPg0KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMC4zNTUyNjMxNTgsNy40NjA1MjYzMiBMMC4zNTUyNjMxNTgsMTIuNzg5NDczNyBDMC4zNTUyNjMxNTgsMTMuNDY1NzM0NyAwLjgyNzUzMzgwNiwxMy44NTUyNjMyIDEuNDIxMDUyNjMsMTMuODU1MjYzMiBDMi4wMTQ1NzE0LDEzLjg1NTI2MzIgMi40ODY4NDIxMSwxMy40NjU3MzQ3IDIuNDg2ODQyMTEsMTIuNzg5NDczNyBMMi40ODY4NDIxMSw3LjQ2MDUyNjMyIEMyLjQ4Njg0MjExLDYuNzg0MjY1MjkgMi4wMTQ1NzE0LDYuMzk0NzM2ODQgMS40MjEwNTI2Myw2LjM5NDczNjg0IEMwLjgyNzUzMzgwNiw2LjM5NDczNjg0IDAuMzU1MjYzMTU4LDYuNzg0MjY1MjkgMC4zNTUyNjMxNTgsNy40NjA1MjYzMiBaIE02Ljc1LDE1LjYzMTU3ODkgTDguODgxNTc4OTUsMTUuNjMxNTc4OSBMOC44ODE1Nzg5NSwxOC40NzM2ODQyIEM4Ljg4MTU3ODk1LDE5LjE0OTk0NyA5LjM1Mzg0OTc1LDE5LjY4ODA0NzMgOS45NDczNjg2OSwxOS42ODgwNDczIEMxMC41NDA4ODc2LDE5LjY4ODA0NzMgMTEuMDEzMTU3OSwxOS4xNDk5NDcgMTEuMDEzMTU3OSwxOC40NzM2ODQyIEwxMS4wMTMxNTc5LDE1LjYzMTU3ODkgTDExLjg1NjQxOTcsMTUuNjMxNTc4OSBDMTIuNTcwMTQ3OCwxNS42MzE1Nzg5IDEzLjE0NDczNjgsMTUuMDQyNzAxOSAxMy4xNDQ3MzY4LDE0LjMxMTIyNjYgTDEzLjE0NDczNjgsNi4wMzk0NzM2OCBMNy44MTU3ODk0Nyw2LjAzOTQ3MzY4IEwyLjQ4Njg0MjExLDYuMDM5NDczNjggTDIuNDg2ODQyMTEsMTQuMzExMjI2NiBDMi40ODY4NDIxMSwxNS4wNDI3MDE5IDMuMDYxNDMxNDUsMTUuNjMxNTc4OSAzLjc3NTE1OSwxNS42MzE1Nzg5IEw0LjYxODQyMTA1LDE1LjYzMTU3ODkgTDQuNjE4NDIxMDUsMTguNDczNjg0MiBDNC42MTg0MjEwNSwxOS4xNDk5NDcgNS4wOTA2OTE0NywxOS42ODgwNDczIDUuNjg0MjEwMzgsMTkuNjg4MDQ3MyBDNi4yNzc3MjkzLDE5LjY4ODA0NzMgNi43NSwxOS4xNDk5NDcgNi43NSwxOC40NzM2ODQyIEw2Ljc1LDE1LjYzMTU3ODkgWiBNMTMuMTQ0NzM2OCw3LjQ2MDUyNjMyIEwxMy4xNDQ3MzY4LDEyLjc4OTQ3MzcgQzEzLjE0NDczNjgsMTMuNDY1NzM0NyAxMy42MTcwMDc0LDEzLjg1NTI2MzIgMTQuMjEwNTI2MywxMy44NTUyNjMyIEMxNC44MDQwNDUyLDEzLjg1NTI2MzIgMTUuMjc2MzE1OCwxMy40NjU3MzQ3IDE1LjI3NjMxNTgsMTIuNzg5NDczNyBMMTUuMjc2MzE1OCw3LjQ2MDUyNjMyIEMxNS4yNzYzMTU4LDYuNzg0MjY1MjkgMTQuODA0MDQ1Miw2LjM5NDczNjg0IDE0LjIxMDUyNjMsNi4zOTQ3MzY4NCBDMTMuNjE3MDA3NCw2LjM5NDczNjg0IDEzLjE0NDczNjgsNi43ODQyNjUyOSAxMy4xNDQ3MzY4LDcuNDYwNTI2MzIgWiBNNC40MjY2Mzc0NCwwLjAyMzE5ODc1IEM0LjM0MTQyNTc5LDAuMDczMDc5MTYzNiA0LjMxMzQwNDMxLDAuMTc2NDgzODEgNC4zNjA3NTc1OCwwLjI2NjY5NzYxIEw1LjIwMjU1NTI2LDEuODcyNjI2NTQgQzMuNTgyOTc0OTIsMi43NjI1NTQyMyAyLjQ4OTAzNDYxLDQuMDk4NTEwNSAyLjQ4Njg0MjExLDYuMDM5NDczNjggTDEzLjE0NDczNjgsNi4wMzk0NzM2OCBDMTMuMTQyNTQ3MSw0LjA5ODUxMDUgMTIuMDQ4NjA0MSwyLjc2MjU1NDIzIDEwLjQyOTAyMzIsMS44NzI2MjY1NCBMMTEuMjcwODIxNywwLjI2NjY5NzYxIEMxMS4zMTgxNzQ3LDAuMTc2NDgzODEgMTEuMjkwMTUzLDAuMDczMDc5MTYzNiAxMS4yMDQ5NDE2LDAuMDIzMTk4NzUgQzExLjE3ODk5MywwLjAwODAxMDI3MzI5IDExLjE1MjY3MDUsMC4wMDAyOTMwODk3NDIgMTEuMTI0NDIxNyw4Ljc1OTcxNDAyZS0wNiBDMTEuMDYzOTQ4NSwtMC4wMDA2MDc0OTIyODcgMTEuMDA2NjI3MSwwLjAzMTMwMDkzODQgMTAuOTc0MzYxNiwwLjA5Mjc2OTk0MDMgTDEwLjEyMTU4MzUsMS43MTYwOTE4MiBDOS40MjM5NzcxNSwxLjM4OTMxOTYyIDguNjQxNTAzOCwxLjIwNTkwNTMzIDcuODE1Nzg5NTIsMS4yMDU5MDUzMyBDNi45OTAwNzQ1NiwxLjIwNTkwNTMzIDYuMjA3NjAwNiwxLjM4OTMxOTYyIDUuNTA5OTk0OTIsMS43MTYwOTE4MiBMNC42NTcyMTY4NCwwLjA5Mjc2OTk0MDMgQzQuNjI0OTUxNTIsMC4wMzEzMDA5Mzg0IDQuNTY3NjI5NjYsLTAuMDAwNjAzODMwOTMxIDQuNTA3MTU3MjQsOC43NTk3MTQwMmUtMDYgQzQuNDc4OTA4NTIsMC4wMDAzMTM4MzQ4MjEgNC40NTI1ODU5LDAuMDA4MDEwMjczMjkgNC40MjY2Mzc0NCwwLjAyMzE5ODc1IFoiIGlkPSJTaGFwZSIgc3Ryb2tlPSIjMDA3RkZGIiBzdHJva2Utd2lkdGg9IjAuNzIiIGZpbGw9IiNFOUYzRkQiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTkuOTQ3MzY4NDIsMy45MDc4OTQ5NyBDOS45NDczNjg0Miw0LjEwMjI2NzgxIDEwLjEwODI1ODksNC4yNjMxNTc4OSAxMC4zMDI2MzE4LDQuMjYzMTU3ODkgQzEwLjQ5NzAwNDIsNC4yNjMxNTc4OSAxMC42NTc4OTQ3LDQuMTAyMjY3ODEgMTAuNjU3ODk0NywzLjkwNzg5NDk3IEMxMC42NTc4OTQ3LDMuNzEzNTIxNjcgMTAuNDk3MDA0MiwzLjU1MjYzMTU4IDEwLjMwMjYzMTgsMy41NTI2MzE1OCBDMTAuMTA4MjU4OSwzLjU1MjYzMTU4IDkuOTQ3MzY4NDIsMy43MTM1MjE2NyA5Ljk0NzM2ODQyLDMuOTA3ODk0OTcgWiIgaWQ9IlBhdGgiIGZpbGw9IiMwMDdGRkYiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTQuOTczNjg0MjEsMy45MDc4OTQ5NyBDNC45NzM2ODQyMSw0LjEwMjI2NzgxIDUuMTM0NTc0NTksNC4yNjMxNTc4OSA1LjMyODk0NzQ4LDQuMjYzMTU3ODkgQzUuNTIzMzIwMzgsNC4yNjMxNTc4OSA1LjY4NDIxMDUzLDQuMTAyMjY3ODEgNS42ODQyMTA1MywzLjkwNzg5NDk3IEM1LjY4NDIxMDUzLDMuNzEzNTIxNjcgNS41MjMzMjAzOCwzLjU1MjYzMTU4IDUuMzI4OTQ3NDgsMy41NTI2MzE1OCBDNS4xMzQ1NzQ1OSwzLjU1MjYzMTU4IDQuOTczNjg0MjEsMy43MTM1MjE2NyA0Ljk3MzY4NDIxLDMuOTA3ODk0OTcgWiIgaWQ9IlBhdGgiIGZpbGw9IiMwMDdGRkYiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICA8L2c+DQogICAgICAgICAgICA8L2c+DQogICAgICAgIDwvZz4NCiAgICA8L2c+DQo8L3N2Zz4="><span
                                    class="title" _v-173f9211="">Android</span></div>
                        <div class="channel-item" _v-173f9211=""><img class="icon" _v-173f9211=""
                                                                      src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIyN3B4IiBoZWlnaHQ9IjI3cHgiIHZpZXdCb3g9IjAgMCAyNyAyNyIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5kZXNpZ248L3RpdGxlPg0KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBza2V0Y2h0b29sLjwvZGVzYz4NCiAgICA8ZGVmcz48L2RlZnM+DQogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+DQogICAgICAgIDxnIGlkPSJqdWVqaW5fY2hyb21lX2V4dGVuc2lvbl9mb250LWVuZCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEyMTUuMDAwMDAwLCAtMTY2LjAwMDAwMCkiIHN0cm9rZT0iIzAwN0ZGRiIgc3Ryb2tlLXdpZHRoPSIwLjcyIiBmaWxsPSIjRTlGM0ZEIj4NCiAgICAgICAgICAgIDxnIGlkPSJQYXRoLTk2LSstcHJvZHVjdCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTIxNS4wMDAwMDAsIDE2Ni4wMDAwMDApIj4NCiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTQuOTUxNDcwMiw3LjI3MjMyOTM1IEwxNi4zMTgzMDA2LDUuNDU4NDg0MTggQzE3LjAzODE5NjgsNC41MDMxNDk2NSAxOC4zOTMxMTkyLDQuMzE1ODc3MyAxOS4zNDgxMjU5LDUuMDM1NTI2NDggTDIwLjI2NDkzNDksNS43MjYzOTE2MyBDMjEuMjIyMDAxOSw2LjQ0NzU5MzM4IDIxLjQxMjUwNjQsNy44MDEyNjkwMSAyMC42OTUwNDA1LDguNzUzMzc4NTMgTDE5LjMyNjY2NDUsMTAuNTY5Mjc0NyBMMTQuOTUxNDcwMiw3LjI3MjMyOTM1IFogTTE0LjE1NjUzMyw4LjMyNzI0NjYxIEw4LjMzNTI0MjM2LDE2LjA1MjM2MDMgTDcuNDQyOTg1MiwyMS43ODc5Mzc3IEwxMi43MjE0Njg2LDE5LjMzNDY2NTcgTDE4LjUzMTcyNzMsMTEuNjI0MTkyIEwxNC4xNTY1MzMsOC4zMjcyNDY2MSBaIiBpZD0iUGF0aC05NiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTQuMTcwMDk4LCAxMy4zMDgyNTQpIHJvdGF0ZSg1LjAwMDAwMCkgdHJhbnNsYXRlKC0xNC4xNzAwOTgsIC0xMy4zMDgyNTQpICI+PC9wYXRoPg0KICAgICAgICAgICAgPC9nPg0KICAgICAgICA8L2c+DQogICAgPC9nPg0KPC9zdmc+"><span
                                    class="title" _v-173f9211="">设计</span></div>
                        <div class="channel-item" _v-173f9211=""><img class="icon" _v-173f9211=""
                                                                      src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIyN3B4IiBoZWlnaHQ9IjI3cHgiIHZpZXdCb3g9IjAgMCAyNyAyNyIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5wcm9kdWN0PC90aXRsZT4NCiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggc2tldGNodG9vbC48L2Rlc2M+DQogICAgPGRlZnM+PC9kZWZzPg0KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPg0KICAgICAgICA8ZyBpZD0ianVlamluX2Nocm9tZV9leHRlbnNpb25fZm9udC1lbmQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMjE1LjAwMDAwMCwgLTIwOC4wMDAwMDApIj4NCiAgICAgICAgICAgIDxnIGlkPSJHcm91cC0rLWFuZHJvaWQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEyMTUuMDAwMDAwLCAyMDguMDAwMDAwKSI+DQogICAgICAgICAgICAgICAgPGcgaWQ9Ikdyb3VwIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg0Ljk3MzY4NCwgNS42ODQyMTEpIj4NCiAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTMuNjMyNjUyNjMsNS44NjcwOTQ4MSBDMy41ODAwODM5OSw1LjU3NzI2MDU5IDMuNTUyNjMxNTgsNS4yNzg2NzgzMyAzLjU1MjYzMTU4LDQuOTczNjg0MjEgQzMuNTUyNjMxNTgsMi4yMjY3OTQyNyA1Ljc3OTQyNTg1LDAgOC41MjYzMTU3OSwwIEMxMS4yNzMyMDU3LDAgMTMuNSwyLjIyNjc5NDI3IDEzLjUsNC45NzM2ODQyMSBDMTMuNSw1LjI3ODY3ODMzIDEzLjQ3MjU0NzYsNS41NzcyNjA1OSAxMy40MTk5NzksNS44NjcwOTQ4MSBDMTUuNTE1NDYxNCw2LjQ1MjQzMDk0IDE3LjA1MjYzMTYsOC4zNzU2NTAxOCAxNy4wNTI2MzE2LDEwLjY1Nzg5NDcgQzE3LjA1MjYzMTYsMTMuNDA0Nzg0NyAxNC44MjU4MzczLDE1LjYzMTU3ODkgMTIuMDc4OTQ3NCwxNS42MzE1Nzg5IEMxMC42ODcyNDc5LDE1LjYzMTU3ODkgOS40MjkwNTE1OCwxNS4wNTk5ODM4IDguNTI2MzE1NzksMTQuMTM4NzUwOSBDNy42MjM1OCwxNS4wNTk5ODM4IDYuMzY1MzgzNywxNS42MzE1Nzg5IDQuOTczNjg0MjEsMTUuNjMxNTc4OSBDMi4yMjY3OTQyNywxNS42MzE1Nzg5IDAsMTMuNDA0Nzg0NyAwLDEwLjY1Nzg5NDcgQzAsOC4zNzU2NTAxOCAxLjUzNzE3MDE0LDYuNDUyNDMwOTQgMy42MzI2NTI2Myw1Ljg2NzA5NDgxIFoiIGlkPSJPdmFsLTM1NCIgZmlsbD0iI0VBRjNGRCI+PC9wYXRoPg0KICAgICAgICAgICAgICAgICAgICA8Y2lyY2xlIGlkPSJPdmFsLTM1NCIgc3Ryb2tlPSIjMDA3RkZGIiBzdHJva2Utd2lkdGg9IjAuNzIiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIGN4PSI4LjUyNjMxNTc5IiBjeT0iNC45NzM2ODQyMSIgcj0iNC45NzM2ODQyMSI+PC9jaXJjbGU+DQogICAgICAgICAgICAgICAgICAgIDxlbGxpcHNlIGlkPSJPdmFsLTM1NC1Db3B5IiBzdHJva2U9IiMwMDdGRkYiIHN0cm9rZS13aWR0aD0iMC43MiIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY3g9IjEyLjA3ODk0NzQiIGN5PSIxMC42NTc4OTQ3IiByeD0iNC45NzM2ODQyMSIgcnk9IjQuOTczNjg0MjEiPjwvZWxsaXBzZT4NCiAgICAgICAgICAgICAgICAgICAgPGNpcmNsZSBpZD0iT3ZhbC0zNTQtQ29weS0yIiBzdHJva2U9IiMwMDdGRkYiIHN0cm9rZS13aWR0aD0iMC43MiIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY3g9IjQuOTczNjg0MjEiIGN5PSIxMC42NTc4OTQ3IiByPSI0Ljk3MzY4NDIxIj48L2NpcmNsZT4NCiAgICAgICAgICAgICAgICA8L2c+DQogICAgICAgICAgICA8L2c+DQogICAgICAgIDwvZz4NCiAgICA8L2c+DQo8L3N2Zz4="><span
                                    class="title" _v-173f9211="">产品</span></div>
                        <div class="channel-item" _v-173f9211=""><img class="icon" _v-173f9211=""
                                                                      src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIyN3B4IiBoZWlnaHQ9IjI3cHgiIHZpZXdCb3g9IjAgMCAyNyAyNyIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5pb3M8L3RpdGxlPg0KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBza2V0Y2h0b29sLjwvZGVzYz4NCiAgICA8ZGVmcz48L2RlZnM+DQogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+DQogICAgICAgIDxnIGlkPSJqdWVqaW5fY2hyb21lX2V4dGVuc2lvbl9mb250LWVuZCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEyMTUuMDAwMDAwLCAtMjUwLjAwMDAwMCkiIHN0cm9rZT0iIzAwN0ZGRiIgc3Ryb2tlLXdpZHRoPSIwLjcyIiBmaWxsPSIjRTlGM0ZEIj4NCiAgICAgICAgICAgIDxnIGlkPSJwYXRoMTg4LSstYW5kcm9pZCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTIxNS4wMDAwMDAsIDI1MC4wMDAwMDApIj4NCiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTcuMzE0Mjc5NCwzLjU1MjYzMTU4IEMxNi4zNDkxOTcxLDMuNTkxMzYzMDEgMTUuMTgxMDU0Myw0LjE5NTQ5NTggMTQuNDg4MTEzLDUuMDA2NzY4MTQgQzEzLjg2Nzc2NjQsNS43MjM3NjU4NyAxMy4zMjM3MjQ2LDYuODcyODAxODggMTMuNDcxMTg5MSw3Ljk3NDI4MDkgQzE0LjU0NzQ5MjQsOC4wNTc3MDYzOCAxNS42NDY2MDE0LDcuNDI2NjYxNjIgMTYuMzE2NjQ2OCw2LjYxNjU4MTg3IEMxNi45ODY1ODE3LDUuODA1MzA5NTEgMTcuNDM4ODQ3Nyw0LjY3NzAwMjIgMTcuMzE0Mjc5NCwzLjU1MjYzMTU4IEwxNy4zMTQyNzk0LDMuNTUyNjMxNTggWiBNMTYuOTQ3MDU2OCw4LjE3NjExMDU4IEMxNS41ODM4NzcsOC4xOTQ0OTM1MiAxNC4zMjA2MzgzLDkuMDcwMjIxOTMgMTMuNjIyNzYzMSw5LjA3MDIyMTkzIEMxMi44NjU3NDYyLDkuMDcwMjIxOTMgMTEuNjk1MjQ4NCw4LjIxMzIzNTk2IDEwLjQ1NjkzMzMsOC4yMzc0MTY5NSBDOC44MjY4MDcxNCw4LjI2MTU5Nzk1IDcuMzI2MzIwODYsOS4xODQwMjkxNiA2LjQ4NzA3MTk3LDEwLjY0MjE0OTkgQzQuNzk1MjcyMDEsMTMuNTc2NTI3MiA2LjA1NTM2Mzk1LDE3LjkyNTM5NDEgNy43MDI0MTk5OCwyMC4zMDcyMzMzIEM4LjUwOTAxNzk3LDIxLjQ3MTU1MzQgOS40NjkzMzIyNCwyMi43ODMwNTk4IDEwLjczMTgzMzUsMjIuNzM0Njk3NyBDMTEuOTQ4MzgxNiwyMi42ODYzMzU1IDEyLjQwNzUzNTIsMjEuOTQ5NDIyNCAxMy44NzU2MTYxLDIxLjk0OTQyMjQgQzE1LjM0MzY5NywyMS45NDk0MjI0IDE1Ljc1NzM0NjQsMjIuNzM0OTM3OSAxNy4wNDI4MjQsMjIuNzExOTY2IEMxOC4zNTAwNjkzLDIyLjY4NjU3NTcgMTkuMTgwMDUyNCwyMS41MjIwMjE3IDE5Ljk4MDYwNDEsMjAuMzU0MDc0IEMyMC45MDQ1MDM0LDE5LjAwMjM1MDQgMjEuMjg2NDg3MywxNy42OTQ1MDM2IDIxLjMwODI1NDcsMTcuNjI1NTg3NCBDMjEuMjc5MjMxNiwxNy42MTM0OTcgMTguNzU4Nzg5OSwxNi42NDc2MTczIDE4LjczMjE4NTQsMTMuNzQ0Njc1NCBDMTguNzEwNDE4NCwxMS4zMTY4OTIzIDIwLjcxNTI5NjYsMTAuMTUxMzQ5NiAyMC44MDU5OTM0LDEwLjA5NDUyMzggQzE5LjY3NzcyMzksOC40NDQxNjMyIDE3LjkyMjA5MDYsOC4yMTc4NjQzNSAxNy4yOTU2NzcyLDguMTkxMjY0ODcgQzE3LjE3ODk5OTQsOC4xNzk0NTc2OSAxNy4wNjI1ODA1LDguMTc0NTUyNDggMTYuOTQ3MDU2OCw4LjE3NjExMDU4IEwxNi45NDcwNTY4LDguMTc2MTEwNTggWiIgaWQ9InBhdGgxODgiPjwvcGF0aD4NCiAgICAgICAgICAgIDwvZz4NCiAgICAgICAgPC9nPg0KICAgIDwvZz4NCjwvc3ZnPg=="><span
                                    class="title" _v-173f9211="">iOS</span></div>
                        <div class="channel-item" _v-173f9211=""><img class="icon" _v-173f9211=""
                                                                      src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIyN3B4IiBoZWlnaHQ9IjI3cHgiIHZpZXdCb3g9IjAgMCAyNyAyNyIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjcuMSAoMjgyMTUpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT4zNDJFQzg3Ny1DNUQ1LTQzNEQtQTgwMi1GQUFBMzc1OTZCQTY8L3RpdGxlPg0KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBza2V0Y2h0b29sLjwvZGVzYz4NCiAgICA8ZGVmcz4NCiAgICAgICAgPHBhdGggZD0iTTQsNi43MjM0ODExOCBDNCw2LjMyMzkxMzU2IDQuMzI5NzgwNTgsNiA0LjcyMTYyMTUxLDYgTDIyLjI3ODM3ODUsNiBDMjIuNjc2OTE5LDYgMjMsNi4zMTMyOTYzMiAyMyw2LjcyMzQ4MTE4IEwyMywyMC4yNzY1MTg4IEMyMywyMC42NzYwODY0IDIyLjY3MDIxOTQsMjEgMjIuMjc4Mzc4NSwyMSBMNC43MjE2MjE1MSwyMSBDNC4zMjMwODA5NiwyMSA0LDIwLjY4NjcwMzcgNCwyMC4yNzY1MTg4IEw0LDYuNzIzNDgxMTggWiIgaWQ9InBhdGgtMSI+PC9wYXRoPg0KICAgICAgICA8bWFzayBpZD0ibWFzay0yIiBtYXNrQ29udGVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgbWFza1VuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeD0iLTEiIHk9Ii0xIiB3aWR0aD0iMjEiIGhlaWdodD0iMTciPg0KICAgICAgICAgICAgPHJlY3QgeD0iMyIgeT0iNSIgd2lkdGg9IjIxIiBoZWlnaHQ9IjE3IiBmaWxsPSJ3aGl0ZSI+PC9yZWN0Pg0KICAgICAgICAgICAgPHVzZSB4bGluazpocmVmPSIjcGF0aC0xIiBmaWxsPSJibGFjayI+PC91c2U+DQogICAgICAgIDwvbWFzaz4NCiAgICA8L2RlZnM+DQogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+DQogICAgICAgIDxnIGlkPSJqdWVqaW5fY2hyb21lX2V4dGVuc2lvbl9kZXNpZ25lciIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEyMTUuMDAwMDAwLCAtMTkuMDAwMDAwKSI+DQogICAgICAgICAgICA8ZyBpZD0iR3JvdXAtNSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTIxNS4wMDAwMDAsIDE5LjAwMDAwMCkiPg0KICAgICAgICAgICAgICAgIDxnIGlkPSJSZWN0YW5nbGUtOTcxLSstZnJvbnRlbmQtKy0mbHQ7LyZndDsiPg0KICAgICAgICAgICAgICAgICAgICA8ZyBpZD0iUmVjdGFuZ2xlLTk3MSI+DQogICAgICAgICAgICAgICAgICAgICAgICA8dXNlIGZpbGw9IiNFOUYzRkQiIGZpbGwtcnVsZT0iZXZlbm9kZCIgeGxpbms6aHJlZj0iI3BhdGgtMSI+PC91c2U+DQogICAgICAgICAgICAgICAgICAgICAgICA8dXNlIHN0cm9rZT0iIzAwN0ZGRiIgbWFzaz0idXJsKCNtYXNrLTIpIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHhsaW5rOmhyZWY9IiNwYXRoLTEiPjwvdXNlPg0KICAgICAgICAgICAgICAgICAgICA8L2c+DQogICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik02LjUwNDc4MTQyLDEzLjAwMjczMjIgTDYuNTA0NzgxNDIsMTMuNjMzODc5OCBMMTAuOTcwNjI4NCwxNS44MjM3NzA1IEwxMC45NzA2Mjg0LDE1LjEwNjU1NzQgTDcuMjUwNjgzMDYsMTMuMzE4MzA2IEwxMC45NzA2Mjg0LDExLjUyMDQ5MTggTDEwLjk3MDYyODQsMTAuODAzMjc4NyBMNi41MDQ3ODE0MiwxMy4wMDI3MzIyIFogTTExLjk3NDcyNjgsMTcgTDEyLjY3MjgxNDIsMTcgTDE1LjAxNTcxMDQsMTAgTDE0LjMyNzE4NTgsMTAgTDExLjk3NDcyNjgsMTcgWiBNMTYuMDI5MzcxNiwxMC44MDMyNzg3IEwxNi4wMjkzNzE2LDExLjUyMDQ5MTggTDE5LjczOTc1NDEsMTMuMzE4MzA2IEwxNi4wMjkzNzE2LDE1LjEwNjU1NzQgTDE2LjAyOTM3MTYsMTUuODIzNzcwNSBMMjAuNDk1MjE4NiwxMy42MzM4Nzk4IEwyMC40OTUyMTg2LDEzLjAwMjczMjIgTDE2LjAyOTM3MTYsMTAuODAzMjc4NyBaIiBpZD0iJmx0Oy8mZ3Q7IiBmaWxsPSIjMDA3RkZGIj48L3BhdGg+DQogICAgICAgICAgICAgICAgPC9nPg0KICAgICAgICAgICAgPC9nPg0KICAgICAgICA8L2c+DQogICAgPC9nPg0KPC9zdmc+"><span
                                    class="title" _v-173f9211="">前端</span></div>
                        <div class="channel-item" _v-173f9211=""><img class="icon" _v-173f9211=""
                                                                      src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+DQo8c3ZnIHdpZHRoPSIyN3B4IiBoZWlnaHQ9IjI3cHgiIHZpZXdCb3g9IjAgMCAyNyAyNyIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj4NCiAgICA8IS0tIEdlbmVyYXRvcjogc2tldGNodG9vbCAzLjYuMSAoMjYzMTMpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPg0KICAgIDx0aXRsZT5iYWNrZW5kPC90aXRsZT4NCiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggc2tldGNodG9vbC48L2Rlc2M+DQogICAgPGRlZnM+PC9kZWZzPg0KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPg0KICAgICAgICA8ZyBpZD0ianVlamluX2Nocm9tZV9leHRlbnNpb25fZm9udC1lbmQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMjE1LjAwMDAwMCwgLTI5NC4wMDAwMDApIiBzdHJva2U9IiMwMDdGRkYiIHN0cm9rZS13aWR0aD0iMC43MiIgZmlsbD0iI0U5RjNGRCI+DQogICAgICAgICAgICA8ZyBpZD0iT3ZhbC0zNjAtQ29weS0rLU92YWwtMzYwLUNvcHktQ29weS0rLU92YWwtMzYwLUNvcHktKy1PdmFsLTM2MC1Db3B5LSstT3ZhbC0zNjAtQ29weS0rLU92YWwtMzYwLSstZnJvbnRlbmQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEyMTUuMDAwMDAwLCAyOTQuMDAwMDAwKSI+DQogICAgICAgICAgICAgICAgPGcgaWQ9Ik92YWwtMzYwLUNvcHktKy1PdmFsLTM2MC1Db3B5LUNvcHktKy1PdmFsLTM2MC1Db3B5LSstT3ZhbC0zNjAtQ29weS0rLU92YWwtMzYwLUNvcHktKy1PdmFsLTM2MCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNy4xMDUyNjMsIDUuNjg0MjExKSI+DQogICAgICAgICAgICAgICAgICAgIDxnIGlkPSJPdmFsLTM2MC1Db3B5LSstT3ZhbC0zNjAtQ29weS1Db3B5IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjAwMDAwMCwgNy4xMDUyNjMpIj4NCiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik02LjM5NDczNjg0LDcuODE1Nzg5NDcgQzkuOTI2NDUyNDgsNy44MTU3ODk0NyAxMi43ODk0NzM3LDYuOTQwOTc3NDQgMTIuNzg5NDczNyw1Ljg2MTg0MjExIEwxMi43ODk0NzM3LDIuMzQ0NzM2ODQgQzEyLjc4OTQ3MzcsMi4zNDQ3MzY4NCAwLDIuMzQ0NzM2ODQgMCwyLjM0NDczNjg0IEwwLDUuODYxODQyMTEgQzAsNi45NDA5Nzc0NCAyLjg2MzAyMTIxLDcuODE1Nzg5NDcgNi4zOTQ3MzY4NCw3LjgxNTc4OTQ3IFoiIGlkPSJPdmFsLTM2MC1Db3B5IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik02LjM5NDczNjg0LDMuOTA3ODk0NzQgQzkuOTI2NDUyNDgsMy45MDc4OTQ3NCAxMi43ODk0NzM3LDMuMDMzMDgyNyAxMi43ODk0NzM3LDEuOTUzOTQ3MzcgQzEyLjc4OTQ3MzcsMC44NzQ4MTIwMzUgOS45MjY0NTI0OCw4LjY3NzI2OTQzZS0xNyA2LjM5NDczNjg0LDguNjc3MjY5NDNlLTE3IEMyLjg2MzAyMTIxLDguNjc3MjY5NDNlLTE3IDAsMC44NzQ4MTIwMzUgMCwxLjk1Mzk0NzM3IEMwLDMuMDMzMDgyNyAyLjg2MzAyMTIxLDMuOTA3ODk0NzQgNi4zOTQ3MzY4NCwzLjkwNzg5NDc0IFoiIGlkPSJPdmFsLTM2MCI+PC9wYXRoPg0KICAgICAgICAgICAgICAgICAgICA8L2c+DQogICAgICAgICAgICAgICAgICAgIDxnIGlkPSJPdmFsLTM2MC1Db3B5LSstT3ZhbC0zNjAtQ29weSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC4wMDAwMDAsIDMuNTUyNjMyKSI+DQogICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNi4zOTQ3MzY4NCw3LjgxNTc4OTQ3IEM5LjkyNjQ1MjQ4LDcuODE1Nzg5NDcgMTIuNzg5NDczNyw2Ljk0MDk3NzQ0IDEyLjc4OTQ3MzcsNS44NjE4NDIxMSBMMTIuNzg5NDczNywyLjM0NDczNjg0IEMxMi43ODk0NzM3LDIuMzQ0NzM2ODQgMCwyLjM0NDczNjg0IDAsMi4zNDQ3MzY4NCBMMCw1Ljg2MTg0MjExIEMwLDYuOTQwOTc3NDQgMi44NjMwMjEyMSw3LjgxNTc4OTQ3IDYuMzk0NzM2ODQsNy44MTU3ODk0NyBaIiBpZD0iT3ZhbC0zNjAtQ29weSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48L3BhdGg+DQogICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNNi4zOTQ3MzY4NCwzLjkwNzg5NDc0IEM5LjkyNjQ1MjQ4LDMuOTA3ODk0NzQgMTIuNzg5NDczNywzLjAzMzA4MjcgMTIuNzg5NDczNywxLjk1Mzk0NzM3IEMxMi43ODk0NzM3LDAuODc0ODEyMDM1IDkuOTI2NDUyNDgsOC42NzcyNjk0M2UtMTcgNi4zOTQ3MzY4NCw4LjY3NzI2OTQzZS0xNyBDMi44NjMwMjEyMSw4LjY3NzI2OTQzZS0xNyAwLDAuODc0ODEyMDM1IDAsMS45NTM5NDczNyBDMCwzLjAzMzA4MjcgMi44NjMwMjEyMSwzLjkwNzg5NDc0IDYuMzk0NzM2ODQsMy45MDc4OTQ3NCBaIiBpZD0iT3ZhbC0zNjAiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICAgICAgPC9nPg0KICAgICAgICAgICAgICAgICAgICA8ZyBpZD0iT3ZhbC0zNjAtQ29weS0rLU92YWwtMzYwIj4NCiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik02LjM5NDczNjg0LDcuODE1Nzg5NDcgQzkuOTI2NDUyNDgsNy44MTU3ODk0NyAxMi43ODk0NzM3LDYuOTQwOTc3NDQgMTIuNzg5NDczNyw1Ljg2MTg0MjExIEwxMi43ODk0NzM3LDIuMzQ0NzM2ODQgQzEyLjc4OTQ3MzcsMi4zNDQ3MzY4NCAwLDIuMzQ0NzM2ODQgMCwyLjM0NDczNjg0IEwwLDUuODYxODQyMTEgQzAsNi45NDA5Nzc0NCAyLjg2MzAyMTIxLDcuODE1Nzg5NDcgNi4zOTQ3MzY4NCw3LjgxNTc4OTQ3IFoiIGlkPSJPdmFsLTM2MC1Db3B5IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjwvcGF0aD4NCiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik02LjM5NDczNjg0LDMuOTA3ODk0NzQgQzkuOTI2NDUyNDgsMy45MDc4OTQ3NCAxMi43ODk0NzM3LDMuMDMzMDgyNyAxMi43ODk0NzM3LDEuOTUzOTQ3MzcgQzEyLjc4OTQ3MzcsMC44NzQ4MTIwMzUgOS45MjY0NTI0OCw4LjY3NzI2OTQzZS0xNyA2LjM5NDczNjg0LDguNjc3MjY5NDNlLTE3IEMyLjg2MzAyMTIxLDguNjc3MjY5NDNlLTE3IDAsMC44NzQ4MTIwMzUgMCwxLjk1Mzk0NzM3IEMwLDMuMDMzMDgyNyAyLjg2MzAyMTIxLDMuOTA3ODk0NzQgNi4zOTQ3MzY4NCwzLjkwNzg5NDc0IFoiIGlkPSJPdmFsLTM2MCI+PC9wYXRoPg0KICAgICAgICAgICAgICAgICAgICA8L2c+DQogICAgICAgICAgICAgICAgPC9nPg0KICAgICAgICAgICAgPC9nPg0KICAgICAgICA8L2c+DQogICAgPC9nPg0KPC9zdmc+"><span
                                    class="title" _v-173f9211="">后端</span></div>
                    </div>
                </div>
                <button class="start-btn" _v-173f9211="" disabled="">开始</button>
            </div>
        </div>
    </div>
</div>

<script>
    function change(){
        layer.load(1);
        <?php $urli = \yii\helpers\Url::to(['index/index','i'=>1]);?>
        location.href = '<?php echo $urli;?>'+'&type='+$('select[name=type]').val();
    }
</script>
</body>
</html>
<!--endregion-->