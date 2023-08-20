<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CoursesClientsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CoursesClientsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CoursesClientsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\CoursesClients::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/courses-clients');
        CRUD::setEntityNameStrings('цепочку продаж', 'цепочки продаж');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */

        CRUD::enableExportButtons();

        CRUD::column('clients_id')->label('Продавец');

        //CRUD::column('courses_id')->label('Текущий курс');

        #ссылочный просмотр привязок
        CRUD::column('courses_id')->wrapper([
            'href' => function($crud, $column, $entry){
                return backpack_url('course/' . $entry->courses_id . '/show');
            },
        ])->label('Текущий курс');

        CRUD::column('next_courses_id')->wrapper([
            'href' => function($crud, $column, $entry){
                return backpack_url('course/' . $entry->next_courses_id . '/show');
            },
        ])->label('Следующий курс');

        CRUD::column('key')->label('Ключ доступа');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CoursesClientsRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::field([
            'label' => "Клиент",
            'type' => 'select2',
            'name' => 'clients_id', // the method that defines the relationship in your Model
            'entity' => 'clients', // the method that defines the relationship in your Model
            'attribute' => 'email', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);

        CRUD::field([
            'label' => "Текущий курс",
            'type' => 'select2',
            'name' => 'courses_id', // the method that defines the relationship in your Model
            'entity' => 'courses', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);

        CRUD::field([
            'label' => "Следующий курс",
            'type' => 'select2',
            'name' => 'next_courses_id', // the method that defines the relationship in your Model
            'entity' => 'courses', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);

        CRUD::field('key')->label("Ключ доступа");
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
