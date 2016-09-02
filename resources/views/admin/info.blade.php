@extends('admin.master')

@section('content')



    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: k__middle;
        }

        .content {
            text-align: left;
            display: inline-block;
        }

        .title {
            font-size: 30px;
        }
    </style>


<div class="container">
    <div class="content">
        <div class="title"><div class="panel-body">
                <div class="result_wrap">
                    <div class="result_title">
                        <h3>系统基本信息</h3>
                    </div>
                    <div class="result_content">
                        <ul>
                            <li>
                                <label>操作系统</label><span>{{PHP_OS}}</span>
                            </li>
                            <li>
                                <label>运行环境</label><span>{{$_SERVER ['SERVER_SOFTWARE']}}</span>
                            </li>
                            <li>
                                <label>PHP运行方式</label><span>apache2handler</span>
                            </li>
                            <li>
                                <label>版本</label><span>v-1.0</span>
                            </li>
                            <li>
                                <label>上传附件限制</label><span><?PHP echo get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件"; ?></span>
                            </li>
                            <li>
                                <label>北京时间</label><span><?php echo date('Y年m月d日 H时i分s秒');?></span>
                            </li>
                            <li>
                                <label>服务器域名/IP</label><span>{{$_SERVER['SERVER_NAME']}} [ {{$_SERVER['SERVER_ADDR']}} ]</span>
                            </li>
                            <li>
                                <label>Host</label><span>{{$_SERVER['SERVER_ADDR']}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div></div>
    </div>
</div>
@endsection





