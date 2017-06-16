@if(isset($dataTypeContent->{$row->field}))
@endif
<div class="input-group">
    <span class="input-group-addon" id="basic-{{$row->field}}"><i class="glyphicon glyphicon-lock"></i></span>
    <input type="password" class="form-control" name="{{ $row->field }}" value="" aria-describedby="basic-{{$row->field}}">
</div>
<small>@lang('voyager.Leave empty to keep the same')</small>

