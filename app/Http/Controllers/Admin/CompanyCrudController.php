<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionExport;
use App\Exports\UserExport;
use App\Http\Requests\CompanyRequest;
use App\Imports\QuestionImport;
use App\Imports\UserImport;
use App\Models\Question;
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
        CRUD::addButtonFromView('top', 'template_excel_question', 'template_excel_question', 'beginning');
        CRUD::addButtonFromView('line', 'template_excel_user', 'template_excel_user', 'end');

        CRUD::addButtonFromView('line', 'import_excel_question', 'import_excel_question', 'end');
        CRUD::addButtonFromView('line', 'import_excel_user', 'import_excel_user', 'end');
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


    public function downloadExcelQuestion()
    {
        return Excel::download(new QuestionExport(), 'template_excel_question.xlsx');
    }

    public function downloadExcelUser($id)
    {
        return Excel::download(new UserExport($id), 'template_excel_user.xlsx');
    }

    protected function setupModerateRoutes($segment, $routeName, $controller)
    {
        \Route::get($segment.'/{id}/importExcelQuestion', [
            'as'        => $routeName.'.importExcelQuestion',
            'uses'      => $controller.'@importExcelQuestion',
            'operation' => 'importExcelQuestion',
        ]);
        \Route::post($segment.'/{id}/importExcelQuestion', [
            'as'        => $routeName.'.postImportExcelQuestion',
            'uses'      => $controller.'@postImportExcelQuestion',
            'operation' => 'importExcelQuestion',
        ]);


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
    }

    public function importExcelQuestion($id)
    {
        $this->crud->hasAccessOrFail('update');
        $this->crud->setOperation('ImportExcelQuestion');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'ImportExcelQuestion '.$this->crud->entity_name;

        return view('vendor.backpack.crud.import_excel_question', $this->data);
    }

    public function postImportExcelQuestion($id, Request $request)
    {
        $this->crud->hasAccessOrFail('update');

        // TODO: do whatever logic you need here
        // ...
        // You can use
        // - $this->crud
        // - $this->crud->getEntry($id)
        // - $request
        // ...

        $excelFile = $request->file('excel_file');

        Excel::import(new QuestionImport($id), $excelFile);

        // show a success message
        \Alert::success('Upload thành công.')->flash();

        return \Redirect::to($this->crud->route);
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

        // TODO: do whatever logic you need here
        // ...
        // You can use
        // - $this->crud
        // - $this->crud->getEntry($id)
        // - $request
        // ...

        $excelFile = $request->file('excel_file');

        Excel::import(new UserImport($id), $excelFile);

        // show a success message
        \Alert::success('Upload thành công.')->flash();

        return \Redirect::to($this->crud->route);
    }
}
