@if ($crud->hasAccess('export'))
<a href="{{ url($crud->route . '/export') }}" target="__blank" class="btn btn-success" bp-button="export" data-style="zoom-in">
    <i class="la la-file-excel"></i> <span>Export</span>
</a>
@endif
