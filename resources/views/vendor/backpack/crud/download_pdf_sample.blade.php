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
             <h3>Trọng số </h3>

             <table>
                 <thead>
                 <th>Name</th>
                 <th>Current</th>
                 <th>Điều chỉnh</th>
                 </thead>
                 <tbody>
                   @foreach ($filterCounts as $value => $filterCount)
                       @if (isset($weighConfig[$value]))
                        <tr>
                            <td> {{ $value }}</td>
                            <td> {{ $filterCount['percent'] }}%</td>
                            <td> {{ $weighConfig[$value] }}%</td>
                        </tr>
                        @endif
                   @endforeach
                 </tbody>


             </table>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <h3>Kết quả thực tế tổng quan </h3>

            <table>
                <thead>
                <th>Tiêu chí</th>
                <th>Hiện tại</th>
                <th>Mong muốn</th>
                </thead>
                <tbody>
                @foreach (\App\Helpers::ARRAY_OPTIONS as $option)
                    <tr>
                        <td> {{ \App\Helpers::mapOption()[$option] }}</td>
                        <td> {{ $realResult['details'][7]['result'][1][$option] }}</td>
                        <td> {{ $realResult['details'][7]['result'][2][$option] }}</td>
                    </tr>
                @endforeach
                </tbody>


            </table>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <h3>Kết quả điều chỉnh tổng quan </h3>

            <table>
                <thead>
                <th>Tiêu chí</th>
                <th>Hiện tại</th>
                <th>Mong muốn</th>
                </thead>
                <tbody>
                @foreach (\App\Helpers::ARRAY_OPTIONS as $option)
                    <tr>
                        <td> {{ \App\Helpers::mapOption()[$option] }}</td>
                        <td> {{ $modifyResult['details'][7]['result'][1][$option] }}</td>
                        <td> {{ $modifyResult['details'][7]['result'][2][$option] }}</td>
                    </tr>
                @endforeach
                </tbody>


            </table>
        </div>
    </div>
@endsection