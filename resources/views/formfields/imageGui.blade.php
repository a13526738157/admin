@if(isset($dataTypeContent->{$row->field}))
    <input type="hidden" name="{{$row->field }}" value="{{ $dataTypeContent->{$row->field} }}" />
@else
    <input type="hidden" name="{{$row->field }}" value="" />
@endif
<input type="file" id="input-{{ $row->field }}" multiple class="file-loading" />
<script>
    <?$imgs = explode(',',$dataTypeContent->{$row->field});    ?>
    $(function () {
//0.初始化fileinput
        var oFileInput = new FileInput();
        oFileInput.Init("{{$row->field}}", "/api/file/uploadPics/{{$dataType->slug}}/{{$row->field}}");
    });
    //初始化fileinput
    var FileInput = function () {
        var oFile = new Object();
        //初始化fileinput控件（第一次初始化）
        oFile.Init = function(ctrlName, uploadUrl) {
            var control = $('#input-' + ctrlName);
            //初始化上传控件的样式
            control.fileinput({
                language: 'zh', //设置语言
                uploadUrl: uploadUrl, //上传的地址
                allowedFileExtensions: ['jpg', 'gif', 'png','jpeg'],//接收的文件后缀
                showUpload: true, //是否显示上传按钮
                showCaption: false,//是否显示标题
                browseClass: "btn btn-primary", //按钮样式
                dropZoneEnabled: true,//是否显示拖拽区域
                showRemove : false,
                overwriteInitial:false,
                initialPreviewAsData: true,
                //uploadAsync: true, //默认异步上传
                //minImageWidth: 50, //图片的最小宽度
                //minImageHeight: 50,//图片的最小高度
                //maxImageWidth: 1000,//图片的最大宽度
                //maxImageHeight: 1000,//图片的最大高度
                maxFileSize: 10240,//单位为kb，如果为0表示不限制文件大小
                //minFileCount: 0,
                maxFileCount: 10, //表示允许同时上传的最大文件个数
                enctype: 'multipart/form-data',
                validateInitialCount:true,
                previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
                msgFilesTooMany: "选择上传的文件数量({n}) 超过允许的最大数值{m}！"
                @if($imgs[0])
                ,
                initialPreview : [ // 预览图片的设置
                    @foreach($imgs as $k=>$i)
                        @if($k!=0)
                    ,
                    @endif
                    '{{ Voyager::image($i) }}'
                    @endforeach
                ]
                @endif
            });
            //上传完成之后的事件
            $('#input-' + ctrlName).on("fileuploaded", function (event, data, previewId, index) {
                var data = data.response;

                if (data.status != 1) {
                    toastr.error('上传错误');
                }else{
                    var _val = $('[name={{$row->field}}]').val();
                    if(!_val.trim()){
                        _val = data.path;
                    }else{
                        _val += ','+data.path
                    }
                    $('[name={{$row->field}}]').val(_val)
                }
                return;
            });
            $('#input-'+ctrlName).on('filesuccessremove',function (event,id) {
                console.log(event)
            })
        }
        return oFile
    }
</script>
