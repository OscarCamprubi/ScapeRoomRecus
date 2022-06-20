@extends('layouts.app')
@section('title')
    @empty($user)
        Not found
    @endempty
    @isset($userShow)
        {{$userShow->name}}
    @endisset
@endsection
@section('contingut')
    @empty($userShow)
        <h1 class="text-center">Not found</h1>
    @endempty
    @isset($userShow)
        <div class="card mt-5">
            <div class="card-header">
                <h1 class="card-title m-3">{{$userShow->name}}</h1>
            </div>
            <div class="card-body">
                <h6 class="card-text">Email: {{$userShow->email}}</h6>
                <p class="card-text">Data de Naixement: {{$userShow->bornDate}}</p>
                <hr class="dropdown-divider mt-4 mb-4">
                <h3 class="text-center">Les meves Reserves</h3>
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
                    @isset($reserves)
                        @foreach($reserves as $reserva)
                            <tr>
                                @if($reserva->validated == 0)
                                    <td>No Validat</td>
                                @else
                                    <td>Validat</td>
                                @endif
                                @if($reserva->finalized == 0)
                                    <td>No Finalitzat</td>
                                @else
                                    <td>Finalitzat</td>
                                @endif
                                @if($reserva->win == 0)
                                    <td>No guanyat</td>
                                @else
                                    <td>Guanyat</td>
                                @endif
                                @if($reserva->rated == 0)
                                    <td>No Valorat</td>
                                @else
                                    <td>Valorat</td>
                                @endif
                                <td>
                                    @if($reserva->validated == 0)
                                        <a class="btn btn-info" href="/edit-reserva/{{$reserva->id}}">Edita Reserva</a>
                                        <a class="btn btn-danger" href="/delete-reserva/{{$reserva->id}}">Cancel·la</a>
                                    @endif
                                    @if($reserva->finalized == 1)
                                        @if($reserva->rated == 0)
                                            <a class="btn btn-primary"
                                               href="/create-valoracio/{{$reserva->id}}">Valora!</a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
                <hr class="dropdown-divider mt-4 mb-4">
                <h3 class="text-center">Els meus Descomptes</h3>
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
                    @isset($vouchers)
                        @foreach($vouchers as $voucher)
                            <tr>
                                <td>
                                    <p>{{$voucher->nom}}</p>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
            <div class="card-footer p-4">
                <a class="btn btn-primary me-3" href="/edit-user/{{$userShow->id}}">Edita</a>
                <a class="btn btn-danger" href="/delete-user/{{$userShow->id}}">Elimina</a>
            </div>
        </div>
    @endisset
@endsection
