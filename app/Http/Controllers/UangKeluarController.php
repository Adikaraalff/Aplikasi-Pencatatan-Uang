<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uang_Keluar;
use App\Models\Lokasi_Uang;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use PDF;

class UangKeluarController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'permission:uang_Keluar-list|uang_Keluar-create|uang_Keluar-edit|uang_Keluar-delete',
            ['only' => ['index', 'show']]
        );
        $this->middleware('permission:uang_Keluar-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:uang_Keluar-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:uang_Keluar-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $query_data = Uang_Keluar::query();

            if ($request->has('sSearch') && $request->input('sSearch')) {
                $search_value = '%' . $request->input('sSearch') . '%';
                $query_data->where(function ($query) use ($search_value) {
                    $query->where('created_by', 'like', $search_value)
                        ->orWhere('keterangan', 'like', $search_value);
                });
            }

            return DataTables::of($query_data)
                ->addIndexColumn()
                ->addColumn('id_lokasi_uang', function (Uang_Keluar $uk) {
                    return $uk->Lokasi_Uang->nama;
                })
                ->addColumn('jumlah', function (Uang_Keluar $uk) {
                    return 'Rp' . number_format($uk->jumlah, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . route('uang_keluars.destroy', $row->id) . '" method="POST">';
                    if (Auth::user()->can('uang_Keluar-edit')) {
                        $btn .= '<a class="btn btn-primary" href="' . route('uang_keluars.edit', $row->id) . '"><i class="bi bi-pencil"></i>Edit</a>';
                    }
                    if (Auth::user()->can('uang_Keluar-delete')) {
                        $btn .= "<a href=\"#\" onclick=\"deleteConfirm('" . route('uang_keluars.destroy', $row->id) . "')\" class=\"btn btn-danger\"><i class=\"fa fa-trash\"></i>Delete</a>";
                    }
                    $btn .= '</form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('keuangan.uang_keluars.index');
    }
    public function index_old()
    {
        $uang_Keluar = Uang_Keluar::latest()->paginate(5);
        return view('keuangan.uang_keluars.index', compact('uang_Keluar'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $lokasi_Uang = Lokasi_Uang::all();
        return view('keuangan.uang_keluars.create', compact('lokasi_Uang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'created_by' => 'required',
            'lokasi_Uang' => 'required',
            'jumlah' => 'required',
            'keterangan' => 'required',
        ]);

        $input = $request->all();
        $profileImage = null;

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['file'] = $profileImage;
        }

        $uangKeluar = new Uang_Keluar([
            'created_by' => $input['created_by'],
            'id_lokasi_uang' => $input['lokasi_Uang'],
            'jumlah' => $input['jumlah'],
            'keterangan' => $input['keterangan'],
            'file' => $profileImage,
        ]);
        $uangKeluar->save();

        return redirect('/uang_keluars')->with('success', 'Data created successfully');
    }
    public function edit($id)
    {
        $uang_Keluar = Uang_Keluar::find($id);
        $lokasi_Uang = Lokasi_Uang::all();
        return view('keuangan.uang_keluars.edit', compact('uang_Keluar', 'lokasi_Uang'));
    }

    public function update(Request $request, $id)
    {
        $uang_Keluar = Uang_Keluar::find($id);

        $profileImage = null;

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['file'] = $profileImage;
        }

        $input = $request->all();

        $data = [
            'created_by' => $input['created_by'],
            'id_lokasi_uang' => $input['lokasi_uang'],
            'jumlah' => $input['jumlah'],
            'keterangan' => $input['keterangan'],
            'file' => $profileImage,
        ];

        $uang_Keluar->update($data);


        return redirect('/uang_keluars');
    }
    public function destroy($id)
    {
        $uang_Keluar = Uang_Keluar::find($id);
        $uang_Keluar->delete();

        return redirect('/uang_keluars');
    }
    public function exportPdf()
    {
        $uang_Keluar = Uang_Keluar::all();
        $pdf = PDF::loadView('keuangan.uang_keluars.exportpdf', ['uang_Keluar' => $uang_Keluar]);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->stream('LaporanDataKeuangan.pdf');
    }
}
