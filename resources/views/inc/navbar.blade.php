<div class="navigation{{ count($errors)>0 ? ' active' : '' }}">
    <div class="container">
        <div class="inside">
            <div class="nav nav-tab menu">
                <a href="#settings" data-toggle="tab" title="User Settings" class="{{ count($errors)>0 ? ' active show' : '' }}">
                    <i class="ti-settings"></i>
                    Settings
                </a>
                <a href="#members" data-toggle="tab" title="All Friends">
                    <i class="ti-comments-smiley"></i>
                    Friends
                </a>
                <a href="#discussions" data-toggle="tab" class="{{ count($errors)==0 ? 'active' : '' }}" title="Recent Chats">
                    <i class="ti-comments"></i>
                    Chats
                </a>
                <a href="#notifications" data-toggle="tab" class="f-grow1" title="Recent Notifications">
                    <i class="ti-bell"></i>
                    Notifications
                </a>
                <a href="" id="dark" class="dark-theme" title="{{ session('nightmode')==0 ? 'Use Night Mode' : 'Use Light Mode'}}"
                   onclick="event.preventDefault();
                            document.getElementById('nightmode-form-navbar').submit();"
                >
                    <i class="ti-light-bulb"></i>
                    @if(session('nightmode') == 0)
                        Switch Night Mode On
                    @else
                        Switch Night Mode Off
                    @endif
                </a>
                <form id="nightmode-form-navbar" action="{{ route('nightmode') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
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
