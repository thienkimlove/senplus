<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Requests\CustomerRequest;
use App\Models\Company;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    public function setup()
    {
        CRUD::setModel(\App\Models\Customer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer');
        CRUD::setEntityNameStrings('Người Dùng', 'Người Dùng');


        CRUD::denyAccess('list');
        CRUD::denyAccess('create');
        CRUD::denyAccess('update');
        CRUD::denyAccess('delete');

        if (backpack_user()->hasAnyRole(['admin', 'support'])) {
            CRUD::allowAccess('list');
            CRUD::allowAccess('create');
            CRUD::allowAccess('update');
        }

        if (backpack_user()->hasRole('admin')) {
            CRUD::allowAccess('delete');
        }
    }


    protected function setupListOperation()
    {
        CRUD::column('name')->label('Tên');
        CRUD::column('avatar')->label('Avatar')->type('image');
        CRUD::addColumn([
            'label' => 'Gender',
            'type' => 'select_from_array',
            'options' => Helpers::getGenders(),
            'name' => 'gender'
        ]);
        CRUD::addColumn([
            // n-n relationship (with pivot table)
            'label'     => 'Doanh Nghiệp',
            'type'      => 'select',
            'name'      => 'company',
            'entity'    => 'company',
            'attribute' => 'name',
            'model'     => 'App\Models\Company',
        ]);
        CRUD::column('display_level')->label('Cấp');
        CRUD::column('login')->label('Tài khoản');
        CRUD::column('password')->label('Mật khẩu');
        CRUD::column('status')->label('Trạng thái')->type('boolean');


        CRUD::addColumn(
            [
                'name' => 'options',
                'label' => 'Các thuộc tính',
                'type' => 'table',
                'columns' => [
                    'att_id' => 'ID thuộc tính',
                    'att_value' => 'Giá trị'
                ],
            ]
        );



        CRUD::addFilter(
            [
                'name'  => 'filter_by_company',
                'type'  => 'select2',
                'label' => 'Doanh Nghiệp',
            ],
            Company::pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                CRUD::addClause('where', function($q) use($value) {
                    $q->where('company_id', $value);
                });
            }
        );
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CustomerRequest::class);

        CRUD::field('name')->label('Tên');
        CRUD::field('avatar')->label('Avatar')->type('image');
        CRUD::addField([
            'label' => 'Gender',
            'type' => 'select_from_array',
            'options' => Helpers::getGenders(),
            'name' => 'gender'
        ]);
        CRUD::field('first_name')->label('Tên');
        CRUD::field('last_name')->label('Họ');
        CRUD::field('email')->label('Email');
        CRUD::field('phone')->label('Phone');
        CRUD::field('username')->label('Username');
        CRUD::field('address')->label('Address')->type('textarea');
        CRUD::addField([
            'label'     => 'Cấp',
            'type'      => 'select_from_array',
            'name'      => 'level',
            'options'   => Helpers::mapLevel(),
        ]);
        CRUD::field('login')->label('Tài khoản');
        CRUD::field('password')->label('Mật khẩu');
        CRUD::field('status')->label('Trạng thái')->type('boolean');

        CRUD::addField([
            'label'     => 'Doanh Nghiệp',
            'type'      => 'select',
            'name'      => 'company_id',
            'entity'    => 'company',
            'attribute' => 'name',
            'model'     => 'App\Models\Company',
        ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
