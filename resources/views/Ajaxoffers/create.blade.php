@extends('layouts.app')

@section('content')
    <div class="container" style="direction: rtl;">
        <div
            class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="content">
                {{-- عرض رسالة النجاح 
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif --}}

                <h1 style="font-size: 3em">{{ __('messages.Add your offer') }}</h1><br><br>

                <form method="" action="" enctype="" id="offerForm">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('messages.choose image offer') }}</label>
                        <input type="file" class="form-control" name="photo">
                        <small id="photo_error" class="form-text text-danger"></small>

                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('messages.Offer Name ar') }}</label>
                        <input type="text" class="form-control" name="name_ar"
                            placeholder="{{ __('messages.Offer Name ar') }}">

                        <small id="name_ar_error" class="form-text text-danger"></small>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('messages.Offer Name en') }}</label>
                        <input type="text" class="form-control" name="name_en"
                            placeholder="{{ __('messages.Offer Name en') }}">
                        <small id="name_en_error" class="form-text text-danger"></small>

                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">{{ __('messages.Offer Price') }}</label>
                        <input type="text" class="form-control" name="price"
                            placeholder="{{ __('messages.Offer Price') }}">
                        <small id="price_error" class="form-text text-danger"></small>

                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">{{ __('messages.Offer detalis ar') }}</label>
                        <input type="text" class="form-control" name="detalis_ar"
                            placeholder="{{ __('messages.Offer detalis ar') }}">
                        <small id="detalis_ar_error" class="form-text text-danger"></small>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">{{ __('messages.Offer detalis en') }}</label>
                        <input type="text" class="form-control" name="detalis_en"
                            placeholder="{{ __('messages.Offer detalis en') }}">
                        <small id="detalis_en_error" class="form-text text-danger"></small>

                    </div>
                    <br><br>
                    <button id="save_offer" class="btn btn-primary">{{ __('messages.Save Offer') }}</button>
                </form><br>
                <div class="alert alert-success" id="success_msg" style="display: none;">
                    {{ __('messages.Offer saved successfully!') }}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '#save_offer', function(e) {
            e.preventDefault();

            // // تفريغ النصوص الموجودة في حقول الأخطاء
            // $('#photo_error').text("");
            // $('#name_ar_error').text("");
            // $('#name_en_error').text("");
            // $('#price_error').text("");
            // $('#detalis_ar_error').text("");
            // $('#detalis_en_error').text("");

            // تفريغ النصوص الموجودة في حقول الأخطاء بسطر واحد باستخدام اسم الكلاس
            $('.form-text.text-danger').text("");

            var formData = new FormData($('#offerForm')[0]);
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{ route('ajax.offers.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                },
                error: function(reject) {
                    var response = JSON.parse(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $('#' + key + "_error").text(val[0]);

                    });
                }

            });
        });
    </script>
@endsection
