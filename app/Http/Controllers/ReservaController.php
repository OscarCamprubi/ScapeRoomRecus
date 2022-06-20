<?php

namespace App\Http\Controllers;

use App\Models\Joc;
use App\Models\Participant;
use App\Models\Reserva;
use App\Models\Sala;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function list()
    {
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            return view('reserva.llistaReserves')->with('reserves', Reserva::all())->with('user', $user);
        }
        return view('reserva.llistaReserves')->with('jocs', Reserva::all());
    }

    public function show($idReserva)
    {
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            return view('reserva.showReserva')->with('reserva', Reserva::find($idReserva))->with('user', $user);
        }
        return view('reserva.showReserva')->with('reserva', Reserva::find($idReserva));
    }

    public function create($jocID)
    {
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            $sales = DB::table('sales')->where('idJoc', $jocID)->get();
            $vouchers = DB::table('vouchers')->where('idUser', $user->id)->get();
            if ($user->role === 1) {
                $empleats = DB::table('users')->where("role", 1)->where("role", 3)->get();
                return view('reserva.createReserva')->with('user', $user)->with('vouchers', $vouchers)
                    ->with('sales', $sales)->with('empleats', $empleats)->with('joc', Joc::find($jocID));
            } else {
                return view('reserva.createReserva')->with('user', $user)->with('vouchers', $vouchers)
                    ->with('sales', $sales)->with('joc', Joc::find($jocID));
            }
        }
        return redirect('/login');
    }

    public function save(Request $request)
    {
        $req = request()->all();
        $validated = $this->validaReserva($request);
        $user = User::find(Auth::id());

        $res = new Reserva();
        $res->idUser = Auth::id();
        $res->idSala = $req['sala'];
        if (isset($req['empleat'])) {
            $res->idEmpleat = $req['empleat'];
        } else {
            $res->idEmpleat = null;
        }
        if (isset($req['voucher'])) {
            $res->idVoucher = $req['voucher'];
        } else {
            $res->idVoucher = null;
        }
        $res->validated = false;
        $res->rated = false;
        $res->win = false;
        $res->finalized = false;
        $res->save();
        $participant = new Participant();
        $participant->nom = $user->name;
        $participant->idReserva = $res->id;
        $participant->save();
        if (Auth::id() !== null) {
            return redirect('/list-participant/' . $res->id);
        }
        return redirect('/');

    }

    public function edit($idReserva)
    {
        $reserva = Reserva::find($idReserva);
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            $sala = Sala::find($reserva->idSala);
            $sales = DB::table('sales')->where('idJoc', $sala->idJoc)->get();
            $vouchers = DB::table('vouchers')->where('idUser', $user->id)->get();
            if ($user->role === 1) {
                $empleats = DB::table('users')->where("role", 1)->where("role", 3)->get();
                return view('reserva.editReserva')->with('user', $user)->with('vouchers', $vouchers)
                    ->with('sales', $sales)->with('empleats', $empleats)->with('joc', Joc::find($sala->idJoc))->with('reserva', $reserva);
            } else {
                return view('reserva.editReserva')->with('user', $user)->with('vouchers', $vouchers)
                    ->with('sales', $sales)->with('joc', Joc::find($sala->idJoc))->with('reserva', $reserva);
            }
        }
        return redirect('/login');
    }

    public function update(Request $request)
    {
        $req = request()->all();
        $validated = $this->validaReserva($request);


        $res = Reserva::find($req['id']);
        $res->id_sala = $req['idSala'];
        if (isset($req['idEmpleat'])) {
            $res->idEmpleat = $req['idEmpleat'];
        }
        $res->id_voucher = $req['idVoucher'];
        $res->save();
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            return redirect('/show-reserva/' . $res->id)->with('user', $user);
        }
        return redirect('/show-reserva/' . $res->id);

    }

    public function delete($idReserva)
    {
        $reserva = Reserva::find($idReserva);
        $reserva->delete();
        if (Auth::id() !== null) {
            $user = User::find(Auth::id());
            return redirect('/list-reserva/')->with('user', $user);
        }
        return redirect('/list-reserva');
    }

    public function validaReserva($request)
    {
        return $request->validate([
            'sala' => 'required',
        ]);
    }

    public function validaInvalida($idReserva)
    {
        $reserva = Reserva::find($idReserva);
        if ($reserva->validated) {
            $reserva->validated = false;
        } else {
            $reserva->validated = true;
        }
        $reserva->save();
        return redirect('/list-reserva');
    }

    public function finalitzatNoFinalitzat($idReserva)
    {
        $reserva = Reserva::find($idReserva);
        if ($reserva->finalized) {
            $reserva->finalized = false;
        } else {
            $reserva->finalized = true;
        }
        $reserva->save();
        return redirect('/list-reserva');
    }

    public function guanyatPerdut($idReserva)
    {
        $reserva = Reserva::find($idReserva);
        if ($reserva->win) {
            $reserva->win = false;
        } else {
            $reserva->win = true;
            $voucher = new Voucher();
            $voucher->nom = 'game_won';
            $voucher->idUser = $reserva->idUser;
            $voucher->redeemed = false;
            $voucher->save();
        }
        $reserva->save();
        return redirect('/list-reserva');
    }

}
