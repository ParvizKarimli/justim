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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Chech if the logged in user is admin or
        // the user wants to delete itself.
        // Add 0 to string ($id comes from the url so it's a string) and
        // PHP will automatically convert it to number
        if(auth()->user()->role !== 'admin' && $id + 0 !== auth()->user()->id)
        {
            return redirect('dashboard')->with('error', __('pages.unauthorized'));
        }

        $user = User::find($id);
        if(empty($user))
        {
            return redirect('/users')->with('error', __('users.not_found'));
        }
        elseif($user->role === 'admin')
        {
            return redirect('/users')->with('error', __('users.admin_delete'));
        }

        // Delete posts of the user to be deleted
        $posts = Post::where('user_id', $id)->cursor();
        foreach($posts as $post)
        {
            if($post->cover_image && $post->cover_image !== 'noimage.jpg')
            {
                // Delete cover image
                unlink('storage/images/cover_images/' . $post->cover_image);

                // Delete thumbnail
                unlink('storage/images/cover_images/thumbnails/' . $post->thumbnail);
            }

            $images = $post->images;
            foreach($images as $image)
            {
                unlink('storage/images/' . $image->filename);
                unlink('storage/images/thumbnails/' . $image->filename_thumb);
            }

            Image::where('post_id', $post->id)->delete();

            Bookmark::where('post_id', $post->id)->delete();

            // Delete from DB
            $post->delete();
        }

        $user->delete();

        return redirect('users')->with('success', __('users.removed'));
    }
}
