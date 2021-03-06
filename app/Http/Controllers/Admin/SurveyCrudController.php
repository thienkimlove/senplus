<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionExport;
use App\Helpers;
use App\Http\Requests\SurveyRequest;
use App\Imports\QuestionImport;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Question;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }


    public function setup()
    {
        CRUD::setModel(Survey::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/survey');
        CRUD::setEntityNameStrings('Chiến Dịch Khảo Sát', 'Chiến Dịch Khảo Sát');

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

        CRUD::column('name')->label('Tên Chiến Dịch');
        CRUD::column('link')->label('Mã Link Chiến Dịch');
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

        CRUD::addColumn([
            'name' => 'start_time',
            'type' => 'datetime',
            'label' => 'Thời gian bắt đầu'
        ]);
        CRUD::addColumn([
            'name' => 'end_time',
            'type' => 'datetime',
            'label' => 'Thời gian kết thúc'
        ]);

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

        //CRUD::addButtonFromView('top', 'template_excel_question', 'template_excel_question', 'beginning');
        //CRUD::addButtonFromView('line', 'import_excel_question', 'import_excel_question', 'end');
        CRUD::addButtonFromView('line', 'clear_result', 'clear_result', 'end');
        CRUD::addButtonFromView('line', 'download_pdf', 'download_pdf', 'end');

        CRUD::addFilter(
            [
                'name'  => 'filter_by_company',
                'type'  => 'select2',
                'label' => 'Doanh Nghiệp',
            ],
            Company::pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                CRUD::addClause('where', function($q) use($value) {
                    $q->where('company_id', $value);
                });
            }
        );
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SurveyRequest::class);

        CRUD::field('name')->label('Tên Chiến Dịch Khảo Sát');
        CRUD::field('link')->label('Mã Link Chiến Dịch Khảo Sát');
        CRUD::field('desc')->label('Mô Tả Chiến Dịch Khảo Sát')->type('textarea');

        CRUD::addField([
            'label'     => "Doanh Nghiệp",
            'type'      => 'select_from_array',
            'name'      => 'company_id',
            'options' => Company::pluck('name', 'id')->all()
        ]);

        CRUD::field('status')->label('Trạng Thái')->type('boolean');

        CRUD::addField([
            'name' => 'start_time',
            'type' => 'datetime',
            'label' => 'Thời gian bắt đầu'
        ]);
        CRUD::addField([
            'name' => 'end_time',
            'type' => 'datetime',
            'label' => 'Thời gian kết thúc'
        ]);

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

    public function update()
    {
        // do something before validation, before save, before everything
        $response = $this->traitUpdate();
        // do something after save

        $content = $this->data['entry'];

        Helpers::adminAddTemplateQuestionWhenSurvey($content);

        return $response;
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

        \Route::get($segment.'/{id}/downloadPdf', [
            'as'        => $routeName.'.downloadPdf',
            'uses'      => $controller.'@downloadPdf',
            'operation' => 'downloadPdf',
        ]);
        \Route::post($segment.'/{id}/downloadPdf', [
            'as'        => $routeName.'.postDownloadPdf',
            'uses'      => $controller.'@postDownloadPdf',
            'operation' => 'postDownloadPdf',
        ]);

    }

    public function downloadPdfTest($id)
    {
        exec("chromehtml2pdf --out /var/www/html/senplus/public/uploads/test.pdf --landscape=0 --format=A4 --executablePath=/usr/bin/chromium-browser https://casonline.vn/uploads/page.html");

        return redirect(url('uploads/test.pdf'));
    }

    public function downloadPdf($id)
    {
        $this->crud->hasAccessOrFail('update');
        $this->crud->setOperation('downloadPdf');

        $content = Survey::find($id);

        $customers = Customer::where('company_id', $content->company_id)
            ->where('status', true)
            ->pluck('id')
            ->all();

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'downloadPdf '.$this->crud->entity_name;
        $this->data['filterCounts'] = Helpers::getRealWeightForSurvey($content, $customers);

        return view('vendor.backpack.crud.download_pdf', $this->data);
    }

    public function postDownloadPdf($id, Request $request)
    {

        $content = Survey::find($id);

        $this->crud->hasAccessOrFail('update');
        $weighConfig = $request->all();

        $customers = Customer::where('company_id', $content->company_id)
            ->where('status', true)
            ->pluck('id')
            ->all();

        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'downloadPdf '.$this->crud->entity_name;

        $this->data['realResult'] = Helpers::getResultExplainForSurveyAll($content, $customers);
        $this->data['modifyResult'] = Helpers::getResultExplainForSurveyAll($content, $customers, $weighConfig);
        $this->data['weighConfig'] = $weighConfig;
        $this->data['filterCounts'] = Helpers::getRealWeightForSurvey($content, $customers);

        return view('vendor.backpack.crud.download_pdf_sample', $this->data);
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
