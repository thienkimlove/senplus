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

    public function setup()
    {
        CRUD::setModel(\App\Models\Question::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/question');
        CRUD::setEntityNameStrings('Câu Hỏi', 'Câu Hỏi');

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

        CRUD::column('name');

        CRUD::addColumn([
            'name'         => 'survey',
            'type'         => 'relationship',
            'label'        => 'Chiến Dịch',
            'entity'    => 'survey',
            'attribute' => 'name',
            'model'     => Survey::class,
        ]);

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
                'label' => 'Chiến Dịch',
            ],
            Survey::pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
               CRUD::addClause('where', function($q) use($value) {
                   $q->where('survey_id', $value);
               });
            }
        );
    }


}
