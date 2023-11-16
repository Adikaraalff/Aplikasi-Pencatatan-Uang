<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uang_Masuk;
use App\Models\Lokasi_Uang;
use Yajra\DataTables\DataTables;

class UangMasukController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $query_data = new Uang_Masuk();

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
                ->addColumn('id_lokasi_uang', function (Uang_Masuk $um) {
                    return $um->Lokasi_Uang->nama;
                })
                ->addColumn('jumlah', function (Uang_Masuk $um) {
                    return 'Rp' . number_format($um->jumlah, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . route('uang_masuks.destroy', $row->id) . '"method="POST">
                    <a class="btn btn-primary mr-2" href="' . route('uang_masuks.edit', $row->id) . '">Edit</a>' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger">Delete</button>
                    </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('keuangan.uang_masuks.index');
    }
    public function index_old()
    {
        $uang_Masuk = Uang_Masuk::latest()->paginate(5);
        return view('keuangan.uang_masuks.index', compact('uang_Masuk'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $lokasi_Uang = Lokasi_Uang::all();
        return view('keuangan.uang_masuks.create', compact('lokasi_Uang'));
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

        $uangMasuk = new Uang_Masuk([
            'created_by' => $input['created_by'],
            'id_lokasi_uang' => $input['lokasi_Uang'],
            'jumlah' => $input['jumlah'],
            'keterangan' => $input['keterangan'],
            'file' => $profileImage,
        ]);
        $uangMasuk->save();

        return redirect('/uang_masuks')->with('success', 'Data created successfully');
    }
    public function edit($id)
    {
        $uang_Masuk = Uang_Masuk::find($id);
        $lokasi_Uang = Lokasi_Uang::all();
        return view('keuangan.uang_masuks.edit', compact('uang_Masuk', 'lokasi_Uang'));
    }
    public function update(Request $request, $id)
    {
        $uang_Masuk = Uang_Masuk::find($id);

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

        $uang_Masuk->update($data);


        return redirect('/uang_masuks');
    }
    public function destroy($id)
    {
        $uang_Masuk = Uang_Masuk::find($id);
        $uang_Masuk->delete();

        return redirect('/uang_masuks');
    }
}
