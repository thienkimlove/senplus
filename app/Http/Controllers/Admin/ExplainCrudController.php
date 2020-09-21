<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Requests\ExplainRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ExplainCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ExplainCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Explain::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/explain');
        CRUD::setEntityNameStrings('Giải Thích', 'Giải Thích');

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

        CRUD::addColumns([
            [
                'name' => 'option',
                'label' => 'Tên',
                'type' => 'select_from_array',
                'options' => Helpers::mapOption()
            ],
            [
                'name' => 'ten_van_hoa',
                'label' => 'Tên Văn Hóa'
            ],
            [
                'name' => 'nang_luc_canh_tranh',
                'label' => 'Năng lực cạnh tranh',
                'type' => 'textarea'
            ],
            [
                'name' => 'gia_tri_dem_lại',
                'label' => 'Giá trị đem lại',
                'type' => 'textarea'
            ],
            [
                'name' => 'xu_huong',
                'label' => 'Xu Hướng',
                'type' => 'table',
                'columns' => ['content' => 'Nội dung']

            ],
            [
                'name' => 'uu_diem',
                'label' => 'Ưu điểm',
                'type' => 'table',
                'columns' => ['content' => 'Nội dung']

            ],
            [
                'name' => 'nhuoc_diem',
                'label' => 'Nhược điểm',
                'type' => 'table',
                'columns' => ['content' => 'Nội dung']

            ]
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
        CRUD::setValidation(ExplainRequest::class);

        //CRUD::setFromDb(); // fields

        CRUD::addFields([
            [
                'name' => 'option',
                'label' => 'Tên',
                'type' => 'select_from_array',
                'options' => Helpers::mapOption()
            ],
            [
                'name' => 'ten_van_hoa',
                'label' => 'Tên Văn Hóa'
            ],
            [
                'name' => 'nang_luc_canh_tranh',
                'label' => 'Năng lực cạnh tranh',
                'type' => 'textarea'
            ],
            [
                'name' => 'gia_tri_dem_lại',
                'label' => 'Giá trị đem lại',
                'type' => 'textarea'
            ],
            [
                'name' => 'xu_huong',
                'label' => 'Xu Hướng',
                'type' => 'table',
                'columns' => ['content' => 'Nội dung']

            ],
            [
                'name' => 'uu_diem',
                'label' => 'Ưu điểm',
                'type' => 'table',
                'columns' => ['content' => 'Nội dung']

            ],
            [
                'name' => 'nhuoc_diem',
                'label' => 'Nhược điểm',
                'type' => 'table',
                'columns' => ['content' => 'Nội dung']

            ]
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
