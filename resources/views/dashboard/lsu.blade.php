@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Dashboard Sampel Daun [LSU]</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="embed-responsive embed-responsive-16by9" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%;">
            <iframe class="embed-responsive-item"
                src="https://app.powerbi.com/view?r=eyJrIjoiOTE0ZjA4N2EtZTJiMy00MmVkLWE1NzktZTI4Y2YwODAxMGI0IiwidCI6IjkzMzQ3NTJlLWIwM2EtNDUzNy04ZmY2LTU0ZDU3MGMzNWQyOCIsImMiOjEwfQ%3D%3D"
                allowfullscreen
                style="position: absolute; top:0; left: 0; width: 100%; height: 100%; border: none;">
            </iframe>
        </div>
    </div>
</div>
@endsection