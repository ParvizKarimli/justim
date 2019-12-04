<!-- Friend Modal -->
<div
    class="modal fade"
    id="friendModal"
    tabindex="-1" role="dialog"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">About Friend</h1>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <b>Name: </b> <p id="friendName"></p>
                    <b>Username: </b> <p id="friendUsername"></p>
                    <b>Avatar: </b> <p>
                        <img id="friendThumbnail" src="">
                    </p>
                    <b>Friend Since: </b> <p id="friendSince"></p>
                </div>
                <div id="friend-action-container">
                    <a class="btn btn-warning col-sm-4" id="removeFriend" onclick="if(confirm('Are you sure you want to unfriend this user?')) { removeFriend(this); }" data-friend-id="">Unfriend</a>
                    <a class="btn btn-danger col-sm-4" id="blockUser" onclick="if(confirm('Are you sure you want to block this user?')) { blockUser(this); }" data-user-id="">Block</a>
                </div>
            </div>
        </div>
    </div>
</div>
