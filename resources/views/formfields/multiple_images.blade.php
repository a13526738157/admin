<br>
@if(isset($dataTypeContent->{$row->field}))
    <?php $images = json_decode($dataTypeContent->{$row->field}); ?>
    <div id="imgMutipleDiv-{{$row->field}}">
    @if($images != null)
        @foreach($images as $image)
            <div class="img_settings_container" data-field-name="{{ $row->field }}" style="position: relative;width: 200px;display: inline-block">
                <img src="{{ Voyager::image( $image ) }}" data-image="{{ $image }}" data-id="{{ $dataTypeContent->id }}" height="200" width="200">
                <div style="display: block;position: absolute;right: 0;top: 0;color: red;
                    width: 0;height: 0;border-top: 40px solid orange;border-left: 40px solid transparent;">

                </div>
                <a href="#" class="remove-multi-image" style="color:red">
                    <i class="glyphicon glyphicon-trash" style="right: 5px;top:5px;position: absolute"></i>
                </a>
            </div>
        @endforeach
    @endif
    </div>
@endif
<div class="clearfix"></div>
<input type="file" name="{{ $row->field }}[]" multiple="multiple" style="display: none" id="mutiple-img-{{$row->field}}" maxlength="1" accept="image/png,image/gif,image/jpeg,image/jpg">
<button class="btn btn-info" onclick="$('#mutiple-img-{{$row->field}}').click()" type="button">多图上传</button>
<script>
    @if(isset($options->maxLength))
        var maxError = "{{trans('voyager.ImgisMax',['length',$options->maxLength])}}";
        var maxLength = {{(int)$options->maxLength}};
    @endif
    @if(isset($options->minLength))
        var minError = "{{trans('voyager.ImgisMin',['length',$options->minLength])}}";
        var minLength = {{(int)$options->minLength}};
    @endif
    $('#mutiple-img-{{$row->field}}').on('change',function (e) {
        var l = $(this)[0].files.length+$('[data-field-name={{ $row->field }}]').length;
        var obj = document.getElementById('mutiple-img-{{$row->field}}') ;
        @if(isset($options->maxLength))
            if(l>maxLength){
                    obj.outerHTML=obj.outerHTML;
                    toastr.error(maxError);
                    console.log($(this))
                    return false;
                }
        @endif
        @if(isset($options->minLength))
            if(l<minLength){
                    obj.outerHTML=obj.outerHTML;
                    toastr.error(minError);
                    console.log($(this))
                    return false;
                }
        @endif
        //var imgObjPreview1=document.getElementById("img-{{$row->field}}")
        //if($(this)[0].files[0])
            //imgObjPreview1.src =window.URL.createObjectURL($(this)[0].files[0]);
        $('.img_upload_{{$row->field}}').remove();
        str = '';
        for (var i in $(this)[0].files){
            if(i=='length' || i=='item'){
                continue
            }
            var _url = window.URL.createObjectURL($(this)[0].files[i]);
            str += '<div class="img_settings_container img_upload_{{$row->field}}" style="position: relative;width: 200px;display: inline-block">';
            str += '<img src="'+_url+'" height="200" width="200"/>';
            str += '</div>';
        }
        $('#imgMutipleDiv-{{$row->field}}').append(str);
    })
</script>

