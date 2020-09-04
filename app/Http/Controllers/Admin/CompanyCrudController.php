<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompanyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Company::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/company');
        CRUD::setEntityNameStrings('Doanh Nghiệp', 'Doanh Nghiệp');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        CRUD::column('name')->label('Tên Công Ty');
        CRUD::addColumn([
            // n-n relationship (with pivot table)
            'label'     => 'Các Thuộc Tính', // Table column heading
            'type'      => 'select_multiple',
            'name'      => 'filters', // the method that defines the relationship in your Model
            'entity'    => 'filters', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => 'App\Models\Filter', // foreign key model
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CompanyRequest::class);

        //CRUD::setFromDb(); // fields

        CRUD::field('name')->label('Tên Công ty');

        CRUD::addField([    // Select2Multiple = n-n relationship (with pivot table)
            'label'     => "Các Thuộc Tính",
            'type'      => 'select2_multiple',
            'name'      => 'filters', // the method that defines the relationship in your Model

            // optional
            'entity'    => 'filters', // the method that defines the relationship in your Model
            'model'     => "App\Models\Filter", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            //'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            'select_all' => true, // show Select All and Clear buttons?

            // optional
//            'options'   => (function ($query) {
//                return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
//            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
