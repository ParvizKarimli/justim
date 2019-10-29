<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Image as ImageLib;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($id + 0 !== auth()->id())
        {
            return back()->with('error', "Unauthorized Page");
        }

        $user = User::find($id);

        $custom_validation_messages = [
            'username.regex' => 'Only alphanumeric characters, numbers, and underscore symbol (_) allowed for username.'
        ];

        $this->validate($request, [
            'name' => 'required|string|max:35',
            'username' => 'required|string|max:15|regex:/^[\w]*$/|unique:users,username,'.$id,
            'email' => 'required|string|email|max:75|unique:users,email,'.$id,
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'mimes:png,jpg,gif,jpeg|nullable|max:4096',
        ], $custom_validation_messages);

        // Handle File Upload
        if($request->hasFile('avatar'))
        {
            // Delete old avatar if avatar and thumbnail is not null
            if($user->avatar)
            {
                // Delete old avatar
                unlink('storage/images/avatars/' . $user->avatar);

                // Delete old thumbnail
                unlink('storage/images/avatars/thumbnails/' . $user->thumbnail);
            }

            // Upload new avatar and thumbnail

            // Get just extension without filename
            $file_extension = $request->file('avatar')->getClientOriginalExtension();
            // File name salt
            $filename_salt = mt_rand() . '_' . time();
            // File name to store in DB
            $filename_to_store = $filename_salt . '.' . $file_extension;
            // Upload image to storage
            $request->file('avatar')->storeAs('public/images/avatars', $filename_to_store);

            // Create thumbnail file name
            $thumbnail_name_to_store = $filename_salt . '_thumbnail.' . $file_extension;
            // Create thumbnail of avatar and upload it to storage
            ImageLib::make('storage/images/avatars/' . $filename_to_store)
                ->resize(200, 200)
                ->save('storage/images/avatars/thumbnails/' . $thumbnail_name_to_store);
        }

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        if($request->hasFile('avatar'))
        {
            $user->avatar = $filename_to_store;
            $user->thumbnail = $thumbnail_name_to_store;
        }
        $user->save();

        return back()->with('success', 'User Updated');
    }

    public function nightmode(Request $request)
    {
        $user = auth()->user();

        if($user->nightmode == 0)
        {
            $user->nightmode = 1;
            $user->save();
        }
        else
        {
            $user->nightmode = 0;
            $user->save();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($id + 0 !== auth()->id())
        {
            return back()->with('password_to_delete_account_error', "Unauthorized page.");
        }

        $user = User::find($id);

        if(empty($user))
        {
            return redirect('/users')->with('error', 'User Not Found');
        }

        $this->validate($request, [
            'password_to_delete_account' => 'required|string|confirmed',
        ]);

        if(!password_verify($request->password_to_delete_account, $user->password))
        {
            return back()->with('password_to_delete_account_error', "Incorrect password.");
        }

        if($user->avatar)
        {
            // Delete cover image
            unlink('storage/images/avatars/' . $user->avatar);

            // Delete thumbnail
            unlink('storage/images/avatars/thumbnails/' . $user->thumbnail);
        }

        $user->delete();

        return back();
    }

    // Search friends using AJAX
    public function search_friends(Request $request)
    {
        $search_term = $request->input('search_term');
        $friends = User::join('friendships', function ($join) {
                $join->on('users.id', '=', 'friendships.sender_id')
                    ->orOn('users.id', '=', 'friendships.recipient_id');
            })
            ->where(function($query) {
                $query->where('friendships.sender_id', auth()->id())
                    ->orWhere('friendships.recipient_id', auth()->id());
            })
            ->where('users.name', 'like', '%' . $search_term . '%')
            ->where('users.id', '!=', auth()->id())
            ->paginate(10);

        echo '<ol>';
        foreach($friends as $friend)
        {
            echo '<li>' . $friend->name . '</li>';
        }
        echo '</ol>';
    }
}
