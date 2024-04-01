<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Consist;
use App\Models\Item;


class SelfcostController extends BaseController {

    public function view(Request $request){
        $items = Item::select('items.id', 'items.url_photo', 'items.title', 'units.title as unit')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->whereNotIn('items.id', 
                Consist::select('have_id')
                    ->get()
                    ->toArray())
            ->get();

        foreach($items as $item){
            $item['subitems'] = DB::select(
                'WITH RECURSIVE TreeTraversal AS (
                    SELECT what_id, have_id, count, count AS total_count
                    FROM consists
                    WHERE what_id = 10
                    
                    UNION ALL
                    
                    SELECT c.what_id, c.have_id, c.count, c.count * tt.total_count
                    FROM consists c
                    INNER JOIN TreeTraversal tt ON c.what_id = tt.have_id
                )
                
                SELECT items.title, have_id, items.url_photo, units.title as unit, sum(total_count) as cnt
                FROM TreeTraversal
                INNER JOIN items on items.id = have_id
                INNER JOIN units on units.id = items.unit_id
                WHERE have_id NOT IN (SELECT what_id FROM consists)
                GROUP BY what_id;'
            );
        }

        return view('cost')
            ->withItems($items);
    }

}