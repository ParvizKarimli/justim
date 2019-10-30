<!-- Add Friends -->
<div
        class="modal fade"
        id="sendFriendRequestModal"
        tabindex="-1" role="dialog"
        aria-hidden="true"
        data-has-error="{{ session('send_friend_request_error') ? 'yes' : 'no' }}"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="requests">
            <div class="title">
                <h1>Add New Friend</h1>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="content">
                <form method="post" action="/users/send_friend_request">
                    {{ csrf_field() }}
                    <div class="form-group{{ session('send_friend_request_error') ? ' has-error' : '' }}">
                        <label for="user">Username:</label>
                        <input type="text" class="form-control" name="username" id="user" placeholder="@" required>
                        @if (session('send_friend_request_error'))
                            <span class="help-block">
                                <strong>{{ session('send_friend_request_error') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn button w-100">Send Friend Request</button>
                </form>
            </div>
        </div>
    </div>
</div>
