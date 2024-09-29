@extends('layouts.app')

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="container">
        <div class="alert alert-success" id="success_msg" style="display: none;">

            المستشفيات
        </div><br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">address</th>
                    <th scope="col">procedure</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($hospitals) && $hospitals->count() > 0)
                    @foreach ($hospitals as $h)
                        <tr>
                            <th scope="row">{{ $h->id }}</th>
                            <td>{{ $h->name }}</td>
                            <td>{{ $h->address }}</td>
                            {{-- <td><a href="{{ url('doctors/' . $h->id) }}" class="btn btn-success">show doctors</a></td> --}}
                            <td><a href="{{ route('doctors', $h->id) }}" class="btn btn-success">عرض الاطباء</a></td>
                            <td><a href="{{ route('deleteHospitals', $h->id) }}" class="btn btn-danger">حذف</a>
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>


    </div>
@endsection
