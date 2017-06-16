@if(isset($dataTypeContent->{$row->field}))
    <img src="{{ Voyager::image($dataTypeContent->{$row->field}) }}"
         style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" id="img-{{$row->field}}">
@else
    <img src="{{ voyager_asset('images/default.jpeg') }}"
         style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" id="img-{{$row->field}}">
@endif
<input type="file" name="{{ $row->field }}"  style="display: none" id="{{ $row->field }}-file">
<button type="button" onclick="$('#{{$row->field}}-file').click();" class="btn btn-sm btn-primary">@lang('voyager.UploadImg')</button>
<script>
    $('#{{$row->field}}-file').on('change',function (e) {
        var imgObjPreview1=document.getElementById("img-{{$row->field}}")
        if($(this)[0].files[0])
            imgObjPreview1.src =window.URL.createObjectURL($(this)[0].files[0]);
    })
</script>