<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;
use Illuminate\Support\Facades\DB;

use App\Item;

class ItemsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('Item')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $items = json_decode($request->getContent(), true);

            // Go through every item submitted and create it
            foreach($items as $elem)
            {
                $item = new Item();
                $item->name = $elem['name'];
                $item->quantity = 0;
                $item->capacity = $elem['capacity'];
                $item->low_threshold = $elem['low_threshold'];
                $item->is_food = $elem['is_food'];
                $item->refrigerated = $elem['refrigerated'];
                $item->created_at = date("Y-m-d H:i:s"); // updated_at uses the database timestamp
                $item->removed = false;
                $item->save();
            }
        }
        catch (Exception $e)
        {   // Log the exception. Only happens if the Json is not valid
            return response([
                'status' => 'item creation failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response([
            'status' => 'item created',
            'item_count' => count($items)], 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // TODO: TEST THIS TO MAKE SURE IT WORKS
        $item = Item::find($id);
        return view('pages.modifyItems')->with('item', $item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id The ID of the item we want to modify. Is the Primary key in the Item table.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $numRemoved = 0;
        try
        {
            $items = json_decode($request->getContent(), true);

            // Go through every item submitted and create it
            foreach($items as $elem)
            {
                $item = Item::find($elem['id']);
                $item->name = $elem['name'];
                $item->capacity = $elem['capacity'];
                $item->low_threshold = $elem['low_threshold'];
                $item->is_food = $elem['is_food'];
                $item->refrigerated = $elem['refrigerated'];
                $item->removed = $elem['removed'];
                $item->save();

                if ($item->removed == 'true')
                    $numRemoved++;

            }

            return response([
                'status' => 'item(s) modified',
                'items_modified' => count($items),
                'items_deleted' => $numRemoved], 200)
                ->header('Content-Type', 'text/plain');
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'item modification failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified item from storage. We don't really delete the item. We just
     * marked the 'removed' column for that item as true so we can filter it out. We want the
     * customer to be able to re-add old items that were once deleted if they need to.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->removed = true;
        $item->save();

        return response([
            'status' => 'item removed',
            'item_name' => $item->name,
            'item_quantity' => $item->quantity,
            'item_capacity' =>  $item->capacity,
            'item_threshold' => $item->low_threshold,
            'item_is_food' => $item->is_food,
            'item_refrigerated' => $item->created_at,
            'item_removed' => $item->removed], 200)
            ->header('Content-Type', 'text/plain');
    }
}


/* Old Store Function Code

$this->validate($request, [
            'name' => 'required',
            'capacity' => 'required',
            'threshold' => 'required',
            'isFood' => 'required',
            'refrigerated' => 'required'
        ]);

        try{
            $item = new Item;
            $item->name = $request->input('name');
            $item->quantity = 0;
            $item->capacity = $request->input('capacity');
            $item->low_threshold = $request->input('threshold');
            $item->is_food = $request->input('isFood');
            $item->refrigerated = $request->input('refrigerated');
            $item->created_at = date("Y-m-d H:i:s"); // updated_at uses the database timestamp
            $item->removed = false;
            $item->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'item creation failed',
                'error' => $e->getMessage()
            ], 500);
        }

//        return redirect('/new_items')->with('success', 'Item Added');
        return response([
            'status' => 'item created',
            'item_name' => $item->name,
            'item_quantity' => $item->quantity,
            'item_capacity' =>  $item->capacity,
            'item_threshold' => $item->low_threshold,
            'item_is_food' => $item->is_food,
            'item_refrigerated' => $item->created_at,
            'item_removed' => $item->removed], 200)
            ->header('Content-Type', 'text/plain');

*/
