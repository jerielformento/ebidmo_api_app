@extends('admin.template.layout')
@section('content')     
<div class="table-responsive">
    <table class="table table-condensed table-bordered">
        <thead class="bg-dark text-white">
            <th>Username</th>
            <th>Email</th>
            <th>Full Name</th>
            <th>Phone</th>
            <th>Registered</th>
        </thead>
        <tbody>
            @foreach($data as $customer)
            <tr>
                <td>{{ $customer->username }}</td>
                <td>{{ $customer->profile->email }}</td>
                <td>{{ $customer->profile->first_name }} {{ $customer->profile->last_name }}</td>
                <td>{{ $customer->profile->phone }}</td>
                <td>{{ $customer->registered_at }}</td>
            </tr>
            @endforeach
        </tbody>
  </table>
</div>
@endsection