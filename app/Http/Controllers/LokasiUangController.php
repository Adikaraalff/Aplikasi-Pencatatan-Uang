<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi_Uang;
use Yajra\DataTables\DataTables;

class LokasiUangController extends Controller
{
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
                // ->addColumn('keterangan', function (Lokasi_Uang $lk) {
                //     return 'Rp ' . number_format($lk->keterangan, 0, ',', '.');
                // })
                ->addColumn('action', function ($row) {
                    //$btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    $btn = '<form action="' . route('lokasi_uangs.destroy', $row->id) . '"method="POST">
                    <a class="btn btn-primary mr-2" href="' . route('lokasi_uangs.edit', $row->id) . '">Edit</a>' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger">Delete</button>
                    </form>';
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
}
