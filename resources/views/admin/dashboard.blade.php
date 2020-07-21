@extends('admin.layout.base')
@section('title', 'Dashboard')

@section('content')
    <div class="dashboard">
        <div class="cell">
            <h2>Dashboard</h2>

            <form action="/admin" method="post" enctype="multipart/form-data">
                <input type="text" name="product" value="abc">
                <input type="file" name="image">
                <input type="submit" value="go">
            </form>

        </div>
    </div>

@endsection