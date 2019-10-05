<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
            // Delete old avatar if avatar is not null
            if($user->avatar)
            {
                // Delete old avatar
                unlink('storage/images/avatars/' . $user->avatar);
            }

            // Upload new avatar
            // Get just extension without filename
            $file_extension = $request->file('avatar')->getClientOriginalExtension();
            // File name salt
            $filename_salt = mt_rand() . '_' . time();
            // File name to store in DB
            $filename_to_store = $filename_salt . '.' . $file_extension;
            // Upload image to storage
            $request->file('avatar')->storeAs('public/images/avatars', $filename_to_store);
        }

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        if($request->hasFile('avatar'))
        {
            $user->avatar = $filename_to_store;
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

        $user->delete();

        return back()->with('success', 'User Deleted');
    }
}
