@extends(backpack_view('layouts.top_left'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => backpack_url('dashboard'),
      $crud->entity_name_plural => url($crud->route),
      'Moderate' => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? 'Add Admin '.$crud->entity_name !!}.</small>

            @if ($crud->hasAccess('list'))
                <small><a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form method="POST">
                {{ csrf_field() }}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thêm Admin</h3>
                </div>
                <div class="card-body row">
                    <div class="form-group col-sm-12">
                        <label>Chọn</label>
                        <select name="customer_id" class="form-control">
                            <option value="">Chọn</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->email }}</option>
                            @endforeach
                        </select>
                    </div>
                </div><!-- /.card-body -->

                <div class="card-footer">
                    <input type="submit" class="btn btn-success" value="Thêm Admin">
                </div><!-- /.card-footer-->
            </div><!-- /.card -->
            </form>
        </div>
    </div>
@endsection