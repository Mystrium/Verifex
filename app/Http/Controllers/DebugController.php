<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class DebugController extends BaseController {

    public function view(Request $request){
        dd(scandir('.' . $request->path??''));
    }

    public function create(){
        
    }
}