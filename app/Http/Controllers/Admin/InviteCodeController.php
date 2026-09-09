<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InviteCode;
use Illuminate\Support\Str;

class InviteCodeController extends Controller
{
    public function index()
    {
        $inviteCodes = InviteCode::with('usedByUser')->latest()->get();

        return view('admin.invite-codes.index', compact('inviteCodes'));
    }

    public function store()
    {
        $code = 'ADM-' . strtoupper(Str::random(8));

        InviteCode::create([
            'code' => $code,
        ]);

        return redirect()->route('admin.invite-codes.index')
            ->with('success', "Kode invite baru berhasil dibuat: {$code}");
    }

    public function destroy(InviteCode $inviteCode)
    {
        if ($inviteCode->is_used) {
            return back()->with('error', 'Kode yang sudah dipakai tidak bisa dihapus.');
        }

        $inviteCode->delete();

        return redirect()->route('admin.invite-codes.index')
            ->with('success', 'Kode invite berhasil dihapus.');
    }
}
