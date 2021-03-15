<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Requests\ContactRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ContactCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContactCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Contact::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contact');
        CRUD::setEntityNameStrings('Liên Hệ', 'Liên Hệ');

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
        CRUD::column('option')
            ->label('Mong muốn')
            ->type('select_from_array')
            ->options(Helpers::CONTACT_OPTIONS);

        CRUD::column('content')->label('Nội dung')->type('textarea');


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
        CRUD::setValidation(ContactRequest::class);

//        CRUD::field('name')->label('Họ Tên');
//        CRUD::field('phone')->label('SDT');
//        CRUD::field('email')->label('Email');
//        CRUD::field('option')
//            ->label('Mong muốn')
//            ->type('select_from_array')
//            ->options(Helpers::CONTACT_OPTIONS);
//
//        CRUD::field('content')->label('Nội dung')->type('textarea');


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
