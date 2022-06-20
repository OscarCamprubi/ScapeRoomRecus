<?php

namespace App\Http\Controllers;

use App\Models\Joc;
use App\Models\Participant;
use App\Models\Reserva;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    public function list($idReserva)
    {
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            return view('participant.llistaParticipants')->with('participants', DB::table('participants')->where('idReserva', $idReserva)->get())->with('reserva', $idReserva);
        }
        return view('participant.llistaParticipants')->with('participants', DB::table('participants')->where('idReserva', $idReserva)->get())->with('reserva', $idReserva);
    }

    public function create($idReserva)
    {
        $participants = DB::table('participants')->where('idReserva', $idReserva);
        $reserva = Reserva::find($idReserva);
        $sala = Sala::find($reserva->idSala);
        $joc = Joc::find($sala->idJoc);
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());

            if (count($participants) == $joc->maxJugadors) {
                return view('participant.createParticipant')->with('user', $user)->with('maxCapacity', true)->with('reserva', $idReserva);
            }
            return view('participant.createParticipant')->with('user', $user)->with('reserva', $idReserva);
        }
        if (count($participants) == $joc->maxJugadors) {
            return view('participant.createParticipant')->with('maxCapacity', true)->with('reserva', $idReserva);
        }
        return view('participant.createParticipant')->with('reserva', $idReserva);
    }

    public function save(Request $request)
    {
        $req = request()->all();
        $validated = $this->validaParticipant($request);


        $participant = new Participant();
        $participant->nom = $req['nom'];
        $participant->idReserva = $req['reserva'];
        $participant->save();
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            return redirect('/list-participant/' . $req['reserva'])->with('user', $user);
        }
        return redirect('/list-participant/' . $req['reserva']);

    }

    public function edit($idParticipant)
    {
        $participant = Participant::find($idParticipant);
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            return view('participant.editParticipant')->with('participant', $participant)->with('user', $user)->with('reserva', $participant->idReserva);
        }
        return view('participant.editParticipant')->with('participant', $participant)->with('reserva', $participant->idReserva);
    }

    public function update(Request $req)
    {
        $validated = $this->validaParticipant($req);
        $data = $req->all();
        $sala = Participant::find($data['id']);
        $sala->nom = $data['nom'];
        $sala->save();
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            return redirect('/list-participant')->with('user', $user);
        }
        //return redirect('/list-participant/' . $reserva->id);

    }

    public function delete($idParticipant)
    {
        $participant = Participant::find($idParticipant);
        $participant->delete();
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            return redirect('/list-participant')->with('user', $user);
        }
        return redirect('/list-participant');
    }

    public function validaParticipant($request)
    {
        return $request->validate([
            'nom' => 'required'
        ]);
    }
}
