@extends('admin.layouts.main')
@section('title','User-create')
@section('main')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">User Form</h4>
                            <form class="forms-sample" id="submit_form" action=""enctype="multipart/form-data"  method="post">
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
                                    <label class="form-control-label" style="font-size:13px">NAME</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder="Enter Name">

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:13px">EMAIL</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                        placeholder="Enter Email">

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:13px">MOBILE NO</label>
                                    <input type="text" class="form-control" name="mobile_no"
                                        value="{{ old('mobile_no') }}" placeholder="Enter Mobile No">

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:15px">PASSWORD</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        value="{{ old('password') }}" placeholder="Enter Password">

                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:15px">CONFIRM PASSWORD</label>
                                    <input type="password" class="form-control" name="cpassword"
                                        value="{{ old('cpassword') }}" placeholder="Enter Confirm Password">

                                </div>
                                <div class="mb-3">
                                    <label class="form-control-label" style="font-size:15px">PROFILE</label>
                                    <input class="form-control" type="file" id="profile" name="profile" multiple>
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
    @push('js')
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $("#datepicker").datepicker();

            });
        </script>
        <script>
            $(document).ready(function() {
                $.validator.addMethod("lettersonly", function(value, element) {
                    return this.optional(element) || /^[a-z]+$/i.test(value);
                }, "Letters only please");

                $('#submit_form').validate({
                    rules: {
                        name: {
                            required: true,
                            lettersonly: true
                        },
                        email: {
                            required: true,
                            email: true

                        },
                        mobile_no: {
                            required: true,
                            maxlength: 10,
                            digits: true
                        },
                        password: {
                            required: true,
                        },
                        cpassword: {
                            required: true,
                            equalTo: "#password"
                        },
                        profile: {
                            required: true,
                        },

                    },
                    messages: {
                        'name': {
                            'required': 'Please Enter Your Name'
                        },
                        'email': {
                            'required': 'Please Enter Email'
                        },
                        'mobile_no': {
                            'required': 'Please Enter Mobile No'
                        },
                        'password': {
                            'required': 'Please Enter Password'
                        },
                        'cpassword': {
                            'required': 'Please Confirm Password'
                        },
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass("is-invalid").removeClass("is-valid");
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).addClass("is-valid").removeClass("is-invalid");
                    },
                    submitHandler: function(form) {
                        register(form);
                    }

                });
            });


            function register(form) {
                $('.text-strong').html('');
                var form = $('#submit_form');
                var formData = new FormData(form[0]);
                swal({
                    title: "Are you sure?",
                    text: "you want to insert User data!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Save!',
                    cancelButtonText: "No, cancel plx!",
                    reverseButtons: true
                }).then((result) => {
                    if (result) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr('content')
                            },
                            type: 'POST',
                            url: "{{ route('admin.store') }}",
                            data: formData,
                            dataType: 'JSON',
                            contentType: false,
                            processData: false,
                            cache: false,
                            success: function(query) {
                                if (query) {
                                    swal("Inserted!",
                                        "User data inserted Successfully.",
                                        "success");
                                    window.location.href =
                                        "{{ route('admin.index') }}";
                                }
                            },
                            error: function(data) {
                                $.each(data.responseJSON.errors, function(
                                    key, value) {
                                    $('[name=' + key + ']').after(
                                        '<span class="text-strong" style="color:red">' +
                                        value + '</span>')
                                });
                            }
                        });
                    } else {
                        swal("Cancelled", "Your record is safe :)", "error");
                    }
                });
            }
        </script>
    @endpush
@endsection
