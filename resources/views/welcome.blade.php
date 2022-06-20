@extends('layouts.app')
@section('title')
    Welcome
@endsection
@section('contingut')
    <div id="app">
        <carrusel></carrusel>
        <br>
        @isset($user)
            <div class="d-flex flex-row justify-content-around">
                @foreach($jocs as $joc)
                    <div class="card col-4" style="width: 18rem;">
                        <img src="{{$joc->image_path}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the
                                card's content.</p>
                            <a href="create-reserva/{{$joc->id}}" class="btn btn-primary">Reserva Ja!</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="d-flex flex-row justify-content-around">
                @foreach($jocs as $joc)
                    <div class="card col-4" style="width: 18rem;">
                        <img src="{{$joc->image_path}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the
                                card's content.</p>
                            <a href="login" class="btn btn-primary">Reserva Ja!</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endisset
        <five-ratings></five-ratings>
    </div>

@endsection


