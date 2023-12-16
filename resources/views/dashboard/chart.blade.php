@extends("layout.layout")
@section("title")
Chart
@endsection
@section("main")


            <!-- Table Start -->
            <div class="container-fluid mt-3">
                <div class="bg-secondary rounded h-100 p-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $users)     
                                    <tr>
                                        <th scope="row">{{$users->id}}</th>
                                        <td>{{$users->Name}}</td>
                                        <td>{{$users->Email}}</td>
                                        <td>{{$users->Subject}}</td>
                                        <td>{{$users->Message}}</td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                   
            </div>
</div>         
            <!-- Table End -->


           
@endsection            