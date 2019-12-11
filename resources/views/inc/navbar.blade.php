<div class="navigation{{ count($errors)>0 ? ' active' : '' }}">
    <div class="container">
        <div class="inside">
            <div class="nav nav-tab menu">
                <a href="#settings" data-toggle="tab" title="User Settings" class="{{ count($errors)>0 ? ' active show' : '' }}">
                    <i class="ti-settings"></i>
                    Settings
                </a>
                <a href="#members" data-toggle="tab" title="All Friends">
                    <i class="ti-user" style="display: inline; font-size: 1em"></i>
                    <i class="ti-user" style="display: inline; font-size: 2em"></i>
                    <i class="ti-user" style="display: inline; font-size: 1em"></i>
                    Friends
                    @if(count($friend_requests) > 0)
                        <span title="You have a new friend request">
                            <svg height="10" width="10">
                                <circle cx="5" cy="5" r="4" stroke="red" stroke-width="0" fill="red" />
                            </svg>
                        </span>
                    @endif
                </a>
                <a href="#discussions" data-toggle="tab" class="{{ count($errors)==0 ? 'active' : '' }}" title="Recent Chats">
                    <i class="ti-comments"></i>
                    Chats
                </a>
                <a href="#notifications" data-toggle="tab" class="f-grow1" title="Recent Notifications">
                    <i class="ti-bell"></i>
                    Notifications
                    @if($number_of_notifications > 0)
                        <span class="badge-pill badge-danger">
                            {{ $number_of_notifications }}
                        </span>
                    @endif
                </a>
                <a href=""
                   class="btn power"
                   title="Sign Out"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form-navbar').submit();"
                >
                    <i class="ti-power-off"></i>
                    <p>Log Out</p>
                </a>

                <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</div><!-- Navigation -->
