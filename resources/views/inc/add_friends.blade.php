<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="requests">
            <div class="title">
                <h1>Add a friend</h1>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
            </div>
            <div class="content">
                <form method="post" action="/users/send_friend_request">
                    <div class="form-group">
                        <label for="user">Username:</label>
                        <input type="text" class="form-control" name="username" id="user" placeholder="@" required>
                    </div>
                    <button type="submit" class="btn button w-100">Send Friend Request</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- Add Friends -->
