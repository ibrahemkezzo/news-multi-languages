<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.categories.index');
    }


    public function getCategoriesDatatable()
    {
        $data = Category::select('*')->with('parents');

        return  Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                if (auth()->user()->can('viewAny', $this->setting)) {
                    return $btn = '
                        <a href="' . Route('dashboard.category.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>
                        <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"  data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
                }
            })

            ->addColumn('parent', function ($row) {
                return ($row->parent ==  0) ? trans('words.main category') :   $row->parents->translate(app()->getLocale())->title;
            })


            ->addColumn('title', function ($row) {
                return $row->translate(app()->getLocale())->title;
            })
            ->addColumn('status', function ($row) {
                return $row->status == null ? __('words.not activated') : __('words.' . $row->status);
            })
            ->rawColumns(['action', 'status', 'title'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $this->authorize('viewAny', $this->setting);
        $categories = Category::whereNull('parent')->orWhere('parent', 0)->get();
        return view('dashboard.categories.add', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = [
        //     'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        // ];
        foreach (config('app.languages') as $key => $value) {
            $data[$key . '*.title'] = 'nullable|string';
            $data[$key . '*.content'] = 'nullable|string';
            $data[$key . '*.address'] = 'nullable|string';
        }
        // $validatedData = $request->validate($data);

        $this->authorize('viewAny', $this->setting);
        // dd($request->file());
        $category =  $request->except('image', '_token');
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = '/images/' . $filename;
            // dd($path);
            $category['image'] = $path;
        }
        Category::create($category);
        return redirect()->route('dashboard.category.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        $this->authorize('viewAny', $this->setting);
        $categories = Category::whereNull('parent')->orWhere('parent', 0)->get();
        return view('dashboard.categories.edit', compact('category', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $this->authorize('viewAny', $this->setting);
        $category->update($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;

            $category->update(['image' => $path]);
        }
        return redirect()->route('dashboard.category.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function delete(Request $request)
    {
        $this->authorize('viewAny', $this->setting);
        if (is_numeric($request->id)) {
            Category::where('parent', $request->id)->delete();
            Category::where('id', $request->id)->delete();
        }

        return redirect()->route('dashboard.category.index');
    }
}
