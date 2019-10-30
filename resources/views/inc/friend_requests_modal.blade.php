<!-- Add Friends -->
<div
    class="modal fade"
    id="friendRequestsModal"
    tabindex="-1" role="dialog"
    aria-hidden="true"
    data-has-error="{{ session('friend_requests_error') ? 'yes' : 'no' }}"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="requests">
            <div class="title">
                <h1>Friend Requests</h1>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="content">
                @if(count($friend_requests) === 0)
                    <p>You have no friend requests.</p>
                @else
                    @foreach($friend_requests as $friend_request)
                        <div>
                            <p>{{ $friend_request->name }}</p>
                            <p>&#64;{{ $friend_request->username }}</p>
                            <a class="btn button col-sm-4">Confirm</a>
                            <a class="btn button col-sm-4">Deny</a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
