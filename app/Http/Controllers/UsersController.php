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
            return back()->with('error', 'User Not Found');
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
        $friends_all = \DB::table('friendships')
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'friendships.sender_id')
                    ->orOn('users.id', '=', 'friendships.recipient_id');
            })
            ->where(function($query) {
                $query->where('friendships.sender_id', auth()->id())
                    ->orWhere('friendships.recipient_id', auth()->id());
            })
            ->where('friendships.status', 1)
            ->where('users.name', 'like', '%' . $search_term . '%')
            ->where('users.id', '!=', auth()->id())
            ->select('users.id', 'users.name', 'users.username', 'users.thumbnail', 'friendships.created_at AS friend_since');
        $friends_all_array = $friends_all->get()->toArray();

        $friends = $friends_all->paginate(10);

        if(count($friends) > 0)
        {
            echo '<p><b>' . count($friends_all_array) . '</b></p>';
            foreach($friends as $friend)
            {
                $user = User::find($friend->id); // Looks expensive! Could've selected user columns in join request above.
                echo '<a href="#" class="filterMembers all ';
                echo $user->isOnline() ? 'online' : 'offline';
                echo ' contact infinite-scroll-item" data-toggle="modal" data-target="#friendModal" data-friend-id="' . $friend->id . '" data-friend-name="' . $friend->name . '" data-friend-username="' . $friend->username . '" data-friend-thumbnail="' . $friend->thumbnail . '" data-friend-since="' . $friend->friend_since . '">';
                if($friend->thumbnail == NULL)
                {
                    echo '<img class="avatar-md" src="/storage/images/avatars/thumbnails/default_thumbnail.jpg" data-toggle="tooltip" data-placement="top" title="' . $friend->name . '" alt="avatar">';
                }
                else
                {
                    echo '<img class="avatar-md" src="/storage/images/avatars/thumbnails/' . $friend->thumbnail . '" data-toggle="tooltip" data-placement="top" title="' . $friend->name . '" alt="avatar">';
                }
                echo '<div class="status ';
                echo $user->isOnline() ? 'online' : 'offline';
                echo '"></div>
                    <div class="data">
                        <h5>' . $friend->name . '</h5>
                        <p>&#64;' . $friend->username . '</p>
                    </div>
                    <div class="person-add">
                        <i class="ti-user COMING FROM FRIEND SEARCH"></i>
                    </div>
                </a>';
            }

            echo '<div class="page-load-status-contacts text-center">';
                if(count($friends_all_array) > 10)
                {
                    echo '<p class="infinite-scroll-request">' .
                        'Loading... COMING FROM FRIEND SEARCH<br>' .
                    '</p>';
                }
            echo '</div>';

            $friends->links();
        }
        else
        {
            echo '<p>No friend found.</p>';
        }
    }

    // Make user online by sending AJAX request periodically if user is active
    public function make_user_online()
    {
        // This function does not do anything
    }

    // Send friend request
    public function send_friend_request(Request $request)
    {
        $username = $request->input('username');
        if($username === auth()->user()->username)
        {
            return back()->with('send_friend_request_error', 'You cannot send a friend request to yourself');
        }

        $user = User::where('username', '=', $username)->first();
        if(empty($user))
        {
            return back()->with('send_friend_request_error', 'User not found');
        }
        elseif(auth()->user()->isFriendWith($user))
        {
            return back()->with('send_friend_request_error', 'You are already friends');
        }
        elseif(auth()->user()->hasSentFriendRequestTo($user))
        {
            return back()->with('send_friend_request_error', 'You have already sent a friend request to this user');
        }
        elseif(auth()->user()->hasFriendRequestFrom($user))
        {
            return back()->with('send_friend_request_error', 'You already have a friend request from this user');
        }
        elseif(auth()->user()->hasBlocked($user))
        {
            return back()->with('send_friend_request_error', 'You have blocked this user');
        }
        elseif(auth()->user()->isBlockedBy($user))
        {
            return back()->with('send_friend_request_error', 'You have been blocked by this user');
        }
        else
        {
            auth()->user()->befriend($user);
            return back()->with('success', 'Friend request sent successfully');
        }
    }

    // Accept or deny a friend request
    public function friend_request_action(Request $request)
    {
        $sender_id = $request->input('sender_id');
        $action = $request->input('action');

        $auth_user = auth()->user();
        $sender = User::find($sender_id);

        if(empty($sender))
        {
            return back()->with('error', 'User not found');
        }
        else
        {
            if($action === 'accept')
            {
                $auth_user->acceptFriendRequest($sender);
                echo 'Friend request accepted.';
            }
            elseif($action === 'deny')
            {
                $auth_user->denyFriendRequest($sender);
                echo 'Friend request denied.';
            }
        }
    }

    // Remove friend
    public function remove_friend(Request $request)
    {
        $friend_id = $request->input('friend_id');

        $user = User::find($friend_id);

        if(empty($user))
        {
            return back()->with('error', 'User not found');
        }
        else
        {
            return auth()->user()->unfriend($user);
        }
    }

    // Block user
    public function block_user(Request $request)
    {
        $user_id = $request->input('user_id');

        $user = User::find($user_id);

        if(empty($user))
        {
            return back()->with('error', 'User not found');
        }
        else
        {
            return auth()->user()->blockFriend($user);
        }
    }
}
