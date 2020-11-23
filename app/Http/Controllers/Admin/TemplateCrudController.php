<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TemplateExport;
use App\Helpers;
use App\Http\Requests\TemplateRequest;
use App\Imports\TemplateImport;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

            CRUD::addButtonFromView('top', 'template_excel_question', 'template_excel_question', 'beginning');
            CRUD::addButtonFromView('line', 'import_excel_template', 'import_excel_template', 'end');
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

        CRUD::addColumn([
            'name' => 'round_1_desc',
            'label' => 'Mô tả vòng 1',
            'type' => 'textarea'
        ]);

        CRUD::addColumn([
            'name' => 'round_2_desc',
            'label' => 'Mô tả vòng 2',
            'type' => 'textarea'
        ]);

    }

    protected function setupModerateRoutes($segment, $routeName, $controller)
    {
        \Route::get($segment.'/{id}/importExcelTemplate', [
            'as'        => $routeName.'.importExcelTemplate',
            'uses'      => $controller.'@importExcelTemplate',
            'operation' => 'importExcelTemplate',
        ]);
        \Route::post($segment.'/{id}/importExcelTemplate', [
            'as'        => $routeName.'.postImportExcelTemplate',
            'uses'      => $controller.'@postImportExcelTemplate',
            'operation' => 'postImportExcelTemplate',
        ]);

        \Route::get($segment.'/templateExcelQuestion', [
            'as'        => $routeName.'.templateExcelQuestion',
            'uses'      => $controller.'@templateExcelQuestion',
            'operation' => 'templateExcelQuestion',
        ]);
    }

    public function templateExcelQuestion()
    {
        return Excel::download(new TemplateExport(), 'template_excel_question.xlsx');
    }

    public function importExcelTemplate($id)
    {
        $this->crud->hasAccessOrFail('update');
        $this->crud->setOperation('importExcelTemplate');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'importExcelTemplate '.$this->crud->entity_name;

        return view('vendor.backpack.crud.import_excel_template', $this->data);
    }

    public function postImportExcelTemplate($id, Request $request)
    {
        $this->crud->hasAccessOrFail('update');
        $excelFile = $request->file('excel_file');
        Excel::import(new TemplateImport($id), $excelFile);

        // show a success message
        \Alert::success('Upload thành công.')->flash();

        return \Redirect::to($this->crud->route);
    }


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
                    'round' => 'Vòng',
                    'order' => 'Thứ tự',
                    'option1' => 'Lựa chọn 1',
                    'option2' => 'Lựa chọn 2',
                    'option3' => 'Lựa chọn 3',
                    'option4' => 'Lựa chọn 4',
                ]
            ]
        );
        CRUD::addField([
            'name' => 'round_1_desc',
            'label' => 'Mô tả vòng 1',
            'type' => 'textarea'
        ]);

        CRUD::addField([
            'name' => 'round_2_desc',
            'label' => 'Mô tả vòng 2',
            'type' => 'textarea'
        ]);


    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
