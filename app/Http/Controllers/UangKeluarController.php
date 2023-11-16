<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uang_Keluar;
use App\Models\Lokasi_Uang;
use Yajra\DataTables\DataTables;

class UangKeluarController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $query_data = new Uang_Keluar();

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data->where(function ($query) use ($search_value) {
                    $query->where('created_by', 'like', '%' . $search_value . '%')
                        ->orWhere('keterangan', 'like', '%' . $search_value . '%');
                });
            }
            $data = $query_data->orderBy('created_by', 'asc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('id_lokasi_uang', function (Uang_Keluar $uk) {
                    return $uk->Lokasi_Uang->nama;
                })
                ->addColumn('jumlah', function (Uang_Keluar $uk) {
                    return 'Rp' . number_format($uk->jumlah, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . route('uang_keluars.destroy', $row->id) . '"method="POST">
                    <a class="btn btn-primary mr-2" href="' . route('uang_keluars.edit', $row->id) . '">Edit</a>' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger">Delete</button>
                    </form>';
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
}
