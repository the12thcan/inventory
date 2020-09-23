<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Member_Position;
use Illuminate\Http\Request;
use App\User;
use Notification;
use Illuminate\Support\Facades\DB;
use App\Notifications\UserAcceptance;

class UsersController extends Controller
{
    /**
     * Gets all of the users from the database to display in the admin panel.
     * @return array Returns all information for all users
     */
    public function index()
    {
        return DB::select('select * from users');
    }

    /**
     * Gets all of the users who are current members of the 12th Can.
     * @return array Returns all information for users who are members.
     */
    public static function getCurrentMembers()
    {
        return json_encode(DB::select('select * from users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id ID of the user specified
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'phone' => 'required',
            'current_member' => 'required',
            'position_id' => 'required'
        ]);
        // TODO: WRITE TESTS FOR THIS
        try
        {
            $position = Member_Position::find($request->input('position_id'));
            $user = User::find($id);
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->current_member = $request->input('current_member');
            $user->position()->associate($position);

//            $user->position_id = $request->input('position_id');

            $user->save();
        }
        catch (Exception $e)
        {
            // Attempt to catch a bad database store
            return response([
                'status' => 'User Info Modification Failed',
                'error' => $e->getMessage()
            ], 500);
        }

        return response([
            'status' => 'User Info Modification Succeeded',
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'user_current_member' =>  $user->current_member,
            'user_position_id' => strval($user->position_id)], 200)
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
        $user = User::find($id);
        //console.log("Help");
        $localEmail = $user->email;
        $localName = $user->name;
        $user->delete();
        Notification::route('mail', $localEmail)->notify(new UserAcceptance($localName));
    }
}
