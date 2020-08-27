<?php
/**
 * Created by PhpStorm.
 * User: tieungao
 * Date: 2020-08-26
 * Time: 15:31
 */

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController;

class CustomUserCrudController extends UserCrudController
{
    public function setup()
    {
        parent::setup(); // TODO: Change the autogenerated stub
        $this->crud->setRoute(backpack_url('custom-user'));
    }

    public function setupListOperation()
    {
        parent::setupListOperation();
        CRUD::addColumns([
            [
                // any type of relationship
                'name'         => 'company', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'Doanh Nghiệp', // Table column heading
                // OPTIONAL
                'entity'    => 'company', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => Company::class, // foreign key model
            ],
            [
                // any type of relationship
                'name'         => 'position', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'Chức Vụ', // Table column heading
                // OPTIONAL
                'entity'    => 'position', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => Position::class, // foreign key model
            ],
            [
                // any type of relationship
                'name'         => 'department', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'Phòng Ban', // Table column heading
                // OPTIONAL
                'entity'    => 'department', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => Department::class, // foreign key model
            ]
        ]);

        CRUD::removeColumn('roles');
        CRUD::removeColumn('permissions');
        CRUD::removeFilter('role');
        CRUD::removeFilter('permissions');


    }

    public function addUserFields()
    {
        //parent::addUserFields(); // TODO: Change the autogenerated stub


//        CRUD::modifyField('password', [
//            'name'  => 'password',
//            'label' => trans('backpack::permissionmanager.password'),
//            'type'  => 'password',
//            'attributes' => [
//                'autocomplete' => 'new-password'
//            ]
//        ]);

        CRUD::addFields([
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type'  => 'email',
            ],
            [
                'name'  => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type'  => 'password',
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
            ]
        ]);

        CRUD::addFields([
            [  // Select
                'label'     => "Doanh Nghiệp",
                'type'      => 'select',
                'name'      => 'company_id', // the db column for the foreign key
                'entity'    => 'company',
                'model'     => "App\Models\Company", // related model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
            ],
            [  // Select
                'label'     => "Chức Vụ",
                'type'      => 'select',
                'name'      => 'position_id', // the db column for the foreign key
                'entity'    => 'position',
                'model'     => "App\Models\Position", // related model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
            ],
            [  // Select
                'label'     => "Phòng Ban",
                'type'      => 'select',
                'name'      => 'department_id', // the db column for the foreign key
                'entity'    => 'department',
                'model'     => "App\Models\Department", // related model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
            ]
        ]);
    }
}