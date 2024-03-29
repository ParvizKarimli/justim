<div class="sidebar" id="sidebar">
    <div class="container">
        <div class="col-md-12">
            <div class="tab-content">
                <!-- Start of Contacts -->
                <div class="tab-pane fade" id="members">
                    <figure class="setting">
                        @if(auth()->user()->thumbnail == NULL)
                            <img class="avatar-xl" src="/storage/images/avatars/thumbnails/default_thumbnail.jpg" alt="avatar">
                        @else
                            <img class="avatar-xl" src="/storage/images/avatars/thumbnails/{{ auth()->user()->thumbnail }}" alt="avatar">
                        @endif
                    </figure>
                    <span class="logo"><img alt="" src="/storage/images/logo.png"></span>
                    <br><br>
                    <div class="card">
                        <button class="btn btn-link" data-toggle="modal" data-target="#friendRequestsModal">
                            @if(count($friend_requests) > 0)
                                <span title="You have a new friend request">
                                    <svg height="10" width="10">
                                        <circle cx="5" cy="5" r="4" stroke="red" stroke-width="0" fill="red" />
                                    </svg>
                                </span>
                            @endif
                            Friend Requests ({{ $friend_requests_count }})
                        </button>
                    </div>
                    <div class="search">
                        <form class="form-inline position-relative">
                            <input type="search" name="search_term" onkeyup="getFriendsBySearchTerm(this.value)" class="form-control" id="people" placeholder="Search friends" autocomplete="off">
                            <button type="button" class="btn loop"><i class="ti-search"></i></button>
                        </form>
                    </div>
                    <div class="contacts">
                        <h1>
                            Friends ({{ auth()->user()->getFriendsCount() }})
                            <button class="btn" data-toggle="modal" data-target="#sendFriendRequestModal" title="Add New Friend">
                                <i class="ti-user">+</i>
                            </button>
                        </h1>
                        <div class="list-group" id="contacts" role="tablist">
                            @if(auth()->user()->getFriendsCount() === 0)
                                <p>There is no friend in your contacts.</p>
                            @else
                                @foreach($friends as $friend)
                                    <a href="#" class="filterMembers all {{ $friend->isOnline() ? 'online' : 'offline' }} contact" data-toggle="modal" data-target="#friendModal" data-friend-id="{{ $friend->id }}" data-friend-name="{{ $friend->name }}" data-friend-username="{{ $friend->username }}" data-friend-avatar="{{ $friend->avatar }}" data-friend-since="{{ date('F j, Y H:i', strtotime(auth()->user()->getFriendship($friend)->created_at)) }}">
                                        @if($friend->thumbnail == NULL)
                                            <img class="avatar-md" src="/storage/images/avatars/thumbnails/default_thumbnail.jpg" data-toggle="tooltip" data-placement="top" title="{{ $friend->name }}" alt="avatar">
                                        @else
                                            <img class="avatar-md" src="/storage/images/avatars/thumbnails/{{ $friend->thumbnail }}" data-toggle="tooltip" data-placement="top" title="{{ $friend->name }}" alt="avatar">
                                        @endif
                                        <div class="status {{ $friend->isOnline() ? 'online' : 'offline' }}"></div>
                                        <div class="data">
                                            <h5>{{ $friend->name }}</h5>
                                            <p>&#64;{{ $friend->username }}</p>
                                        </div>
                                        <div class="person-add">
                                            <i class="ti-user COMING FROM OUT OF FRIEND SEARCH"></i>
                                        </div>
                                    </a>
                                @endforeach
                                <div class="page-load-status-contacts text-center">
                                    @if(auth()->user()->getFriendsCount() > 10)
                                        <p class="infinite-scroll-request">
                                            Loading...<br>
                                            <!--<img src="/storage/images/default/loader.svg">-->
                                        </p>
                                    @endif
                                </div>
                                {{ $friends->links() }}
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End of Contacts -->
                <!-- Start of Discussions -->
                <div id="discussions" class="tab-pane fade in{{ count($errors)==0 ? ' active show' : '' }}">
                    <figure class="setting">
                        @if(auth()->user()->thumbnail == NULL)
                            <img class="avatar-xl" src="/storage/images/avatars/thumbnails/default_thumbnail.jpg" alt="avatar">
                        @else
                            <img class="avatar-xl" src="/storage/images/avatars/thumbnails/{{ auth()->user()->thumbnail }}" alt="avatar">
                        @endif
                    </figure>
                    <span class="logo"><img src="/storage/images/logo.png" alt=""></span>
                    <div class="search">
                        <form class="form-inline position-relative">
                            <input type="search" class="form-control" id="conversations" placeholder="Search for conversations...">
                            <button type="button" class="btn btn-link loop"><i class="ti-search"></i></button>
                        </form>
                        <button class="btn create" data-toggle="modal" data-target="#startnewchat"><i class="ti-pencil"></i></button>
                    </div>
                    <div class="list-group sort">
                        <button class="btn filterDiscussionsBtn active show" data-toggle="list" data-filter="all">All</button>
                        <button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="read">Favourit</button>
                        <button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="unread">Unread</button>
                    </div>
                    <div class="discussions" id="scroller">
                        <h1>Chats</h1>
                        <div class="btn-group add-group" role="group">
                            <button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Add +
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="#">New user</a>
                                <a class="dropdown-item" href="#">New Group +</a>
                                <a class="dropdown-item" href="#">Private Chat +</a>
                            </div>
                        </div>
                        <div class="list-group" id="chats" role="tablist">
                            <a href="#list-chat" class="filterDiscussions all unread single active" id="list-chat-list" data-toggle="list" role="tab">
                                <img class="avatar-md" src="/storage/images/avatars/thumbnails/avatar-female-1.jpg" data-toggle="tooltip" data-placement="top" title="Sarah" alt="avatar">
                                <div class="status online"></div>

                                <div class="data">
                                    <h5>Sarah Dalton</h5>
                                    <div class="new bg-yellow">
                                        <span>5+</span>
                                    </div>
                                    <span>Mon</span>
                                    <p>A new feature has been updated...</p>
                                </div>
                            </a>
                            <a href="#list-empty" class="filterDiscussions all unread single" id="list-empty-list" data-toggle="list" role="tab">
                                <img class="avatar-md" src="/storage/images/avatars/thumbnails/avatar-male-1.jpg" data-toggle="tooltip" data-placement="top" title="Michael" alt="avatar">
                                <div class="status offline"></div>

                                <div class="data">
                                    <h5>Bob Frank</h5>
                                    <div class="new bg-red">
                                        <span>9+</span>
                                    </div>
                                    <span>Sun</span>
                                    <p>How can i improve my chances?</p>
                                </div>
                            </a>
                            <a href="#list-chat" class="filterDiscussions all read single" id="list-chat-list2" data-toggle="list" role="tab">
                                <img class="avatar-md" src="/storage/images/avatars/thumbnails/avatar-female-2.jpg" data-toggle="tooltip" data-placement="top" title="Lucy" alt="avatar">
                                <div class="status online"></div>
                                <div class="data">
                                    <h5>Lucy Grey</h5>
                                    <span>Tus</span>
                                    <p>Typing...</p>
                                </div>
                            </a>
                            <a href="#list-empty" class="filterDiscussions all read single" id="list-empty-list2" data-toggle="list" role="tab">
                                <img class="avatar-md" src="/storage/images/avatars/thumbnails/avatar-male-2.jpg" data-toggle="tooltip" data-placement="top" title="james idoms" alt="avatar">
                                <div class="status offline"></div>
                                <div class="data">
                                    <h5>james idoms</h5>
                                    <span>5 mins</span>
                                    <p>By injected humour, or randomi...</p>
                                </div>
                            </a>
                            <a href="#list-chat" class="filterDiscussions all read single" id="list-chat-list3" data-toggle="list" role="tab">
                                <img class="avatar-md" src="/storage/images/avatars/thumbnails/avatar-female-3.jpg" data-toggle="tooltip" data-placement="top" title="Linda Gates" alt="avatar">
                                <div class="status away"></div>
                                <div class="data">
                                    <h5>Linda gates</h5>
                                    <span>Mon</span>
                                    <p>No more running out of the office...</p>
                                </div>
                            </a>
                            <a href="#list-empty" class="filterDiscussions all read single" id="list-empty-list3" data-toggle="list" role="tab">
                                <img class="avatar-md" src="/storage/images/avatars/thumbnails/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Karen joye" alt="avatar">
                                <div class="status online"></div>
                                <div class="data">
                                    <h5>Karen joye</h5>
                                    <span>Fri</span>
                                    <p>All your favourite books at...</p>
                                </div>
                            </a>
                            <a href="#list-chat" class="filterDiscussions all unread single" id="list-chat-list4" data-toggle="list" role="tab">
                                <img class="avatar-md" src="/storage/images/avatars/thumbnails/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Lisa Honey" alt="avatar">
                                <div class="status offline"></div>

                                <div class="data">
                                    <h5>Lisa Honey</h5>
                                    <div class="new bg-indigo">
                                        <span>1+</span>
                                    </div>
                                    <span>Feb 10</span>
                                    <p>Be the first to know about...</p>
                                </div>
                            </a>
                            <a href="#list-empty" class="filterDiscussions all read single" id="list-empty-list4" data-toggle="list" role="tab">
                                <img class="avatar-md" src="/storage/images/avatars/thumbnails/avatar-male-3.jpg" data-toggle="tooltip" data-placement="top" title="Daniel Cabral" alt="avatar">
                                <div class="status offline"></div>
                                <div class="data">
                                    <h5>Daniel Cabral</h5>
                                    <span>Feb 9</span>
                                    <p>Dear Daniel Cabral, your massage is today...</p>
                                </div>
                            </a>
                            <a href="#list-chat" class="filterDiscussions all unread single" id="list-chat-list5" data-toggle="list" role="tab">
                                <img class="avatar-md" src="/storage/images/avatars/thumbnails/avatar-male-4.jpg" data-toggle="tooltip" data-placement="top" title="Jhon Doe" alt="avatar">
                                <div class="status online"></div>

                                <div class="data">
                                    <h5>Jhon Doe</h5>
                                    <div class="new bg-green">
                                        <span>4+</span>
                                    </div>
                                    <span>Thu</span>
                                    <p>Unfortunately session cancelled..</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End of Discussions -->
                <!-- Start of Notifications -->
                <div id="notifications" class="tab-pane fade">
                    <figure class="setting">
                        @if(auth()->user()->thumbnail == NULL)
                            <img class="avatar-xl" src="/storage/images/avatars/thumbnails/default_thumbnail.jpg" alt="avatar">
                        @else
                            <img class="avatar-xl" src="/storage/images/avatars/thumbnails/{{ auth()->user()->thumbnail }}" alt="avatar">
                        @endif
                    </figure>
                    <span class="logo"><img alt="" src="/storage/images/logo.png"></span>
                    <br><br>
                    <div class="notifications">
                        <h1>Notifications</h1>
                        <div class="list-group" id="alerts" role="tablist">
                            @if(count($notifications) === 0)
                                <p>You have no notification.</p>
                            @else
                                @foreach($notifications as $notification)
                                    <a href="#" class="filterNotifications all latest notification {{ is_null($notification->read_at) ? '' : 'notification-read'}}" id="{{ $notification->id }}" onclick="event.preventDefault();">
                                        @if($notification->data['thumbnail'] == NULL)
                                            <img class="avatar-md" src="/storage/images/avatars/thumbnails/default_thumbnail.jpg" data-toggle="tooltip" data-placement="top" title="{{ $notification->data['name'] }}" alt="avatar">
                                        @else
                                            <img class="avatar-md" src="/storage/images/avatars/thumbnails/{{ $notification->data['thumbnail'] }}" data-toggle="tooltip" data-placement="top" title="{{ $notification->data['name'] }}" alt="avatar">
                                        @endif
                                        <div class="data">
                                            <p>{{ $notification->data['name'] }} (&#64;{{ $notification->data['username'] }}) accepted your friend request.</p>
                                            <span>{{ date('F j, Y \a\t H:i', strtotime($notification->created_at)) }}</span>
                                            <span title="Mark as read" class="float-right notif-read-toggle-btn" onclick="notifReadToggle(this);">
                                                @if(is_null($notification->read_at))
                                                    &#9899;
                                                @else
                                                    &#9898;
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                                <div class="page-load-status-notifications text-center">
                                    @if($number_of_unread_notifications > 10)
                                        <p class="infinite-scroll-request">
                                            Loading...<br>
                                            <!--<img src="/storage/images/default/loader.svg">-->
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End of Notifications -->
                <!-- Start of Settings -->
                <div class="tab-pane fade{{ count($errors)>0 ? ' active show' : '' }}" id="settings">
                    <div class="settings">
                        <div class="profile">
                            @if(auth()->user()->thumbnail == NULL)
                                <img class="avatar-xl" src="/storage/images/avatars/thumbnails/default_thumbnail.jpg" alt="avatar">
                            @else
                                <img class="avatar-xl" src="/storage/images/avatars/thumbnails/{{ auth()->user()->thumbnail }}" alt="avatar">
                            @endif
                            <h1><a href="#">{{ auth()->user()->name }}</a></h1>
                            <span>&#64;{{ auth()->user()->username }}</span>

                        </div>
                        <div class="categories" id="accordionSettings">
                            <h1>Settings</h1>
                            <!-- Start of My Account -->
                            <div class="category">
                                <a href="#" class="title{{ count($errors)>0 ? '' : ' collapsed' }}" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="{{ count($errors)>0 ? 'true' : 'false' }}" aria-controls="collapseOne">
                                    <i class="ti-user"></i>
                                    <div class="data">
                                        <h5>My Account</h5>
                                        <p>Update your profile details</p>
                                    </div>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <div class="collapse{{ count($errors)>0 ? ' show' : '' }}" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionSettings">
                                    <div class="content">
                                        <form action="/users/{{ auth()->id() }}" method="POST" enctype="multipart/form-data">
                                            {{ method_field('PATCH') }}
                                            {{ csrf_field() }}

                                            @if(count($errors) > 0 && !$errors->has('password_to_delete_account'))
                                                <p class="alert-danger">
                                                    Error updating account credentials! Check out the errors below for more information.
                                                </p>
                                            @endif

                                            <div class="upload{{ $errors->has('avatar') ? ' has-error' : '' }}">
                                                <div class="data">
                                                    @if(auth()->user()->thumbnail == NULL)
                                                        <img class="avatar-xl" id="avatar-xl" src="/storage/images/avatars/thumbnails/default_thumbnail.jpg" alt="avatar">
                                                        <label>
                                                            <input type="file" id="avatar-input" name="avatar" accept=".jpg, .jpeg, .png, .gif">
                                                            <span class="btn button">
                                                                Upload Avatar
                                                            </span>
                                                        </label>
                                                    @else
                                                        <img class="avatar-xl" id="avatar-xl" src="/storage/images/avatars/thumbnails/{{ auth()->user()->thumbnail }}" alt="avatar">
                                                        <label>
                                                            <input type="file" id="avatar-input" name="avatar" accept=".jpg, .jpeg, .png, .gif">
                                                            <span class="btn button">
                                                                Change Avatar
                                                            </span>
                                                        </label>
                                                    @endif
                                                </div>
                                                @if ($errors->has('avatar'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('avatar') }}</strong>
                                                    </span>
                                                @endif
                                                <p>For better results, use an image at least 200px by 200px in .jpg or .png format.</p>
                                            </div>
                                            <div class="field{{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ auth()->user()->name }}" required>
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="field{{ $errors->has('username') ? ' has-error' : '' }}">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="{{ auth()->user()->username }}" required>
                                                @if ($errors->has('username'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('username') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" value="{{ auth()->user()->email }}" required>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required minlength="8">
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="field">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter password again" required minlength="8">
                                            </div>
                                            <button type="submit" class="btn button w-100">Update</button>
                                        </form>
                                        <!-- Trigger the delete account modal with a button -->
                                        <a class="btn btn-link w-100" href="" title="Delete Your Account" data-toggle="modal" data-target="#deleteAccountModal">
                                            Delete Account
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- End of My Account -->
                            <!-- Start of Chat History -->
                            <div class="category">
                                <a href="#" class="title collapsed" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    <i class="ti-comments"></i>
                                    <div class="data">
                                        <h5>Chats</h5>
                                        <p>Check your chat history</p>
                                    </div>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionSettings">
                                    <div class="content layer">
                                        <div class="history">
                                            <p>When you clear your conversation history, the messages will be deleted from your own device.</p>
                                            <p>The messages won't be deleted or cleared on the devices of the people you chatted with.</p>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="same-address">
                                                <label class="custom-control-label" for="same-address">Hide will remove your chat history from the recent list.</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="save-info">
                                                <label class="custom-control-label" for="save-info">Delete will remove your chat history from the device.</label>
                                            </div>
                                            <button type="submit" class="btn button w-100">Clear Chat History</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Chat History -->
                            <!-- Start of Notifications Settings -->
                            <div class="category">
                                <a href="#" class="title collapsed" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    <i class="ti-bell"></i>
                                    <div class="data">
                                        <h5>Notifications</h5>
                                        <p>Turn notifications on or off</p>
                                    </div>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionSettings">
                                    <div class="content no-layer">
                                        <div class="set">
                                            <div class="details">
                                                <h5>Desktop Notifications</h5>
                                                <p>You can set up Talkshak to receive notifications when you have new messages.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Unread Message Badge</h5>
                                                <p>If enabled shows a red badge on the Talkshak app icon when you have unread messages.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Taskbar Flashing</h5>
                                                <p>Flashes the Talkshak app on mobile in your taskbar when you have new notifications.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Notification Sound</h5>
                                                <p>Set the app to alert you via notification sound when you have unread messages.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Vibrate</h5>
                                                <p>Vibrate when receiving new messages (Ensure system vibration is also enabled).</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Turn On Lights</h5>
                                                <p>When someone send you a text message you will receive alert via notification light.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Notifications Settings -->
                            <!-- Start of Connections -->
                            <div class="category">
                                <a href="#" class="title collapsed" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    <i class="ti-reload"></i>
                                    <div class="data">
                                        <h5>Connections</h5>
                                        <p>Sync your social accounts</p>
                                    </div>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <div class="collapse" id="collapseFour" aria-labelledby="headingFour" data-parent="#accordionSettings">
                                    <div class="content">
                                        <div class="app">
                                            <img src="/storage/images/integrations/slack.svg" alt="app">
                                            <div class="permissions">
                                                <h5>Skrill</h5>
                                                <p>Read, Write, Comment</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="app">
                                            <img src="/storage/images/integrations/dropbox.svg" alt="app">
                                            <div class="permissions">
                                                <h5>Dropbox</h5>
                                                <p>Read, Write, Upload</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="app">
                                            <img src="/storage/images/integrations/drive.svg" alt="app">
                                            <div class="permissions">
                                                <h5>Google Drive</h5>
                                                <p>No permissions set</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="app">
                                            <img src="/storage/images/integrations/trello.svg" alt="app">
                                            <div class="permissions">
                                                <h5>Trello</h5>
                                                <p>No permissions set</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Connections -->
                            <!-- Start of Appearance Settings -->
                            <div class="category">
                                <a href="#" class="title collapsed" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    <i class="ti-palette"></i>
                                    <div class="data">
                                        <h5>Appearance</h5>
                                        <p>Customize the look of JustIM</p>
                                    </div>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <div class="collapse" id="collapseFive" aria-labelledby="headingFive" data-parent="#accordionSettings">
                                    <div class="content no-layer">
                                        <div class="set">
                                            <div class="details">
                                                <h5>Turn {{ auth()->user()->nightmode==1 ? 'On' : 'Off' }} Lights</h5>
                                                <p>The dark mode is applied to core areas of the app that are normally displayed as light.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox" {{ auth()->user()->nightmode==1 ? '' : 'checked' }}>
                                                <span class="slider round mode"
                                                      onclick="event.preventDefault();
                                                               document.getElementById('nightmode-form-sidebar').submit();"
                                                >
                                                </span>
                                                <form id="nightmode-form-sidebar" action="{{ route('nightmode') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Appearance Settings -->
                            <!-- Start of Language -->
                            <div class="category">
                                <a href="#" class="title collapsed" id="headingSix" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                    <i class="ti-flag"></i>
                                    <div class="data">
                                        <h5>Language</h5>
                                        <p>Select preferred language</p>
                                    </div>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <div class="collapse" id="collapseSix" aria-labelledby="headingSix" data-parent="#accordionSettings">
                                    <div class="content layer">
                                        <div class="language">
                                            <label for="country">Language</label>
                                            <select class="custom-select" id="country" required>
                                                <option value="">Select an language...</option>
                                                <option>English, UK</option>
                                                <option>English, US</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Language -->
                            <!-- Start of Privacy & Safety -->
                            <div class="category">
                                <a href="#" class="title collapsed" id="headingSeven" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                    <i class="ti-panel"></i>
                                    <div class="data">
                                        <h5>Privacy & Safety</h5>
                                        <p>Control your privacy settings</p>
                                    </div>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <div class="collapse" id="collapseSeven" aria-labelledby="headingSeven" data-parent="#accordionSettings">
                                    <div class="content no-layer">
                                        <div class="set">
                                            <div class="details">
                                                <h5>Keep Me Safe</h5>
                                                <p>Automatically scan and delete direct messages you receive from everyone that contain explict content.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>My Friends Are Nice</h5>
                                                <p>If enabled scans direct messages from everyone unless they are listed as your friend.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Everyone can add me</h5>
                                                <p>If enabled anyone in or out your friends of friends list can send you a friend request.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Friends of Friends</h5>
                                                <p>Only your friends or your mutual friends will be able to send you a friend reuqest.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Data to Improve</h5>
                                                <p>This settings allows us to use and process information for analytical purposes.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Data to Customize</h5>
                                                <p>This settings allows us to use your information to customize Talkshak for you.</p>
                                            </div>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Privacy & Safety -->
                            <!-- Start of Blocking/Blocked Users -->
                            <div class="category">
                                <a href="#" class="title collapsed" id="headingEight" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                                    <i class="ti-lock"></i>
                                    <div class="data">
                                        <h5>Blocked Users</h5>
                                        <p>See the users you have blocked</p>
                                    </div>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <div class="collapse" id="collapseEight" aria-labelledby="headingEight" data-parent="#accordionSettings">
                                    <div class="content no-layer">
                                        <div class="set">
                                            <div class="details">
                                                <h5>Block User</h5>
                                                <form action="/users/block_user" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control" id="usernameToBlock" name="username" placeholder="@" required>
                                                    </div>
                                                    <button class="btn btn-link w-100" type="button" onclick="if(confirm('Are you sure you want to block this user?')) { $(this).data('username', $('#usernameToBlock').val()); blockUser(this); }" data-username="">
                                                        Block User
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="set">
                                            <div class="details">
                                                <h5>Blocked Users</h5>
                                                @if(count($blocked_users) === 0)
                                                    <p>You have not blocked any user.</p>
                                                @else
                                                    <ul class="list-group" id="blocked-users">
                                                        @foreach($blocked_users as $blocked_user)
                                                            <li class="list-group-item blocked-user">
                                                                &#64;{{ $blocked_user->username }}
                                                                <div class="float-right">
                                                                    <form id="unblock-user-form-{{ $blocked_user->id }}" action="/users/unblock_user/{{ $blocked_user->id }}" method="post">
                                                                        {{ csrf_field() }}
                                                                        <button class="btn unblock-button" onclick="
                                                                            event.preventDefault();
                                                                            if(confirm('Unblock &#64;{{ $blocked_user->username }}?')) {
                                                                                document.getElementById('unblock-user-form-{{ $blocked_user->id }}').submit();
                                                                            }
                                                                        ">
                                                                            Unblock
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    @if(count(auth()->user()->getBlockedFriendships()) > 10)
                                                        <br><br>
                                                        <p>
                                                            <button class="button btn view-more-button">
                                                                View more
                                                            </button>
                                                        </p>
                                                    @endif
                                                    {{ $blocked_users->links() }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Blocking/Blocked Users -->
                        </div>
                    </div>
                </div>
                <!-- End of Settings -->
            </div>
        </div>
    </div>
</div><!-- Sidebar -->
