<div class="navigation">
    <div class="container">
        <div class="inside">
            <div class="nav nav-tab menu">
                <a href="#settings" data-toggle="tab" title="User Setting">
                    <i class="ti-panel"></i>
                    Setting
                </a>
                <a href="#members" data-toggle="tab" title="All members">
                    <i class="ti-home"></i>
                    All Friends
                </a>
                <a href="#discussions" data-toggle="tab" class="active" title="Chat">
                    <i class="ti-comment-alt"></i>
                    Recent Chat
                </a>
                <a href="#notifications" data-toggle="tab" class="f-grow1" title="Notifications">
                    <i class="ti-bell"></i>
                    Notifications
                </a>
                <a href="" id="dark" class="dark-theme" title="Use Night Mode">
                    <i class="ti-wand"></i>
                    Night Mode
                </a>
                <a href="{{ route('logout') }}"
                   class="btn power"
                   title="Sign Out"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form-navbar').submit();"
                >
                    <i class="ti-power-off"></i>
                </a>

                <form id="logout-form-navbar" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</div><!-- Navigation -->
