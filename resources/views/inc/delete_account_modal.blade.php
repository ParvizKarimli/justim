<div id="deleteAccountModal"
     role="dialog"
     class="modal fade{{ $errors->has('password_to_delete_account') || session('password_to_delete_account_error') ? ' show' : '' }}"
     style="display: {{ $errors->has('password_to_delete_account') || session('password_to_delete_account_error') ? 'block' : 'none' }}"
>
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
                    <div class="field{{ $errors->has('password_to_delete_account') || session('password_to_delete_account_error') ? ' has-error' : '' }}">
                        <label for="password_to_delete_account">Password</label>
                        <input type="password" class="form-control" id="password_to_delete_account" name="password_to_delete_account" placeholder="Enter password" required>
                        @if ($errors->has('password_to_delete_account'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_to_delete_account') }}</strong>
                            </span>
                        @endif
                        @if (session('password_to_delete_account_error'))
                            <span class="help-block">
                                <strong>{{ session('password_to_delete_account_error') }}</strong>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="field">
                        <label for="password_to_delete_account_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_to_delete_account_confirmation" name="password_to_delete_account_confirmation" placeholder="Enter password again" required>
                    </div>
                    <input type="button" class="btn btn-link w-100" href="" value="Delete Account"
                           onclick="if(confirm('Are you sure you want to permanently delete your account?')) {
                               event.preventDefault();
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
