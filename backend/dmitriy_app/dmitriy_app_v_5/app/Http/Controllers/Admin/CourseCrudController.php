<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Rate;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class CourseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CourseCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Course::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/course');
        CRUD::setEntityNameStrings('курс', 'курсы');
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
        CRUD::enableDetailsRow();

        CRUD::addFilter([
            'type' => 'simple',
            'name' => 'is_active',
            'label' => 'Только подписки',
            'display' => 'Показать только активные курсы',
        ],
            false,
            function() {
                CRUD::addClause('where', 'is_active', '1');
        });

        CRUD::addFilter([
                'type' => 'select2',
                'name' => 'Типы тарифов',
                'display' => 'По тарифам',
            ],
            Rate::all()->pluck('name', 'id')->toArray(),
            function($key) {
                CRUD::addClause('where', 'rate_id', $key);
        });

        CRUD::column('id')->type('my_custom_colunm')->label('Номер');

        //подкачка коллабораций
        CRUD::column('collaboration_id')->wrapper([
            'href' => function($crud, $column, $entry){
                return backpack_url('collaboration/' . $entry->collaboration_id . '/show');
            },
        ])->label('Коллаборация');

        CRUD::column('name')->prefix('RU_')->label('Название');
        CRUD::column('description')->label('Описание');
        CRUD::column('is_active')->label('Статус курса');

        //подкачка тарифов
        CRUD::column('rate_id')->wrapper([
            'href' => function($crud, $column, $entry){
                return backpack_url('rate/' . $entry->rate_id . '/show');
            },
        ])->label('Тариф');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        //CRUD::setValidation(CourseRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::field([
            'label' => "Коллаборации",
            'type' => 'select',
            'name' => 'collaboration_id', // the method that defines the relationship in your Model
            'entity' => 'collaborations', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);

        CRUD::field('name')->label("Название");
        CRUD::field('description')->label("Описание");

        CRUD::field([
            'label' => "Тарифы",
            'type' => 'select',
            'name' => 'rate_id', // the method that defines the relationship in your Model
            'entity' => 'rates', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);

        CRUD::field([   // radio
            'name'        => 'is_active', // the name of the db column
            'label'       => 'Тип оплаты', // the input label
            'type'        => 'radio',
            'options'     => [
                // the key will be stored in the db, the value will be shown as label;
                0 => "Разовая",
                1 => "Подписка"
            ],
            // optional
            //'inline'      => false, // show the radios all on the same line?
        ]);
    }

    public function showDetailsRow($id){
        return 'Данный курс был создан  ' . CRUD::getCurrentEntry()->created_at->diffForHumans() . '.';
    }

    public function rates()
    {
        return $this->belongsToMany('App\Models\Rate', 'article_tag');
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

    public function allData(){
        return view('inc\course_list', ['data' => Course::all()]);
    }

    public function purchaseCourse($id){
        $course = Course::find($id);
        $rate = Rate::find($course->rate_id);

        return view('inc.purchase', ['data' => [$course, $rate]]);
    }
}
