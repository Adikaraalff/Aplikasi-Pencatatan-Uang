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
                    return 'Rp ' . number_format($um->jumlah, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    //$btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
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
        $lokasi_Uang = Lokasi_Uang::all(); // Mengambil data lokasi uang
        return view('keuangan.uang_masuks.create', compact('lokasi_Uang'));
    }

    public function store(Request $request)
    {
        // $uang_Masuk = new Uang_Masuk;
        // $uang_Masuk->created_by = $request->created_by;
        // $uang_Masuk->id_lokasi_uang = $request->lokasi_Uang;
        // $uang_Masuk->jumlah = $request->jumlah;
        // $uang_Masuk->keterangan = $request->keterangan;
        // $uang_Masuk->save();

        // dd($request->all());
        $input = $request->all();
        $create_by = strtolower($input['created_by']);
        $data = Uang_Masuk::where('created_by', $create_by)->first();
        $res = 0;
        if ($data != null) {
            $jumlah = $data->jumlah + $input['jumlah'];
            $res = Uang_Masuk::where('created_by', '=', $data->created_by)->update(['jumlah' => $jumlah]);

            if ($res > 0) {
                echo 'success';
                return redirect('/uang_masuks');
            } else {
                echo 'failed';
            }
        } else {
            Uang_Masuk::create([
                'created_by' => $input['created_by'],
                'id_lokasi_uang' => $input['lokasi_Uang'],
                'jumlah' => $input['jumlah'],
                'keterangan' => $input['keterangan'],
            ]);
        }
        return redirect('/uang_masuks');
    }

    // Metode lain tidak berubah
}
