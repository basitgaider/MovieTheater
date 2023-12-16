@extends("layout.layout")
@section("title")
Table
@endsection
@section("main")


            <!-- Table Start -->
            <div class="container-fluid  pt-4 px-4">
                <div class="bg-secondary">

                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Email Verify</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $u)     
                                <tr>
                                    <th scope="row">{{$u->id}}</th>
                                    <td>{{$u->name}}</td>
                                    <td>{{$u->email}}</td>
                                    <td>{{$u->email_verified_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>      
            <br><br></div></div>     
            <!-- Table End -->

@endsection