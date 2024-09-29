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
            الاطباء
        </div><br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">title</th>
                    <th scope="col">operation</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($doctors) && $doctors->count() > 0)
                    @foreach ($doctors as $d)
                        <tr>
                            <th scope="row">{{ $d->id }}</th>
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->title }}</td>
                            <td>
                                <form action="{{ route('delets', $d->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <a href="{{ route('doctors.services', $d->id) }}" class="btn btn-success">عرض
                                        الخدمات</a>&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif

            </tbody>
        </table>


    </div>
@endsection
