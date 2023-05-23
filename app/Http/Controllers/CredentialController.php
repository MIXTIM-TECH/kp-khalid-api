<?php

namespace App\Http\Controllers;

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
        return $this->responseSuccess("Aktivasi Berhasil");
    }

    public function reject(Credential $userCredential)
    {
        $userCredential->status = "ditolak";
        $userCredential->save();
        return $this->responseSuccess("Pendaftar Ditolak");
    }

    public function pendaftar()
    {
        return $this->responseSuccess(Credential::with("penduduk")->whereHas("waktuAktivasi", function (Builder $query) {
            $query->where("batas_aktivasi", ">", $this->time);
        })->where("status", "tidak_aktif")->get());
    }

    public function pendaftarKadaluarsa()
    {
        return $this->responseSuccess(Credential::with("penduduk")->whereHas("waktuAktivasi", function (Builder $query) {
            $query->where("batas_aktivasi", "<", $this->time);
        })->where("status", "tidak_aktif")->get());
    }

    public function pendaftarDitolak()
    {
        return $this->responseSuccess(Credential::with("penduduk")->where("status", "ditolak")->get());
    }

    public function admin()
    {
        return $this->responseSuccess(Credential::where("role", "admin")->get());
    }

    public function createAdmin(Request $request)
    {
        $validationResult = $this->checkValidator(Validator::make($request->all(), [
            "username"      => "required|string|unique:credentials,username",
            "password"      => "required|min:8|string"
        ]));

        if ($validationResult !== true) return $validationResult;

        $admin = new Credential;
        $admin->username = $request->username;
        $admin->password = password_hash($request->password, PASSWORD_DEFAULT);
        $admin->role = "admin";
        $admin->status = "aktif";
        $admin->save();

        return $this->responseSuccess("Admin Created");
    }

    public function destroyAdmin(Credential $admin)
    {
        return $this->responseSuccess($admin->delete());
    }

    public function updateProfile(Request $request)
    {
        $rules = ["username" => "required|string"];

        if ($request->user->role === "user") $rules["username"] .= "|exists:anggota_keluarga,nik";
        if ($request->user->username !== $request->username) $rules .= "|unique:credentials,username";

        $validationResult = $this->checkValidator(Validator::make($request->all(), $rules));

        if ($validationResult !== true) return $validationResult;

        // update credential
        $userCredential = Credential::find($request);
        $userCredential->username = $request->username;
        $userCredential->save();

        return $this->responseSuccess($userCredential);
    }

    public function updatePassword(Request $request)
    {
        $validationResult = $this->checkValidator(Validator::make($request->all(), [
            "oldPassword"   => "required|string",
            "password"      => "required|min:8|string"
        ]));

        if ($validationResult !== true) return $validationResult;

        $userCredential = Credential::find($request->user->username);

        // cek password
        if (!password_verify($request->password, $userCredential->password)) {
            return $this->unknownResponse("Password salah!", 400);
        }

        // update credential
        $userCredential->password = password_hash($request->password, PASSWORD_DEFAULT);
        $userCredential->save();

        return $this->responseSuccess($userCredential);
    }
}
