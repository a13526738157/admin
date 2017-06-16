@if(config('voyager.show_dev_tips'))
    <div class="container-fluid">
        <div class="alert alert-info">
            <strong>{{trans('voyager.How To Use')}}:</strong>
            <p>{{trans_choice('voyager.menuNotice',!empty($menu) ? 10 : 1)}}  <code>menu('{{ !empty($menu) ? $menu->name : 'name' }}')</code></p>
        </div>
    </div>
@endif
