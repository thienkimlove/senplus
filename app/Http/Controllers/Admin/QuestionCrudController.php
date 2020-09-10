<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionRequest;
use App\Models\Company;
use App\Models\Survey;
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

        CRUD::addColumn([
            // any type of relationship
            'name'         => 'survey', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Chiến Dịch', // Table column heading
            // OPTIONAL
            'entity'    => 'survey', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => Survey::class, // foreign key model
        ]);

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
                'label' => 'Chiến DỊch',
            ],
            Survey::pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
               CRUD::addClause('where', function($q) use($value) {
                   $q->where('survey_id', $value);
               });
            }
        );

        CRUD::denyAccess('delete');
        CRUD::denyAccess('update');
        CRUD::denyAccess('create');
    }


}
