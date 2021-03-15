<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Requests\RegisterRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RegisterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RegisterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Register::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/registered');
        CRUD::setEntityNameStrings('Đăng ký', 'Đăng ký');

        CRUD::denyAccess('create');
        CRUD::denyAccess('delete');
        CRUD::denyAccess('show');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Họ Tên');
        CRUD::column('phone')->label('SDT');
        CRUD::column('email')->label('Email');

        CRUD::column('position')
            ->label('Vị trí')
            ->type('select_from_array')
            ->options(Helpers::REG_POSITIONS);

        CRUD::column('option')
            ->label('Mong muốn')
            ->type('select_from_array')
            ->options(Helpers::REG_OPTIONS);


        CRUD::column('status')
            ->label('Trạng thái')
            ->type('select_from_array')
            ->options(Helpers::STATUSES);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RegisterRequest::class);

//        CRUD::field('name')->label('Họ Tên');
//        CRUD::field('phone')->label('SDT');
//        CRUD::field('email')->label('Email');
//
//        CRUD::field('position')
//            ->label('Vị trí')
//            ->type('select_from_array')
//            ->options(Helpers::REG_POSITIONS);
//
//        CRUD::field('option')
//            ->label('Mong muốn')
//            ->type('select_from_array')
//            ->options(Helpers::REG_OPTIONS);


        CRUD::field('status')
            ->label('Trạng thái')
            ->type('select_from_array')
            ->options(Helpers::STATUSES);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
