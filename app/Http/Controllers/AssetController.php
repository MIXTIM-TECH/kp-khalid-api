<?php

namespace App\Http\Controllers;

use App\Http\Res\Response;
use App\Models\KK;
use App\Models\Penduduk;
use App\Models\Surat;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "token"     => "required|string",
            "file"      => "required|string"
        ]);
        if ($validator->fails()) return Response::errors($validator);

        try {
            $payload = JWT::decode($request->token, new Key(env("JWT_SECRET"), "HS256"));
            $request->user = $payload;

            return response()->download($request->file);
        } catch (Exception $e) {
            return Response::message($e->getMessage());
        }
    }

    public function info(Request $request)
    {
        $accLetters = [];
        $notAccLetters = [];
        $year = date("Y");

        for ($i = 1; $i <= 12; $i++) {
            $min = $i < 10 ? "0{$i}" : $i;
            
            $next = $i < 12 ? $i + 1 : $i;
            $max = $next < 10 ? "0{$next}" : "{$next}";

            if ($i < 12) {
                $acc = Surat::where("created_at", ">=", "{$year}-{$min}-1")
                    ->where("created_at", "<", "{$year}-{$max}-1")
                    ->where("acc", true);
                $notAcc = Surat::where("created_at", ">=", "{$year}-{$min}-1")
                    ->where("created_at", "<", "{$year}-{$max}-1")
                    ->where("acc", false);

                if ($request->user->role === "user") {
                    $acc->where("no_kk", $request->user->no_kk);
                    $notAcc->where("no_kk", $request->user->no_kk);
                }

                array_push($accLetters, $acc->get()->count());
                array_push($notAccLetters, $notAcc->get()->count());
            }
        }

        $datasets = [
            [
                "label"             => "Surat di ACC",
                "data"              => $accLetters,
                "backgroundColor"   => "rgba(255, 99, 132, 0.5)"
            ],
            [
                "label"             => "Surat Belum di ACC",
                "data"              => $notAccLetters,
                "backgroundColor"   => "rgba(53, 162, 235, 0.5)"
            ]
        ];

        $graph = [
            "labels"    => [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "Mei",
                "Jun",
                "Jul",
                "Agu",
                "Sep",
                "Okt",
                "Nov",
                "Des"
            ],
            "datasets"  => $datasets
        ];

        if ($request->user->role === "user") {
            $kk = KK::find($request->user->no_kk);

            $response = [
                "total_letter"  => $kk->jumlah_surat_diajukan,
                "total_family"  => $kk->jumlah_keluarga
            ];
        } else {
            $response = [
                "total_letter"      => Surat::count(),
                "total_kk"          => KK::whereHas("credential", function ($query) {
                    $query->where("status", "aktif");
                })->count(),
                "total_population"  => Penduduk::whereHas("kk.credential", function($query) {
                    $query->where("status", "aktif");
                })->count()
            ];
        }

        $response["graph"] = $graph;
        return Response::success($response);
    }
}
