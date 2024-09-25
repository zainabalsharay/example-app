@extends('layouts.app')
@section('content')
    <div class="alert alert-success" id="success_msg" style="display: none;">
        {{ __('messages.offer deleted successfully') }}
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">{{ __('messages.Id') }}</th>
                <th scope="col">{{ __('messages.Offer Name') }}</th>
                <th scope="col">{{ __('messages.Offer Price') }}</th>
                <th scope="col">{{ __('messages.Offer detalis') }}</th>
                <th scope="col">{{ __('messages.Offer image') }}</th>
                <th scope="col">{{ __('messages.Operation') }}</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($offers as $offer)
                <tr class="offerRrow{{ $offer->id }}">
                    <th scope="row">{{ $offer->id }}</th>
                    <td>{{ $offer->name }}</td>
                    <td>{{ $offer->price }}</td>
                    <td>{{ $offer->detalis }}</td>
                    <td><img id="image_display" src="{{ asset('images/offers/' . $offer->photo) }}" alt="Offer Image"
                            style="width: 100px; height: auto;"></td>
                    <td>
                        <a href="{{ url('offers/edit/' . $offer->id) }}" class="btn btn-success">
                            {{ __('messages.update') }}
                        </a>&nbsp;
                        <a href="{{ route('offers.delete', $offer->id) }}" class="btn btn-danger">
                            {{ __('messages.delete') }}
                        </a>&nbsp;
                        <a href="" offer_id="{{ $offer->id }}" class="delete_btn btn btn-danger">
                            {{ __('messages.delete Ajax') }}
                        </a>&nbsp;
                        <a href="{{ route('ajax.offers.edit', $offer->id) }}" class="update_btn btn btn-danger">
                            {{ __('messages.Update Ajax') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.delete_btn', function(e) {
            e.preventDefault();
            var offer_id = $(this).attr('offer_id');

            if (!offer_id) {
                alert('Offer ID is missing.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('ajax.offers.delete') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': offer_id,
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                        $('.offerRrow' + data.id).remove();
                    }
                },
                error: function(reject) {

                }
            });
        });
    </script>
@endsection
