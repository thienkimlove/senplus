<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserExport;
use App\Helpers;
use App\Http\Requests\CompanyRequest;
use App\Imports\UserImport;
use App\Models\Customer;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class CompanyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Company::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/company');
        CRUD::setEntityNameStrings('Doanh Nghiệp', 'Doanh Nghiệp');

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

        CRUD::column('name')->label('Tên Công Ty');
        CRUD::column('brand_name')->label('Thương hiệu');
        CRUD::column('logo')->label('Logo')->type('image');
        CRUD::addColumn([

            'label'     => 'Lĩnh Vực',
            'type'      => 'select',
            'name'      => 'business_field_id',
            'entity'    => 'business',
            'attribute' => 'name',
            'model'     => 'App\Models\Business',
        ]);
        CRUD::addColumn([

            'label'     => 'Số NV',
            'type'      => 'select',
            'name'      => 'employee_number_id',
            'entity'    => 'employee',
            'attribute' => 'name',
            'model'     => 'App\Models\Employee',
        ]);

        CRUD::addColumn([

            'label'     => 'Doanh Thu',
            'type'      => 'select',
            'name'      => 'average_income_id',
            'entity'    => 'income',
            'attribute' => 'name',
            'model'     => 'App\Models\Income',
        ]);

        CRUD::addColumn([

            'label'     => 'Tổng Vốn',
            'type'      => 'select',
            'name'      => 'total_fund_id',
            'entity'    => 'fund',
            'attribute' => 'name',
            'model'     => 'App\Models\Fund',
        ]);

        CRUD::addColumn([

            'label'     => 'Các Thuộc Tính',
            'type'      => 'select_multiple',
            'name'      => 'filters',
            'entity'    => 'filters',
            'attribute' => 'name',
            'model'     => 'App\Models\Filter',
        ]);

        CRUD::addButtonFromView('line', 'template_excel_user', 'template_excel_user', 'end');
        CRUD::addButtonFromView('line', 'import_excel_user', 'import_excel_user', 'end');
        CRUD::addButtonFromView('line', 'add_admin', 'add_admin', 'end');

    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(CompanyRequest::class);
        CRUD::field('name')->label('Tên Công ty');

        CRUD::field('brand_name')->label('Thương hiệu');
        CRUD::field('logo')->label('Logo')->type('browse');
        CRUD::addField([

            'label'     => 'Lĩnh Vực',
            'type'      => 'select2',
            'name'      => 'business_field_id',
            'entity'    => 'business',
            'attribute' => 'name',
            'model'     => 'App\Models\Business',
        ]);
        CRUD::addField([

            'label'     => 'Số NV',
            'type'      => 'select2',
            'name'      => 'employee_number_id',
            'entity'    => 'employee',
            'attribute' => 'name',
            'model'     => 'App\Models\Employee',
        ]);

        CRUD::addColumn([

            'label'     => 'Doanh Thu',
            'type'      => 'select2',
            'name'      => 'average_income_id',
            'entity'    => 'income',
            'attribute' => 'name',
            'model'     => 'App\Models\Income',
        ]);

        CRUD::addField([

            'label'     => 'Tổng Vốn',
            'type'      => 'select2',
            'name'      => 'total_fund_id',
            'entity'    => 'fund',
            'attribute' => 'name',
            'model'     => 'App\Models\Fund',
        ]);


        CRUD::addField([
            'label'     => "Các Thuộc Tính",
            'type'      => 'select2_multiple',
            'name'      => 'filters',
            'entity'    => 'filters',
            'model'     => "App\Models\Filter",
            'attribute' => 'name',
            'select_all' => true,
        ]);
    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }


    public function downloadExcelUser($id)
    {
        return Excel::download(new UserExport($id), 'template_excel_user.xlsx');
    }

    protected function setupModerateRoutes($segment, $routeName, $controller)
    {
        \Route::get($segment.'/{id}/importExcelUser', [
        'as'        => $routeName.'.importExcelUser',
        'uses'      => $controller.'@importExcelUser',
        'operation' => 'importExcelUser',
    ]);
        \Route::post($segment.'/{id}/importExcelUser', [
            'as'        => $routeName.'.postImportExcelUser',
            'uses'      => $controller.'@postImportExcelUser',
            'operation' => 'importExcelUser',
        ]);

        \Route::get($segment.'/{id}/addAdmin', [
            'as'        => $routeName.'.addAdmin',
            'uses'      => $controller.'@addAdmin',
            'operation' => 'addAdmin',
        ]);
        \Route::post($segment.'/{id}/addAdmin', [
            'as'        => $routeName.'.postAddAdmin',
            'uses'      => $controller.'@postAddAdmin',
            'operation' => 'addAdmin',
        ]);
    }


    public function importExcelUser($id)
    {
        $this->crud->hasAccessOrFail('update');
        $this->crud->setOperation('ImportExcelUser');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'ImportExcelUser '.$this->crud->entity_name;

        return view('vendor.backpack.crud.import_excel_user', $this->data);
    }

    public function postImportExcelUser($id, Request $request)
    {
        $this->crud->hasAccessOrFail('update');
        $excelFile = $request->file('excel_file');
        Excel::import(new UserImport($id), $excelFile);

        // show a success message
        \Alert::success('Upload thành công.')->flash();

        return \Redirect::to($this->crud->route);
    }

    public function addAdmin($id)
    {
        $this->crud->hasAccessOrFail('update');
        $this->crud->setOperation('addAdmin');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'addAdmin '.$this->crud->entity_name;

        $this->data['customers'] = Customer::whereNull('company_id')->get();

        return view('vendor.backpack.crud.add_admin', $this->data);
    }

    public function postAddAdmin($id, Request $request)
    {
        $this->crud->hasAccessOrFail('update');
        $customerId = $request->input('customer_id');

        if ($customerId && ($customer = Customer::find($customerId))) {
            if (!$customer->company_id) {
                $customer->update([
                    'level' => Helpers::FRONTEND_ADMIN_LEVEL,
                    'company_id' => $id
                ]);
            };
        }

        // show a success message
        \Alert::success('Thêm thành công.')->flash();

        return \Redirect::to($this->crud->route);
    }
}
