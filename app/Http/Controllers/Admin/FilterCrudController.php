<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FilterRequest;
use App\Models\Company;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FilterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FilterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Filter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/filter');
        CRUD::setEntityNameStrings('Các Thuộc Tính', 'Các Thuộc Tính');

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

        CRUD::column('id')->label('ID');
        CRUD::column('name')->label('Tên Thuộc Tính');
        CRUD::column('is_level')
            ->type('boolean')
            ->label('Phân Cấp?');

        CRUD::column('is_title')
            ->type('boolean')
            ->label('Cấp Bậc?');

        CRUD::addColumn([
            'name' => 'options',
            'label' => 'Các giá trị',
            'type' => 'table',
            'columns' => [
                'attr_value' => 'Giá trị'
            ],
        ]);

        CRUD::addFilter(
            [
                'name'  => 'filter_by_company',
                'type'  => 'select2',
                'label' => 'Doanh Nghiệp',
            ],
            Company::pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                CRUD::addClause('where', function($q) use($value) {
                    $q->whereHas('company', function($query) use($value) {
                        $query->where('id', $value);
                    });
                });
            }
        );
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(FilterRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => 'Tên Thuộc Tính'
            ],
            [
                'name' => 'is_level',
                'label' => 'Phân Cấp?',
                'type' => 'boolean'
            ],
            [
                'name' => 'is_title',
                'label' => 'Cấp Bậc?',
                'type' => 'boolean'
            ],
            [ // Table
                'name' => 'options',
                'label' => 'Các Giá Trị',
                'type' => 'table',
                'entity_singular' => 'option', // used on the "Add X" button
                'columns' => [
                    'attr_value' => 'Giá trị'
                ],
                'max' => 100, // maximum rows allowed in the table
                'min' => 1, // minimum rows allowed in the table
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
