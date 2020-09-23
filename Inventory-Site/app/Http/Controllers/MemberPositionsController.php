<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member_Position;
use PhpParser\Node\Expr\PostDec;
use Illuminate\Support\Facades\DB;

class MemberPositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = DB::select('select * from Member_Position');
        return $positions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'position' => 'required|string',
            'privilege' => 'required|integer',
            'description' => 'required|string',
            'email' => 'required|string',
            'low_notify' => 'required|boolean'
        ]);

        try
        {
            $position = new Member_Position();
            $position->position = $request->input('position');
            $position->privilege = $request->input('privilege');
            $position->description = $request->input('description');
            $position->email = $request->input('email');
            $position->created_at = date("Y-m-d H:i:s");
            $position->low_notify = $request->input('low_notify');

            $position->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'Member Position creation failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response([
            'status' => 'position creation succeeded',
            'position' => $position->position,
            'position_privilege' => $position->privilege,
            'position_email' =>  $position->email], 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id ID of the member position we need to modify
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'position' => 'required|string',
            'privilege' => 'required|integer',
            'description' => 'required|string',
            'email' => 'required|string',
            'low_notify' => 'required|boolean'
        ]);
        try
        {
            $position = Member_Position::find($id);
            $position->position = $request->input('position');
            $position->privilege = $request->input('privilege');
            $position->description = $request->input('description');
            $position->email = $request->input('email');
            $position->low_notify = $request->input('low_notify');

            $position->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'Member Position modification failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response([
            'status' => 'position modification succeeded',
            'position' => $position->position,
            'position_privilege' => $position->privilege,
            'position_email' =>  $position->email,
            'low_notify' => $position->low_notify], 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $position = Member_Position::find($id);
            $position->delete();

        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'Member Position deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response([
            'status' => 'position deleted',
            'position_deleted' => $id
        ]);
    }
}
