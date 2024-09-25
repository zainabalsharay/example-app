@extends('layouts.app')

@section('content')
    <div class="container" style="direction: rtl;">
        <div
            class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

            <div class="content">
                <div class="alert alert-success" id="success_msg" style="display: none;">
                    {{ __('messages.To update successfully!') }}
                </div>

                <h1 style="font-size: 3em">{{ __('messages.Edit Offer') }}</h1><br><br>

                <form enctype="multipart/form-data" id="offerFormUpdate">
                    @csrf
                    <input type="text" style="display: none;" class="form-control" name="offer_id"
                        value="{{ $offer->id }}">

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('messages.choose image offer') }}</label>
                        <input type="file" id="fileInput" class="form-control" name="photo">
                        <img id="image_display" src="{{ asset('images/offers/' . $offer->photo) }}" alt="Selected Image"
                            style="width: 100px; height: auto;">
                        <small id="photo_error" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('messages.Offer Name ar') }}</label>
                        <input type="text" class="form-control" name="name_ar"
                            placeholder="{{ __('messages.Offer Name ar') }}" value="{{ $offer->name_ar }}">
                        <small id="name_ar_error" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('messages.Offer Name en') }}</label>
                        <input type="text" class="form-control" name="name_en" value="{{ $offer->name_en }}"
                            placeholder="{{ __('messages.Offer Name en') }}">
                        <small id="name_en_error" class="form-text text-danger"></small>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">{{ __('messages.Offer Price') }}</label>
                        <input type="text" class="form-control" name="price" value="{{ $offer->price }}"
                            placeholder="{{ __('messages.Offer Price') }}">
                        <small id="price_error" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">{{ __('messages.Offer detalis ar') }}</label>
                        <input type="text" class="form-control" name="detalis_ar" value="{{ $offer->detalis_ar }}"
                            placeholder="{{ __('messages.Offer detalis ar') }}">
                        <small id="detalis_ar_error" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">{{ __('messages.Offer detalis en') }}</label>
                        <input type="text" class="form-control" name="detalis_en" value="{{ $offer->detalis_en }}"
                            placeholder="{{ __('messages.Offer detalis en') }}">
                        <small id="detalis_en_error" class="form-text text-danger"></small>
                    </div>
                    <br><br>
                    <button id="update_offer" class="btn btn-primary">{{ __('messages.Update Offer') }}</button>
                </form><br>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('change', '#fileInput', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_display').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        $(document).on('click', '#update_offer', function(e) {
            e.preventDefault();
            $('.form-text.text-danger').text("");
            var formData = new FormData($('#offerFormUpdate')[0]);
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{ route('ajax.offers.update') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                        // تأكد أن `image_path` هو المسار الصحيح للصورة الجديدة
                        $('#image_display').attr('src', data.image_path);
                        // $('#fileInput').val(''); // قم بمسح المدخل إذا لزم الأمر
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
