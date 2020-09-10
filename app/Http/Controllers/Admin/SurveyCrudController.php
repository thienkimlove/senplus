<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionExport;
use App\Http\Requests\SurveyRequest;
use App\Imports\QuestionImport;
use App\Models\Answer;
use App\Models\Survey;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class SurveyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SurveyCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Survey::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/survey');
        CRUD::setEntityNameStrings('Chiến Dịch Khảo Sát', 'Chiến Dịch Khảo Sát');
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

        CRUD::column('name')->label('Tên Chiến Dịch Khảo Sát');
        CRUD::addColumn([
            // n-n relationship (with pivot table)
            'label'     => 'Doanh Nghiệp',
            'type'      => 'select',
            'name'      => 'company',
            'entity'    => 'company',
            'attribute' => 'name',
            'model'     => 'App\Models\Company',
        ]);

        CRUD::column('status')->label('Trạng Thái')->type('boolean');
        CRUD::addButtonFromView('top', 'template_excel_question', 'template_excel_question', 'beginning');
        CRUD::addButtonFromView('line', 'import_excel_question', 'import_excel_question', 'end');
        CRUD::addButtonFromView('line', 'clear_result', 'clear_result', 'end');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SurveyRequest::class);

        //CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */

        CRUD::field('name')->label('Tên Chiến Dịch Khảo Sát');

        CRUD::addField([
            'label'     => "Doanh Nghiệp",
            'type'      => 'select',
            'name'      => 'company',
            'entity'    => 'company',
            'model'     => "App\Models\Company",
            'attribute' => 'name',
        ]);

        CRUD::field('status')->label('Trạng Thái')->type('boolean');
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

    public function downloadExcelQuestion()
    {
        return Excel::download(new QuestionExport(), 'template_excel_question.xlsx');
    }

    public function clear($id)
    {

        $survey = Survey::find($id);

        if ($survey) {
            Answer::whereIn('question_id', $survey->questions->pluck('id')->all())
                ->delete();
        }

        return redirect(url('admin/survey'));
    }
}
