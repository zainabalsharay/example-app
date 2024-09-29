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
            الخدمات
        </div><br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($service) && $service->count() > 0)
                    @foreach ($service as $s)
                        <tr>
                            <th scope="row">{{ $s->id }}</th>
                            <td>{{ $s->name }}</td>
                            <td>
                                <form
                                    action="{{ route('delets.doctors.services', ['service_id' => $s->id, 'doctor_id' => $doctor_id]) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">حذف الخدمه</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <br><br> <br><br>

        <form method="POST" action="{{ route('save.doctors.services') }}">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">اختر طبيب</label>
                <select name="doctor_id" id="" class="form-control">
                    @if (isset($doctors) && $doctors->count() > 0)
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">اختر الخدمات</label>
                <select name="service_id[]" id="" class="form-control" multiple>
                    @if (isset($allservices) && $allservices->count() > 0)
                        @foreach ($allservices as $allservice)
                            <option value="{{ $allservice->id }}">{{ $allservice->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>


            <button type="submit" class="btn btn-primary">اضافة خدمه للطبيب</button>
        </form>


    </div>
@endsection
