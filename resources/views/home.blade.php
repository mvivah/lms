@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Registered Users') }}
                    <button type="button" class="btn btn-outline-secondary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#userModal">Add User</button>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Gender</th>
                                <th class="d-none d-md-table-cell">Date of Birth</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->gender}}</td>
                                <td class="d-none d-md-table-cell">{{$user->birthdate}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td class="table-action">
                                    <div class="btn-group">
                                        <button type="button" id="{{$user->id}}" class="btn btn-outline-success btn-sm viewUser">View</button>
                                        <button type="button" id="{{$user->id}}" class="btn btn-outline-info btn-sm editUser">Edit</button>
                                        <button type="button" id="{{$user->id}}" class="btn btn-outline-danger btn-sm deleteUser">Delete</button>
                                      </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Register User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="userForm">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="user_id" name="user_id">
                            <div class="col">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="col">
                                <label for="gender" class="form-label">Gender:</label>
                                <select type="text" class="form-select" name="gender" id="gender">
                                    <option value="" selected disabled> - Select Gender- </option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="birthdate" class="form-label">Birthdate:</label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="phone" class="form-control" name="phone" id="phone">
                            </div>
                            <div class="col">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                        </div>
                        <div class="row" id="user_login">
                            <div class="col">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="col">
                                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
      </div>

      <div class="modal fade" id="warnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white text-center">
                    <h5 class="modal-title" id="error_title">Please Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        Are you sure you want to delete this record?
                        <form id="deleteForm" onsubmit="event.preventDefault(); executeDeletion();" method="DELETE">
                        <input type="hidden" id="target_url" name="target_url">
                        <input type="hidden" id="target_id" name="target_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
