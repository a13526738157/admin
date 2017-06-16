@extends('voyager::master')

@section('page_title',trans('voyager.All').$dataType->display_name_plural)

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        @if (Voyager::can('add_'.$dataType->name))
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success">
                <i class="voyager-plus"></i> {{trans('voyager.Add New')}}
            </a>
        @endif
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body table-responsive">
                        <table id="dataTable" class="row table table-hover">
                            <thead>
                                <tr>
                                    @foreach($dataType->browseRows as $rows)
                                    <th>{{ $rows->display_name }}</th>
                                    @endforeach
                                    <th class="actions">{{trans('voyager.Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($dataTypeContent as $data)
                                <tr>
                                    @foreach($dataType->browseRows as $row)
                                        <td>
                                            <?php $options = json_decode($row->details);?>


                                            @if($row->type == 'image')
                                                <img src="@if( strpos($data->{$row->field}, 'http://') === false && strpos($data->{$row->field}, 'https://') === false){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                            @elseif($row->type == 'multiple_images')
                                                    @php $pics = json_decode($data->{$row->field},true); @endphp
                                                    @if($pics)
                                                    <img class="img-responsive"
                                                         src="{{ Voyager::image($pics[0]) }}" style="display: inline-block;width: 100px;height: 100px">
                                                    @endif
                                            @elseif($row->type == 'select_multiple')
                                                @if(property_exists($options, 'relationship'))

                                                    @foreach($data->{$row->field} as $item)
                                                        @if($item->{$row->field . '_page_slug'})
                                                            <a href="{{ $item->{$row->field . '_page_slug'} }}">{{ $item->{$row->field} }}</a>@if(!$loop->last), @endif
                                                        @else
                                                            {{ $item->{$row->field} }}
                                                        @endif
                                                    @endforeach

                                                    {{-- $data->{$row->field}->implode($options->relationship->label, ', ') --}}
                                                @elseif(property_exists($options, 'options'))
                                                    @foreach($data->{$row->field} as $item)
                                                        {{ $options->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                    @endforeach
                                                @endif
                                            @elseif($row->type == 'select_dropdown' && isset($options->relationship))
                                                @if( !method_exists( $dataType->model_name, camel_case($row->field) ) )
                                                    <p class="label label-warning"><i class="voyager-warning"></i> Make sure to setup the appropriate relationship in the {{ camel_case($row->field) . '()' }} method of the {{ $dataType->model_name }} class.</p>
                                                @else
                                                    <?php
                                                    $relationshipListMethod = camel_case($row->field) . 'List';
                                                    if (method_exists($data, $relationshipListMethod)) {
                                                        $relationshipOptions = $dataTypeContent->$relationshipListMethod();
                                                    } else {
                                                        $relationshipClass = $data->{camel_case($row->field)}()->getRelated();

                                                        if (isset($options->relationship->where)) {
                                                            $relationshipOptions = $relationshipClass::where(
                                                                $options->relationship->where[0],
                                                                $options->relationship->where[1]
                                                            )->get();
                                                        } else {
                                                            $relationshipOptions = $relationshipClass::where(
                                                                $options->relationship->key,$data->{$row->field}
                                                            )->first();
                                                        }
                                                    }
                                                    ?>
                                                    {{ $relationshipOptions->{$options->relationship->label} }}
                                                @endif
                                            @elseif($row->type == 'select_dropdown' && isset($options->relationship->options))
                                                @php $badgeClass = $data->{$row->field}?'badge-success':'badge-danger';@endphp
                                                <i class="badge {{$badgeClass}}">{{ $options->relationship->options->{ $data->{$row->field} } }}</i>
                                            @elseif($row->type == 'date')
                                                {{ $options && property_exists($options, 'format') ? \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($options->format) : $data->{$row->field} }}
                                            @elseif($row->type == 'checkbox')
                                                @if($options && property_exists($options, 'on') && property_exists($options, 'off'))
                                                    @if($data->{$row->field})
                                                        <span class="label label-info">{{ $options->on }}</span>
                                                    @else
                                                        <span class="label label-primary">{{ $options->off }}</span>
                                                    @endif
                                                @else
                                                    {{ $data->{$row->field} }}
                                                @endif
                                            @elseif($row->type == 'radio_btn' && isset($options->relationship))
                                                @if( !method_exists( $dataType->model_name, camel_case($row->field) ) )
                                                    <p class="label label-warning"><i class="voyager-warning"></i> Make sure to setup the appropriate relationship in the {{ camel_case($row->field) . '()' }} method of the {{ $dataType->model_name }} class.</p>
                                                @else
                                                    <?php
                                                    $relationshipListMethod = camel_case($row->field) . 'List';
                                                    if (method_exists($data, $relationshipListMethod)) {
                                                        $relationshipOptions = $dataTypeContent->$relationshipListMethod();
                                                    } else {
                                                        $relationshipClass = $data->{camel_case($row->field)}()->getRelated();

                                                        if (isset($options->relationship->where)) {
                                                            $relationshipOptions = $relationshipClass::where(
                                                                $options->relationship->where[0],
                                                                $options->relationship->where[1]
                                                            )->get();
                                                        } else {
                                                            $relationshipOptions = $relationshipClass::where(
                                                                $options->relationship->key,$data->{$row->field}
                                                            )->first();
                                                        }
                                                    }
                                                    ?>
                                                    {{ $relationshipOptions->{$options->relationship->label} }}
                                                @endif
                                            @elseif($row->type == 'radio_btn' && isset($options->relationship->options))
                                                @php $badgeClass = $data->{$row->field}?'badge-success':'badge-danger';@endphp
                                                <i class="badge {{$badgeClass}}">{{ $options->relationship->options->{ $data->{$row->field} } }}</i>
                                            @elseif($row->type == 'switch')
                                                @if($options && property_exists($options, 'on') && property_exists($options, 'off'))
                                                    @if($data->{$row->field})
                                                        <span class="label label-info">{{ $options->on }}</span>
                                                    @else
                                                        <span class="label label-danger">{{ $options->off }}</span>
                                                    @endif
                                                @else
                                                    {{ $data->{$row->field} }}
                                                @endif
                                            @elseif($row->type == 'text')
                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                <div class="readmore">{{ strlen( $data->{$row->field} ) > 200 ? substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                            @elseif($row->type == 'text_area')
                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                <div class="readmore">{{ strlen( $data->{$row->field} ) > 200 ? substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                            @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                <a href="/storage/{{ $data->{$row->field} }}">Download</a>
                                            @elseif($row->type == 'rich_text_box')
                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                <div class="readmore">{{ strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                            @else
                                                @include('voyager::multilingual.input-hidden-bread-browse')
                                                <span>{{ $data->{$row->field} }}</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="no-sort no-click" id="bread-actions">
                                        @if (Voyager::can('delete_'.$dataType->name))
                                            <a href="javascript:;" title="Delete" class="btn btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}" id="delete-{{ $data->id }}">
                                                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{trans('voyager.Delete')}}</span>
                                            </a>
                                        @endif
                                        @if (Voyager::can('edit_'.$dataType->name))
                                            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $data->id) }}" title="Edit" class="btn btn-sm btn-primary pull-right edit">
                                                <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">{{trans('voyager.Edit')}}</span>
                                            </a>
                                        @endif
                                        @if (Voyager::can('read_'.$dataType->name))
                                            <a href="{{ route('voyager.'.$dataType->slug.'.show', $data->id) }}" title="View" class="btn btn-sm btn-warning pull-right">
                                                <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">{{trans('voyager.View')}}</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if (isset($dataType->server_side) && $dataType->server_side)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">{{trans('voyager.ShowPageTotal',['first'=>$dataTypeContent->firstItem(),'last'=>$dataTypeContent->lastItem(),'total'=>$dataTypeContent->total()])}}</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{trans('voyager.DeleteSure?',['item'=>strtolower($dataType->display_name_singular)])}}</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                 value="{{trans('voyager.DeleteSure',['item'=>strtolower($dataType->display_name_singular)])}}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{trans('voyager.Cancel')}}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
<link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    @if($isModelTranslatable)
        <script src="{{ voyager_asset('js/multilingual.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({
                    "order": []
                    @if(config('app.locale')=='zh'),language:Local.dataTable @endif
                    @if(config('dashboard.data_tables.responsive')), responsive: true @endif
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
            @endif
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) { // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');
            console.log(form.action);

            $('#delete_modal').modal('show');
        });
    </script>
@stop
