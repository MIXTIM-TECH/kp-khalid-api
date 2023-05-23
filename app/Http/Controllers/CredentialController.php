<?php

namespace App\Http\Controllers;

use App\Http\Response\Response;
use App\Models\Credential;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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

    public function pendaftar()
    {
        $dataPendaftar = Credential::with("penduduk")->whereHas("waktuAktivasi", function (Builder $query) {
            $query->where("batas_aktivasi", ">", $this->time);
        })->where("status", "tidak_aktif")->get();

        return Response::success($dataPendaftar->toArray());
    }

    public function pendaftarKadaluarsa()
    {
        $dataPendaftarKadaluarsa = Credential::with("penduduk")->whereHas("waktuAktivasi", function (Builder $query) {
            $query->where("batas_aktivasi", "<", $this->time);
        })->where("status", "tidak_aktif")->get();

        return Response::success($dataPendaftarKadaluarsa->toArray());
    }

    public function pendaftarDitolak()
    {
        $dataPendaftarDitolak = Credential::with("penduduk")->where("status", "ditolak")->get();
        return Response::success($dataPendaftarDitolak->toArray());
    }

    public function admin()
    {
        $dataAdmin = Credential::where("role", "admin")->get();
        return Response::success($dataAdmin);
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
        return $admin->delete() ? Response::message("Admin Berhasil Dihapus") : Response::message("Gagal Menghapus");
    }

    public function updateProfile(Request $request)
    {
        $rules = ["username" => "required|string"];

        if ($request->user->role === "user") $rules["username"] .= "|exists:anggota_keluarga,nik";
        if ($request->user->username !== $request->username) $rules .= "|unique:credentials,username";

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return Response::errors($validator);

        // update credential
        $userCredential = Credential::find($request);
        $userCredential->username = $request->username;
        $userCredential->save();

        return Response::success($userCredential);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "oldPassword"   => "required|string",
            "password"      => "required|min:8|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        $userCredential = Credential::find($request->user->username);
        // cek password
        if (!password_verify($request->password, $userCredential->password)) {
            return $this->unknownResponse("Password salah!", 400);
        }

        // update credential
        $userCredential->password = password_hash($request->password, PASSWORD_DEFAULT);
        $userCredential->save();

        return Response::success($userCredential);
    }
}
