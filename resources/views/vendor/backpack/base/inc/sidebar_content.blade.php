<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>



@if (backpack_user()->hasRole('admin') || backpack_user()->hasRole('support'))

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('filter') }}'><i class='nav-icon la la-accessible-icon'></i> <span>Các Thuộc Tính</span></a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('company') }}'><i class='nav-icon la la-centercode'></i> <span>Doanh Nghiệp</span></a></li>


<li class="nav-item"><a class="nav-link" href="{{ backpack_url('customer') }}"><i class="nav-icon la la-confluence"></i> <span>Người Dùng</span></a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('question') }}'><i class='nav-icon la la-quora'></i> <span>Bộ Câu Hỏi</span> </a></li>


<li class='nav-item'><a class='nav-link' href='{{ backpack_url('survey') }}'><i class='nav-icon la la-columns'></i> Chiến Dịch</a></li>

@endif


@if (backpack_user()->hasRole('admin'))

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('explain') }}'><i class='nav-icon la la-exchange'></i> Giải Thích </a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon fa fa-cog'></i> Thiết Lập</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}\"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>

<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
@endif