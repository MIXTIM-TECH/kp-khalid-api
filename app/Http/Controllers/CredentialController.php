<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\Credential;
use App\Models\KK;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CredentialController extends Controller
{
    private $time;

    public function __construct()
    {
        $this->time = time();
    }

    public function activation(Credential $userCredential)
    {
        $userCredential->status = "aktif";
        $userCredential->save();
        return Response::message("Aktivasi Berhasil", 200);
    }

    public function reject(Credential $userCredential)
    {
        $userCredential->status = "ditolak";
        $userCredential->save();
        return Response::message("Pendaftar Ditolak", 200);
    }

    public function pendaftar(Request $request)
    {
        $dataPendaftar = Credential::with("user")->whereHas("waktuAktivasi", function (Builder $query) {
            $query->where("batas_aktivasi", ">", $this->time);
        })->where("status", "tidak_aktif");
        $dataPendaftar = (new Filters($dataPendaftar, $request))->search("username")->beforeDate()->afterDate()->result();

        return Response::success($dataPendaftar->get()->toArray());
    }

    public function pendaftarKadaluarsa(Request $request)
    {
        $dataPendaftarKadaluarsa = Credential::with("user")->whereHas("waktuAktivasi", function (Builder $query) {
            $query->where("batas_aktivasi", "<", $this->time);
        })->where("status", "tidak_aktif");
        $dataPendaftarKadaluarsa = (new Filters($dataPendaftarKadaluarsa, $request))->search("username")->afterDate()->beforeDate()->result();

        return Response::success($dataPendaftarKadaluarsa->get()->toArray());
    }

    public function pendaftarDitolak(Request $request)
    {
        $dataPendaftarDitolak = Credential::with("user")->where("status", "ditolak");
        $dataPendaftarDitolak = (new Filters($dataPendaftarDitolak, $request))->search("username")->afterDate()->beforeDate()->result();
        return Response::success($dataPendaftarDitolak->get()->toArray());
    }

    public function admin(Request $request)
    {
        $dataAdmin = Credential::where("role", "admin");
        $dataAdmin = (new Filters($dataAdmin, $request))->search("username")->result();
        return Response::success($dataAdmin->get());
    }

    public function createAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username"      => "required|string|unique:credentials,username",
            "password"      => "required|min:8|string"
        ]);

        if ($validator->fails()) return Response::errors($validator);

        $admin = new Credential;
        $admin->username = $request->username;
        $admin->password = password_hash($request->password, PASSWORD_DEFAULT);
        $admin->role = "admin";
        $admin->status = "aktif";
        $admin->save();

        return Response::success($admin->toArray());
    }

    public function destroyAdmin(Credential $admin)
    {
        return $admin->delete() ? Response::message("Admin Berhasil Dihapus", 200) : Response::message("Gagal Menghapus");
    }

    public function update(Request $request, Credential $credential)
    {
        $validator = Validator::make($request->all(), [
            "username"   => "required|string",
            "password"   => "min:8|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        if ($request->username !== $credential->username) {
            $validator = Validator::make($request->all(), [
                "username"  => "unique:credentials,username"
            ]);
        }

        $result = DB::transaction(function () use ($credential, $request) {
            $credential->username = $request->username;
            if ($request->password) $credential->password = password_hash($request->password, PASSWORD_DEFAULT);

            // jika user update kk
            if ($credential->role === "user") {
                $kk = KK::where("nik_kepala_keluarga", $credential->username)->first();
                $kk->nik_kepala_keluarga = $credential->username;
                $kk->save();
            }

            $credential->save();
            return $credential;
        });

        $payload = AuthController::getPayload($result->username, $result->role);
        return AuthController::getAuth($payload);
    }

    public function deleteAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "no_kk"     => "required|exists:kk,no_kk"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $kk = KK::find($request->no_kk);
        if ($request->user->role === "user") {
            //
        }
    }
}
