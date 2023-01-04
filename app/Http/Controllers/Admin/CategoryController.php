<?php

namespace App\Http\Controllers\Admin;

use App\Components\recursive;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index_customer(Request $request,$slug, $id)
    {
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        $products = Product::where('category_id',$id)->take(12)->paginate(12);
        $categoryParents = Category::where('parent_id', 0)->get();

        //seo
        $category = Category::where('id',$id)->first();
        $meta_desc = $category->meta_description;
        $meta_keywords = $category->meta_keyword;
        $meta_title = $category->name;
        $url_canonical = $request->url();

        return view('pages.product.category.list', compact('categoryMenuParents', 'products', 'categoryParents',
            'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'
        ));
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->paginate(5);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $optionSelect = $this->getCategory($parent_id = '');
        return view('admin.category.create',[
            'htmlOption' => $optionSelect
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->category->create([
            'name' => $request->name,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'parent_id' => $request->parent_id,
            'slug'=>Str::of($request->name)->slug('-')
        ]);
        Session::flash('success','Add danh mục '.$category->name.' success!!');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    public function getCategory($parent_id)
    {
        $data = $this->category->all();
        $recursive = new recursive($data);
        $htmlOption = $recursive->CategoryRecursive($parent_id);
        return $htmlOption;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $htmlOption = $this->getCategory($category->parent_id);
        return view('admin.category.edit', compact('category','htmlOption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'parent_id' => $request->parent_id,
            'slug'=>Str::of($request->name)->slug('-')
        ]);
        session()->flash('success','Cập nhật danh mục '.$category->name.' thành công!!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }
}
