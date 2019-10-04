<div id="deleteAccountModal-{{ auth()->id() }}" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Account</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="delete-account-form-sidebar" action="/users/{{ auth()->id() }}" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password_delete">Password</label>
                        <input type="password" class="form-control" id="password_delete" name="password" placeholder="Enter password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="field">
                        <label for="password_confirmation_delete">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation_delete" name="password_confirmation" placeholder="Enter password again" required>
                    </div>
                    <input type="button" class="btn btn-link w-100" href="" value="Delete Account"
                           onclick="if(confirm('Are you sure you want to permanently delete your account?')) {
                               //event.preventDefault();
                               document.getElementById('delete-account-form-sidebar').submit();
                           }"
                    >
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
