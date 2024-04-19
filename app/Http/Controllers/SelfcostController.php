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
            ->whereIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get();

        foreach($items as $item){
            $item['subitems'] = DB::select(
                'WITH RECURSIVE TreeTraversal AS (
                    SELECT what_id, have_id, count, count AS total_count
                    FROM consists
                    WHERE what_id = ' . $item->id . '
                    
                    UNION ALL
                    
                    SELECT c.what_id, c.have_id, c.count, c.count * tt.total_count
                    FROM consists c
                    INNER JOIN TreeTraversal tt ON c.what_id = tt.have_id
                )
                
                SELECT itms.*, avg(price) as price
                FROM (
                    SELECT items.title, have_id, items.url_photo, items.description, units.title as unit, sum(total_count) as cnt
                    FROM TreeTraversal
                    INNER JOIN items ON items.id = have_id
                    INNER JOIN units ON units.id = items.unit_id
                    WHERE have_id NOT IN (SELECT what_id FROM consists)
                    GROUP BY have_id
                ) as itms
                LEFT OUTER JOIN purchases ON itms.have_id = purchases.item_id
                GROUP BY item_id'
            );

            $item['work'] = DB::select(
                'WITH RECURSIVE TreeTraversal AS (
                    SELECT what_id, have_id, count, i.price, count AS total_children
                    FROM consists
                    INNER JOIN items i on i.id = have_id
                    WHERE what_id = ' . $item->id . '
                    
                    UNION ALL
                    
                    SELECT c.what_id, c.have_id, c.count, i.price, t.total_children * c.count
                    FROM TreeTraversal AS t
                    JOIN consists AS c ON t.have_id = c.what_id
                    INNER JOIN items i on i.id = c.have_id
                )
                
                SELECT items.title, have_id, items.url_photo, items.description, total_children  as count, TreeTraversal.price
                FROM TreeTraversal
                INNER JOIN items ON items.id = have_id
                WHERE TreeTraversal.price <> 0'
            );
        }

        return view('cost')
            ->withItems($items);
    }

}
