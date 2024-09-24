@extends('layouts.app')

@section('content')
    <div class="container" style="direction: rtl;">
        <div
            class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="content">
                {{-- عرض رسالة النجاح  --}}
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                <h1 style="font-size: 3em">{{ __('messages.Add your offer') }}</h1><br><br>

                <form method="" action="" enctype="" id="offerForm">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('messages.choose image offer') }}</label>
                        <input type="file" class="form-control" name="photo">
                        @error('photo')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('messages.Offer Name ar') }}</label>
                        <input type="text" class="form-control" name="name_ar"
                            placeholder="{{ __('messages.Offer Name ar') }}">
                        @error('name_ar')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{ __('messages.Offer Name en') }}</label>
                        <input type="text" class="form-control" name="name_en"
                            placeholder="{{ __('messages.Offer Name en') }}">
                        @error('name_en')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">{{ __('messages.Offer Price') }}</label>
                        <input type="text" class="form-control" name="price"
                            placeholder="{{ __('messages.Offer Price') }}">
                        @error('price')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">{{ __('messages.Offer detalis ar') }}</label>
                        <input type="text" class="form-control" name="detalis_ar"
                            placeholder="{{ __('messages.Offer detalis ar') }}">
                        @error('detalis_ar')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">{{ __('messages.Offer detalis en') }}</label>
                        <input type="text" class="form-control" name="detalis_en"
                            placeholder="{{ __('messages.Offer detalis en') }}">
                        @error('detalis_en')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <br><br>
                    <button id="save_offer" class="btn btn-primary">{{ __('messages.Save Offer') }}</button>
                </form><br>
                <div class="alert alert-success" id="success_msg" style="display: none;">
                    {{ __('messages.saved successfully!') }}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '#save_offer', function(e) {
            e.preventDefault();
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
                error: function(reject) {}

            });
        });
    </script>
@endsection
