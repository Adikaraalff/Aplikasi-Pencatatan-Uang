<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi_Uang;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use PDF;

class LokasiUangController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'permission:lokasi_Uang-list|lokasi_Uang-create|lokasi_Uang-edit|lokasi_Uang-delete',
            ['only' => ['index', 'show']]
        );
        $this->middleware('permission:lokasi_Uang-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:lokasi_Uang-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:lokasi_Uang-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $query_data = new Lokasi_Uang();

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data->where(function ($query) use ($search_value) {
                    $query->where('nama', 'like', '%' . $search_value . '%')
                        ->orWhere('keterangan', 'like', '%' . $search_value . '%');
                });
            }
            $data = $query_data->orderBy('nama', 'asc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . route('lokasi_uangs.destroy', $row->id) . '" method="POST">';
                    if (Auth::user()->can('lokasi_Uang-edit')) {
                        $btn = $btn . '<a class="btn btn-primary" href="' . route('lokasi_uangs.edit', $row->id) . '"><i class="bi bi-pencil"></i>Edit</a>';
                    }
                    if (Auth::user()->can('lokasi_Uang-delete')) {
                        $btn = $btn . '<a href="#" onclick="deleteConfirm(\'' . route('lokasi_uangs.destroy', $row->id) . '\')" class="btn btn-danger"><i class="fa fa-trash"></i>Delete</a>';
                    }
                    $btn = $btn . '</form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('keuangan.lokasi_uangs.index');
    }

    public function index_old()
    {
        $Lokasi_Uang = Lokasi_Uang::latest()->paginate(5);
        return view('keuangan.lokasi_uangs.index', compact('Lokasi_Uang'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('keuangan.lokasi_uangs.create');
    }

    public function store(Request $request)
    {
        $lokasi_Uang = new Lokasi_Uang;
        $lokasi_Uang->nama = $request->nama;
        $lokasi_Uang->keterangan = $request->keterangan;
        $lokasi_Uang->save();

        return redirect('/lokasi_uangs');
    }

    public function edit($id)
    {
        $lokasi_Uang = Lokasi_Uang::find($id);
        return view('keuangan.lokasi_uangs.edit', compact('lokasi_Uang'));
    }

    public function update(Request $request, $id)
    {
        $lokasi_Uang = Lokasi_Uang::find($id);
        $lokasi_Uang->nama = $request->nama;
        $lokasi_Uang->keterangan = $request->keterangan;
        $lokasi_Uang->save();

        return redirect('/lokasi_uangs');
    }

    public function destroy($id)
    {
        $lokasi_Uang = Lokasi_Uang::find($id);
        $lokasi_Uang->delete();

        return redirect('/lokasi_uangs');
    }
    public function exportPdf()
    {
        $lokasi_Uang = Lokasi_Uang::all();
        $pdf = PDF::loadView('keuangan.lokasi_uangs.exportpdf', ['lokasi_Uang' => $lokasi_Uang]);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->stream('LaporanDataKeuangan.pdf');
    }
}
