<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

class ServiceOperator
{
    public function index()
    {
        echo "Class <strong>ServiceOperator</strong> with method index. ";
        return $this;
    }

    public function zero()
    {
        echo "Object <strong>Zero</strong>";
        return $this;
    }

    public function container()
    {
        echo "Object <strong>Container</strong>";
        return $this;
    }

    public function show(string $name)
    {
        echo "<strong>Hide Implement</strong>. ";
        echo "Call method Static as Non Static. ";
        echo "Object <strong>Facade</strong> with argument is <strong>$name</strong>";
        return $this;
    }
}

Route::get('/zero', function () {
    $service = new ServiceOperator();
    $service->index()->zero();
});

Route::get('/container', function (ServiceOperator $service) {
    $service->index()->container();
});

class Operator extends Facade
{
    protected static function getFacadeAccessor()
    {
        // return ServiceOperator::class;
        return 'serviceoperator';
    }
}

Route::get('/facade', function () {
    Operator::index()->show("dakasakti");
});
