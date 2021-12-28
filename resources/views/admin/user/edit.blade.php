@extends('admin.layouts.main')
@section('title','User-edit')
@section('main')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Admin Form</h4>
                            <form class="forms-sample" id="submit_form" action="{{ route('admin.update', $user->id) }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:13px">NAME</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:15px">EMAIL</label>
                                    <input type="text" name="email" value="{{ $user->email }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:13px">MOBILE NO</label>
                                    <input type="text" class="form-control" name="mobile_no"
                                        value="{{ $user->mobile }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-control-label" style="font-size:15px">PROFILE</label>
                                    <input class="form-control" type="file" id="profile" value="{{ $user->profile }}"
                                        name="profile" multiple>
                                    <img id="blah" src={{asset('storage/profile').'/'.$user->profile }} height="70px" width="70pxs"
                                        alt="your image" />
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
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#submit_form').validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        email: {
                            required: true,
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

                    },
                    messages: {
                        'name': {
                            'required': 'Please Enter Name'
                        },
                        'email': {
                            'required': 'Please Enter Email'
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
                    // errorElement: 'span',
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
                    text: "you want to Update Data!",
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
                            type: 'post',
                            url: "{{ route('admin.update', $user->id) }}",
                            data: formData,
                            dataType: 'JSON',
                            contentType: false,
                            processData: false,
                            cache: false,
                            success: function(query) {
                                if (query) {
                                    swal("Updated!",
                                        "User data Updated Successfully.",
                                        "success");
                                    window.location.href =
                                        "{{ route('admin.index') }}";
                                }
                            },
                            error: function(data) {
                                $.each(data.responseJSON.errors, function(
                                    key, value) {
                                        console.log(data.responseJSON.errors);
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
