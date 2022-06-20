@extends('layouts.app')
@section('title')
    Llistat de Reserves
@endsection
@section('contingut')
    <h1 class="text-center mt-3">Llista de Reserves</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Validat</th>
            <th scope="col">Finalitzat</th>
            <th scope="col">Guanyat</th>
            <th scope="col">Valorat</th>
            <th scope="col">Accions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reserves as $reserva)
            <tr>
                @if($reserva->validated == 0)
                    <td>
                        No Validat
                        @if($user->role === 1)
                            <a href="valida-invalida/{{$reserva->id}}" class="btn btn-success ms-3">Valida</a>
                        @endif
                    </td>
                @else
                    <td>
                        Validat
                        @if($user->role === 1)
                            <a href="valida-invalida/{{$reserva->id}}" class="btn btn-danger">Invalida</a>
                        @endif
                    </td>
                @endif
                @if($reserva->finalized == 0)
                    <td>
                        No Finalitzat
                        <a href="finalitzat-no-finalitzat/{{$reserva->id}}" class="btn btn-success ms-3">Finalitza</a>
                    </td>
                @else
                    <td>
                        Finalitzat
                        <a href="finalitzat-no-finalitzat/{{$reserva->id}}" class="btn btn-danger ms-3">No
                            Finalitzis</a>
                    </td>
                @endif
                @if($reserva->win == 0)
                    <td>
                        Perdut
                        <a href="guanyat-perdut/{{$reserva->id}}" class="btn btn-success ms-3">Guanyat</a>
                    </td>
                @else
                    <td>
                        Guanyat
                        <a href="guanyat-perdut/{{$reserva->id}}" class="btn btn-danger ms-3">Perdut</a>
                    </td>
                @endif
                @if($reserva->rated == 0)
                    <td>No Valorat</td>
                @else
                    <td>Valorat</td>
                @endif
                <td>
                    @if($user->role === 1)
                        <a class="btn btn-info" href="edit-reserva/{{$reserva->id}}">Edita</a>
                    @endif
                    <a class="btn btn-warning" href="list-participant/{{$reserva->id}}">Participants</a>
                    @if($user->role === 1)
                        <a class=" btn btn-danger" href="delete-reserva/{{$reserva->id}}">Elimina</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

