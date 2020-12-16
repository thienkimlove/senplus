<?php

namespace App\Http\Controllers\Admin;

use App\Helpers;
use App\Http\Requests\PostRequest;
use App\Models\Topic;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PostCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Post::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/post');
        CRUD::setEntityNameStrings('Bài Viết', 'Bài Viết');

        CRUD::denyAccess('list');
        CRUD::denyAccess('create');
        CRUD::denyAccess('update');
        CRUD::denyAccess('delete');

        if (backpack_user()->hasAnyRole(['admin', 'editor'])) {
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

        CRUD::column('name')->label('Tiêu đề bài viết');
        CRUD::column('views')->label('Lượt xem')->type('number');

        CRUD::addColumn(['name' => 'image', 'type' => 'image', 'label' => 'Ảnh']);
        CRUD::addColumn(['name' => 'anh2', 'type' => 'image', 'label' => 'Ảnh 2']);

        CRUD::addColumn([
            'name' => 'author_id',
            'entity' => 'author',
            'attribute' => 'name',
            'model' => 'App\Models\Author',
            'type' => 'select',
            'label' => 'Tác Giả'
        ]);

        CRUD::addColumn([
            'label'     => 'Các chủ đề',
            'type'      => 'select_multiple',
            'name'      => 'topics',
            'entity'    => 'topics',
            'attribute' => 'name',
            'model'     => 'App\Models\Topic'
        ]);

        CRUD::addColumn([
            'name' => 'status',
            'type' => 'select_from_array',
            'label' => 'Trạng thái',
            'options' => Helpers::YES_NO
        ]);



        CRUD::addFilter([
            'name'  => 'topic_filter',
            'type'  => 'select2',
            'label' => 'Theo chủ đề'
        ], function () {
            return Topic::pluck('name', 'id')->all();
        }, function ($value) { // if the filter is active
            CRUD::addClause('where', function($query) use ($value) {
                $query->whereHas('topics', function($q) use($value) {
                    $q->where('id', $value);
                });
            });
        });



    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PostRequest::class);

        //CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */

        CRUD::field('name')->label('Tiêu đề');

        CRUD::addField(['name' => 'desc', 'type' => 'textarea', 'label' => 'Mô tả']);
        CRUD::addField(
            [   // CKEditor
                'name'          => 'content',
                'label'         => 'Nội dung',
                'type'          => 'ckeditor',

                // optional:
                'extra_plugins' => ['justify', 'font'],
                'options'       => [
                    'autoGrow_minHeight'   => 200,
                    'autoGrow_bottomSpace' => 50,
                    //'removePlugins'        => 'resize,maximize',
                ]
            ]
        );
        CRUD::addField(['name' => 'image', 'type' => 'browse', 'label' => 'Ảnh']);
        CRUD::addField(['name' => 'anh2', 'type' => 'browse', 'label' => 'Ảnh 2']);

        CRUD::addField([
            'name' => 'author_id',
            'entity' => 'author',
            'attribute' => 'name',
            'model' => 'App\Models\Author',
            'type' => 'select2',
            'label' => 'Tác Giả',
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }), //  you can use this to filter the results show in the select
        ]);


        CRUD::addField([
            'label'     => 'Các chủ đề',
            'type'      => 'select2_multiple',
            'name'      => 'topics',
            'entity'    => 'topics',
            'attribute' => 'name',
            'model'     => 'App\Models\Topic'
        ]);


        CRUD::addField([
            'name' => 'status',
            'type' => 'select_from_array',
            'label' => 'Trạng thái',
            'options' => Helpers::YES_NO
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
