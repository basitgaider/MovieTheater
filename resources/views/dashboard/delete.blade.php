@extends("layout.layout")
@section("title")
blank
@endsection
@section("main")


<div class="container-fluid pt-4 px-4">
<div class="bg-secondary rounded h-100 p-4">
    <h2 class="mb-4">MOVIES DETAILS</h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Trailer Url</th>
                    <th scope="col">Release Date</th>
                    <th scope="col">Languages</th>
                    <th scope="col">Time Duration</th>
                    <th scope="col">Category</th>
                    <th scope="col">Poster File Path</th>
                    <th scope="col">Cinema</th>
                    <th scope="col">CREATED AT</th>
                    <th scope="col">UPDATED AT</th>
                    <th scope="col">Actions</th> <!-- Added a new column for actions -->
                </tr>
            </thead>
            <tbody>
                @foreach($moviesdata as $md)
                <tr>
                    <th scope="row">{{ $md->id }}</th>
                    <td>{{ $md->title }}</td>
                    <td>{{ $md->genre }}</td>
                    <td>{{ $md->rating }}</td>
                    <td>{{ $md->trailer_url }}</td>
                    <td>{{ $md->release_date }}</td>
                    <td>{{ $md->languages }}</td>
                    <td>{{ $md->time_duration }}</td>
                    <td>{{ $md->category }}</td>
                    <td>{{ $md->poster }}</td>
                    <td>{{ $md->cinemas }}</td>
                    <td>{{ $md->created_at }}</td>
                    <td>{{ $md->updated_at }}</td>
                    <td>
                        <a href="/delete_column/{{ $md->id }}" class="btn btn-primary m-2">Delete</a>
                        <a href="/update_column/{{$md->id}}" class="btn btn-success m-2">Edit</a>
                        <!-- Add more action buttons as needed -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection