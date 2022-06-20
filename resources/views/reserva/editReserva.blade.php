@extends('layouts.app')
@section('title')
    Edita Reserva
@endsection
@section('contingut')
    <h1>Edita Reserva</h1>
    <div class="card">
        <div class="card-body">
            <h2>{{$joc->nom}}</h2>
            <p>{{$joc->descripcio}}</p>
            <img src="http://127.0.0.1:8080/{{$joc->image_path}}" alt="" class="float-end" style="width: 350px">
        </div>
    </div>
    <form action="/update-reserva" method="post">
        @csrf
        <div class="mb-3">
            <label for="sala" class="form-label">Sala:</label>
            <select class="form-select" aria-label="Default select example" id="sala" name="sala">
                @foreach($sales as $sala)
                    <option value="{{$sala->id}}" selected="{{$sala ->id == $reserva->idSala}}">{{$sala->id}}</option>
                @endforeach
            </select>
        </div>

        @if(count($vouchers) != 0)
            <div class="mb-3">
                <label for="voucher" class="form-label">Escull Descompte:</label>
                <select class="form-select" aria-label="Default select example" id="voucher" name="voucher">
                    @foreach($vouchers as $voucher)
                        <option value="{{$voucher->id}}"
                                selected="{{$voucher->id == $reserva->idVoucher}}">{{$voucher->nom}}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @isset($empleats)
            <div class="mb-3">
                <label for="empleat" class="form-label">Empleat:</label>
                <select class="form-select" aria-label="Default select example" id="empleat" name="empleat">
                    @foreach($empleats as $empleat)
                        <option selected="{{$empleat->id == $reserva->idEmpleat}}">{{$empleat->nom}}</option>
                    @endforeach
                </select>
            </div>
        @endisset

        <input type="submit" value="Crea Reserva" class="btn btn-success">


    </form>
@endsection
