<!-- Add Friends -->
<div
    class="modal fade"
    id="friendRequestsModal"
    tabindex="-1" role="dialog"
    aria-hidden="true"
    data-has-error="{{ session('friend_requests_error') ? 'yes' : 'no' }}"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Friend Requests</h1>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body" id="friend-requests">
                @if(count($friend_requests) === 0)
                    <p>You have no friend request.</p>
                @else
                    @foreach($friend_requests as $friend_request)
                        <div class="card friend-request">
                            <p>
                                @if($friend_request->thumbnail == NULL)
                                    <img class="avatar-md" src="/storage/images/avatars/thumbnails/default_thumbnail.jpg" data-toggle="tooltip" data-placement="top" title="{{ $friend_request->name }}" alt="avatar">
                                @else
                                    <img class="avatar-md" src="/storage/images/avatars/thumbnails/{{ $friend_request->thumbnail }}" data-toggle="tooltip" data-placement="top" title="{{ $friend_request->name }}" alt="avatar">
                                @endif
                            </p>
                            <p>{{ $friend_request->name }}</p>
                            <p class="username">&#64;{{ $friend_request->username }}</p>
                            <div id="friend-request-action-container-{{ $friend_request->id }}">
                                <a class="btn btn-success col-sm-4 friend-request-action-btn" onclick="friendRequestAction(this)" data-friend-id="{{ $friend_request->id }}" data-action="accept">Accept</a>
                                <a class="btn btn-danger col-sm-4 friend-request-action-btn" onclick="friendRequestAction(this)" data-friend-id="{{ $friend_request->id }}" data-action="deny">Deny</a>
                            </div>
                        </div>
                    @endforeach
                    <div class="page-load-status-friend-requests text-center">
                        @if($friend_requests_count > 10)
                            <p class="infinite-scroll-request">
                                Loading...<br>
                                <!--<img src="/storage/images/default/loader.svg">-->
                            </p>
                        @endif
                    </div>
                    {{ $friend_requests->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
