@extends('admin.layouts.main')
@section('main')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Change Password</h4>
                            <form class="forms-sample" id="changePassword" action="" method="post">
                                @csrf
                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                @if (Session::get('fail'))
                                    <div class="alert alert-success">
                                        {{ Session::get('fail') }}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:15px">CORRENT PASSWORD</label>
                                    <input type="password" class="form-control" id="current-password" name="current-password"
                                        value="{{ old('current-password') }}" placeholder="Enter current Password">

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:15px">NEW PASSWORD</label>
                                    <input type="password" class="form-control" id="new-password" name="new-password"
                                        value="{{ old('new-password') }}" placeholder="Enter new Password">

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:15px">CONFIRM PASSWORD</label>
                                    <input type="password" class="form-control" name="confirm_password"
                                        value="{{ old('confirm_password') }}" placeholder="Enter Confirm Password">

                                </div>
                                <button type="submit" id="submit" class="btn btn-primary btn-icon-text">
                                    <i class="mdi mdi-file-check btn-icon-prepend" id="submit"></i> Submit </button>
                                <a href="{{ route('admin.index') }}" class="btn btn-dark">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@push('js')
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#changePassword').validate({
            rules: {
                'current-password': {
                    required: true,
                },
                'new-password': {
                    required: true,
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new-password"
                }

            },
            messages: {
                //  errorElement: 'span',
                password: {
                    required: 'Please Enter Your Password.',
                    minlength: 'Please Enter at least 8 characters.'
                },
                confirm_password: {
                    required: 'Please Enter Confirmation.',
                    equalTo: 'Please Enter Confirm Password Same as a Password.'
                },
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).parents("div.form-control").addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).parents(".error").removeClass(errorClass).addClass(validClass);
            },
        });
    });
</script>
@endpush

