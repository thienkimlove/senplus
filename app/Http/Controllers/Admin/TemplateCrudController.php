<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Requests\TemplateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TemplateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TemplateCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Template::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/template');
        CRUD::setEntityNameStrings('Bộ Câu Hỏi Mẫu', 'Bộ Câu Hỏi Mẫu');

        CRUD::denyAccess('list');
        CRUD::denyAccess('create');
        CRUD::denyAccess('update');
        CRUD::denyAccess('delete');

        if (backpack_user()->hasAnyRole(['admin', 'support'])) {
            CRUD::allowAccess('list');
            CRUD::allowAccess('create');
            CRUD::allowAccess('update');
        }

//        if (backpack_user()->hasRole('admin')) {
//            CRUD::allowAccess('delete');
//        }
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Tên');
        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Loại',
            'type' => 'select_from_array',
            'options' => Helpers::TEMPLATE_QUESTION_TYPES
        ]);
        CRUD::addColumn(
            [
                'name' => 'questions',
                'label' => 'Các câu hỏi',
                'type' => 'table',
                'columns' => [
                    'name' => 'Câu hỏi',
                    'option1' => 'Lựa chọn 1',
                    'option2' => 'Lựa chọn 2',
                    'option3' => 'Lựa chọn 3',
                    'option4' => 'Lựa chọn 4',
                ],
            ]
        );

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TemplateRequest::class);

        CRUD::field('name')->label('Tên');
        CRUD::addField([
            'name' => 'type',
            'label' => 'Loại',
            'type' => 'select_from_array',
            'options' => Helpers::TEMPLATE_QUESTION_TYPES
        ]);
        CRUD::addField(
            [
                'name' => 'questions',
                'label' => 'Các câu hỏi theo thứ tự',
                'type' => 'table',
                'entity_singular' => 'more question', // used on the "Add X" button
                'columns' => [
                    'name' => 'Câu hỏi',
                    'option1' => 'Lựa chọn 1',
                    'option2' => 'Lựa chọn 2',
                    'option3' => 'Lựa chọn 3',
                    'option4' => 'Lựa chọn 4',
                ],
                'min' => 12,
                'max' => 12
            ]
        );
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
