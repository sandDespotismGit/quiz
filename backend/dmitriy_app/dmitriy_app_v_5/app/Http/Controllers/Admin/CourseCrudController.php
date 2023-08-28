<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseRequest;
use App\Models\Collaboration;
use App\Models\Course;
use App\Models\CoursesClients;
use App\Models\Cryptogram;
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
        CRUD::column('main_image')->type('image')->label('Изображение');
        CRUD::column('description')->label('Описание');
        CRUD::column('other_image')->type('image')->label('Доп. изображение');
        CRUD::column('full_description')->label('Дополнительное описание');
        CRUD::column('is_active')->label('Статус курса');
        CRUD::column('is_bump')->label('Возможность покупки в комплекте');

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
        //CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::field([
            'label' => "Коллаборации",
            'type' => 'select2',
            'name' => 'collaboration_id', // the method that defines the relationship in your Model
            'entity' => 'collaborations', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);

        CRUD::field([
            'label'        => "Изображение",
            'name'         => "main_image",
            'filename'     => "image_filename", // set to null if not needed
            'type'         => 'image',
            'aspect_ratio' => 1, // set to 0 to allow any aspect ratio
            'crop'         => true, // set to true to allow cropping, false to disable
            'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
        ]);

        CRUD::field('name')->label("Название");
        CRUD::field('description')->label("Описание");
        CRUD::field('full_description')->label("Дополнительное описание");

        CRUD::field([
            'label'        => "Дополнительное изображение",
            'name'         => "other_image",
            'filename'     => "image_filename", // set to null if not needed
            'type'         => 'image',
            'aspect_ratio' => 1, // set to 0 to allow any aspect ratio
            'crop'         => true, // set to true to allow cropping, false to disable
            'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
        ]);

        CRUD::field([
            'label' => "Тарифы",
            'type' => 'select2',
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

        CRUD::field('is_bump')->label("Сделать продукт доступным для комплекта?");
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

    //для страницы по обработке заказа
    public function purchaseCourse($id, $key=null){
        if($key == null){
            $mainCourse = CoursesClients::where('courses_id', $id)->first();
        }
        else {
            $mainCourse = CoursesClients::where('courses_id', $id)->where('key', $key)->first();
        }

        $course = Course::find($mainCourse->courses_id);
        $rate = Rate::all();
        $collab = Collaboration::find($course->collaboration_id);
        $bump = DB::table('courses')->where('id', '!=', $course->id)->where('is_bump', '=', 1)->limit(2)->get();
        $bump_price = DB::table('rates')
            ->whereIn('id', [$bump[0]->rate_id, $bump[1]->rate_id])->inRandomOrder()
            ->get();

        $crypto = Cryptogram::find(1); //ищу по id = 1

        if($bump_price->count() == 1){
            $bump_price->push($bump_price[0]);
        }

        $collection = collect($bump)->zip($bump_price)->transform(function ($values) {
            return [
                'course' => $values[0],
                'rate' => $values[1],
            ];
        });

        if($mainCourse->next_courses_id == null){
            return view('inc.finish', ['data' => ['Спасибо за покупку!']]);
        }
        else {
            return view('inc.purchase', ['data' => [$course, $rate, $collection, $collab, $crypto, $mainCourse]]);
        }
    }

    public function downCourse($key){
        $mainCourse = CoursesClients::all()->whereNull('next_courses_id')->where('key', $key)->first();

        $course = Course::find($mainCourse->courses_id);
        $rate = Rate::all();
        $collab = Collaboration::find($course->collaboration_id);
        $bump = DB::table('courses')->where('id', '!=', $course->id)->where('is_bump', '=', 1)->limit(2)->get();
        $bump_price = DB::table('rates')
            ->whereIn('id', [$bump[0]->rate_id, $bump[1]->rate_id])->inRandomOrder()
            ->get();

        $crypto = Cryptogram::find(1); //ищу по id = 1

        if($bump_price->count() == 1){
            $bump_price->push($bump_price[0]);
        }

        $collection = collect($bump)->zip($bump_price)->transform(function ($values) {
            return [
                'course' => $values[0],
                'rate' => $values[1],
            ];
        });

        return view('inc.purchase', ['data' => [$course, $rate, $collection, $collab, $crypto, $mainCourse]]);
    }
}
