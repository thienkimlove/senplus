<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionRequest;
use App\Models\Company;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class QuestionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QuestionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Question::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/question');
        CRUD::setEntityNameStrings('Câu Hỏi', 'Câu Hỏi');
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
        CRUD::column('name');

        CRUD::column('question_belong')->label('Loại');

//        CRUD::column('option1')->label('Lựa chọn 1');
//        CRUD::column('option2')->label('Lựa chọn 2');
//        CRUD::column('option3')->label('Lựa chọn 3');
//        CRUD::column('option4')->label('Lựa chọn 4');

        CRUD::column('round')
            ->type('select_from_array')
            ->label('Vòng')
            ->options([1 => 'Vòng 1', 2 => 'Vòng 2']);

        CRUD::column('order')
            ->type('select_from_array')
            ->label('Thứ tự')
            ->options([
                1 => 'Câu thứ nhất',
                2 => 'Câu thứ hai',
                3 => 'Câu thứ ba',
                4 => 'Câu thứ bốn',
                5 => 'Câu thứ năm',
                6 => 'Câu thứ sáu',
            ]);


        CRUD::addFilter(
            [
                'name'  => 'filter_by_type',
                'type'  => 'select2',
                'label' => 'Dành Cho',
            ],
            ['general' => 'Câu hỏi Chung']+Company::pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
               CRUD::addClause('where', function($q) use($value) {
                   if ($value != 'general') {
                       $q->where('company_id', $value);
                   } else {
                       $q->whereNull('company_id');
                   }
               });
            }
        );

        CRUD::denyAccess('delete');
        CRUD::denyAccess('update');
        CRUD::denyAccess('create');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(QuestionRequest::class);

        //CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */

        CRUD::addField('name');


        CRUD::addField([
            'name' => 'company',
            'label' => 'Dành Cho',
            'type' => 'relationship',
            'entity' => 'company',
            'attribute' => 'name',
            'model' => Company::class
        ]);

        CRUD::addFields([
            [
                'name' => 'option1',
                'label' => 'Lựa chọn 1'
            ],
            [
                'name' => 'option2',
                'label' => 'Lựa chọn 2'
            ],
            [
                'name' => 'option3',
                'label' => 'Lựa chọn 3'
            ],
            [
                'name' => 'option4',
                'label' => 'Lựa chọn 4'
            ]
        ]);

        CRUD::addField([
            'name' => 'round',
            'type' => 'select_from_array',
            'label' => 'Vòng',
            'options' => [1 => 'Vòng 1', 2 => 'Vòng 2']
        ]);

        CRUD::addField([
            'name' => 'order',
            'type' => 'select_from_array',
            'label' => 'Thứ tự',
            'options' => [
                1 => 'Câu thứ nhất',
                2 => 'Câu thứ hai',
                3 => 'Câu thứ ba',
                4 => 'Câu thứ bốn',
                5 => 'Câu thứ năm',
                6 => 'Câu thứ sáu',
            ]
        ]);

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
