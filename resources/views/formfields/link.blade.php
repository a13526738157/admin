<script>
    var link{{$row->field}}Type = 'Https';
</script>
<div class="input-group">
    <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="choseLink{{$row->field}}" style="margin-top:0;margin-bottom:0;padding-bottom: 5%">https:// <span class="caret"></span></button>
        <ul class="dropdown-menu" id="btnLink{{$row->field}}">
            <li><a href="javascript:void(0)">http://</a></li>
            <li><a href="javascript:void(0)">https://</a></li>
            <li><a href="javascript:void(0)">ftp://</a></li>
        </ul>
    </div><!-- /btn-group -->
    <input type="text" class="form-control" id="link-{{$row->field}}" placeholder="{{ isset($options->placeholder)? old($row->field, $options->placeholder): $row->display_name }}"
           {!! isBreadSlugAutoGenerator($options) !!}
           value="@if(isset($dataTypeContent->{$row->field})){{ str_replace(['https://','http://','ftp://'],'',old($row->field, $dataTypeContent->{$row->field})) }}@elseif(isset($options->default)){{ old($row->field, $options->default) }}@else{{ old($row->field) }}@endif" aria-describedby="basic-{{$row->field}}" @if(isset($options->property)){{$options->property}}@endif>
</div><!-- /input-group -->
<input type="hidden"  class="form-control" id="link-{{$row->field}}-real" name="{{ $row->field }}"
       placeholder="{{ isset($options->placeholder)? old($row->field, $options->placeholder): $row->display_name }}"
       {!! isBreadSlugAutoGenerator($options) !!}
       value="@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@elseif(isset($options->default)){{ old($row->field, $options->default) }}@else{{ old($row->field) }}@endif" aria-describedby="basic-{{$row->field}}" @if(isset($options->property)){{$options->property}}@endif/>
<script>
    $('#link-{{$row->field}}').on('keyup',function (e) {
        var _val = link{{$row->field}}Type+$(this).val();
        $('#link-{{$row->field}}-real').val(_val);
    })
    $('#btnLink{{$row->field}} li').on('click',function (e) {
        link{{$row->field}}Type = $(this).find('a').text();
        var _val = link{{$row->field}}Type+$('#link-{{$row->field}}').val();
        $('#choseLink{{$row->field}}').html(link{{$row->field}}Type+'<span class="caret"></span>')
        $('#link-{{$row->field}}-real').val(_val);
    })
</script>