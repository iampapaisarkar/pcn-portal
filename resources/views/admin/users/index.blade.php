@extends('layouts.app')

@section('content')
@include('layouts.navbars.breadcrumb', ['page' => 'Users', 'route' => 'users.index'])
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="card text-left">
    <div class="card-body">
        <a href="{{route('users.create')}}"><button class="btn btn-primary" type="button">ADD USER</button></a>
        <hr>
        <div class="table-responsive">
            <!-- id="multicolumn_ordering_table" -->
            <table class="display table table-striped table-bordered"  style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>State</th>
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->firstname . ' ' . $user->lastname}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role->role}}</td>
                        <td>{{$user->state ? $user->state : ''}}</td>
                        <!-- <td><span class="badge badge-success">ACTIVE</span></td> -->
                        <td><a href="admin-users-view.php"><button class="btn btn-info" type="button">VIEW</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>State</th>
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            {{$users->links('pagination')}}
        </div>
    </div>
</div>
</div>
</div>
@endsection