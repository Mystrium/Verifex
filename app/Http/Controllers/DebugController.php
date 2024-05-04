<?php
namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class DebugController extends BaseController {

    public function view(Request $request){
        dd(scandir('./images' . $request->path??''));
    }
}