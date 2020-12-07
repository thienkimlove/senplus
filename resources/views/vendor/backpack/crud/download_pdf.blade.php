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
            <small>{!! $crud->getSubheading() ?? 'Moderate '.$crud->entity_name !!}.</small>

            @if ($crud->hasAccess('list'))
                <small><a href="{{ url($crud->route) }}" class="hidden-print font-sm"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form method="POST" action="{{ route('frontend.report') }}">
                {{ csrf_field() }}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Download PDF</h3>
                </div>
                @foreach ($filterCounts as $value => $filterCount)
                <div class="card-body row">
                    <div class="form-group col-sm-12">
                        <label for="field_{{ $value }}">% Trọng số cho {{ $value }} - thực tế <b>{{ $filterCount['percent'] }}%</b></label>
                        <input id="field_{{ $value }}" type="number" name="{{ $value }}"  class="form-control" value="0" />
                    </div>
                </div><!-- /.card-body -->
                @endforeach

                <div class="card-footer">
                    <input type="hidden" name="survey_id" value="{{ $entry->id }}">
                    <input type="submit" class="btn btn-success" value="Báo Cáo">
                </div><!-- /.card-footer-->
            </div><!-- /.card -->
            </form>
        </div>
    </div>
@endsection