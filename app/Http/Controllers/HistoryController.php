<?php

namespace App\Http\Controllers;

use App\Models\HistoryModel;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function historytampil()
    {
        $datahistory = HistoryModel::orderby('id_history', 'ASC')->paginate(6);
        return view('halaman/view_history', ['history' => $datahistory]);
    }

    public function historyhapus($id_history)
    {
        try {
            HistoryModel::findOrFail($id_history)->delete();
            return redirect('/history')->with('success', 'Data history berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/history')->with('error', 'Data history gagal dihapus.');
        }
    }
}
