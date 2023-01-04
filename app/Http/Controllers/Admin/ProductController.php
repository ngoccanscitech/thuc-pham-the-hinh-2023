<?php

namespace App\Http\Controllers\Admin;

use App\Components\recursive;
use App\Http\Requests\AddProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Tag;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use StorageImageTrait, DeleteModelTrait;

    private $category;
    private $product;
    private $tag;
    private $productTag;
    private $brand;

    public function __construct(Category $category, Product $product,
    Tag $tag, ProductTag $productTag, Brand $brand
    )
    {
        $this->category = $category;
        $this->product = $product;
        $this->tag = $tag;
        $this->productTag = $productTag;
        $this->brand = $brand;
    }

    public function show(Product $product)
    {
        /*
         * Từ product này lấy ra những product cùng một danh mục với nó
         * */
        $categoryId = $product->category->id;
        $productsRecommend = $product->where('category_id', $categoryId)->whereNotIn('id',[$product->id])->take(6)->get();
        $categoryMenuParents = Category::where('parent_id', 0)->take(3)->get();
        $categoryParents = Category::where('parent_id', 0)->get();
        return view('pages.product.show_detail',
            compact('product','categoryMenuParents', 'categoryParents', 'productsRecommend'));
    }


    public function index()
    {
        $products = $this->product->latest()->paginate(5);
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $brands = $this->brand->all();
        $htmlOption = $this->getCategory($parent_id = '');
        return view('admin.product.create', compact('htmlOption', 'brands'));
    }

    public function getCategory($parent_id)
    {
        $categories = $this->category->all();
        $recursive = new recursive($categories);
        return $recursive->CategoryRecursive($parent_id);
    }

    public function store(AddProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $dataProduct = [
                'name' => $request->name,
                'price'=>$request->price,
                'content'=>$request->contents,
                'category_id'=>$request->category_id,
                // 'brand_id'=>$request->brand_id,
                'status'=>$request->status,
                'quantity'=>$request->quantity,
                'views_count'=>0,
                'user_id'=>Auth::id()
            ];
            $dataFeatureImage = $this->storageTraitUpload($request,'feature_image_path','product');
            if (!empty($dataFeatureImage))
            {
                $dataProduct['feature_image_name'] = $dataFeatureImage['file_name'];
                $dataProduct['feature_image_path'] = $dataFeatureImage['file_path'];
            }
            $product = $this->product->create($dataProduct);

            //Add data to ProductImage
            if ($request->hasFile('image_path'))
            {
                foreach ($request->image_path as $file)
                {
                    $dataImage = $this->storageTraitUploadMultiple($file,'product');
                    $product->images()->create([
                        'image_path'=>$dataImage['file_path'],
                        'image_name'=>$dataImage['file_name']
                    ]);
                }
            }

            //Insert tags for product
            $tagIds = [];
            if(!empty($request->tags))
            {
                foreach ($request->tags as $tag)
                {
                    $tagInstance = $this->tag->firstOrCreate([
                        'name'=>$tag
                    ]);
                    $tagIds[] = $tagInstance->id;
                }
            }
            $product->tags()->attach($tagIds);
            DB::commit();
            return redirect()->route('products.index');
        }catch (\Exception $exception)
        {
            DB::rollBack();
            Log::debug('Message: '.$exception->getMessage().'---Line '.$exception->getLine());
        }

    }

    public function edit(Product $product, Request $request)
    {
        $brands = $this->brand->all();
        $htmlOption = $this->getCategory($product->category_id);
        return view('admin.product.edit', compact('product', 'htmlOption', 'brands'));
    }

    /**
     * doi voi anh quang cao thi tim product-id trong product_image roi xoa no di, thay vi check roi chen cai hinh nao moi
     * doi voi tag thi
     */
    public function update(Product $product, Request $request)
    {
        try {
            DB::beginTransaction();
            $dataProduct = [
                'name' => $request->name,
                'price'=>$request->price,
                'content'=>$request->contents,
                'brand_id'=>$request->brand_id,
                'status'=>$request->status,
                'quantity'=>$request->quantity,
                'category_id'=>$request->category_id,
                'user_id'=>Auth::id()
            ];
            $dataFeatureImage = $this->storageTraitUpload($request,'feature_image_path','product');
            if (!empty($dataFeatureImage))
            {
                $dataProduct['feature_image_name'] = $dataFeatureImage['file_name'];
                $dataProduct['feature_image_path'] = $dataFeatureImage['file_path'];
            }
            $product->update($dataProduct);
            //Add data to ProductImage
            if ($request->hasFile('image_path'))
            {
                $product->images()->delete();
                foreach ($request->image_path as $file)
                {
                    $dataImage = $this->storageTraitUploadMultiple($file,'product');
                    $product->images()->create([
                        'image_path'=>$dataImage['file_path'],
                        'image_name'=>$dataImage['file_name']
                    ]);
                }
            }
            //Insert tags for product
            $tagIds = [];
            if(!empty($request->tags))
            {
                foreach ($request->tags as $tag)
                {
                    $tagInstance = $this->tag->firstOrCreate([
                        'name'=>$tag
                    ]);
                    $tagIds[] = $tagInstance->id;
                }
            }
            $product->tags()->sync($tagIds);
            DB::commit();
            return redirect()->route('products.index');
        }catch (\Exception $exception)
        {
            DB::rollBack();
            Log::debug('Message: '.$exception->getMessage().'---Line '.$exception->getLine());
        }

    }

    public function delete(Product $product)
    {

        return $this->deleteModelTrait($product);

    }

    public function inactive_product(Product $product)
    {
        $product->update([
            'status'=>1
        ]);
        session()->flash('success', 'Hủy kích hoạt sản phẩm thành công');
        return redirect()->back();
    }
    public function active_product(Product $product)
    {
        $product->update([
            'status'=>0
        ]);
        session()->flash('success', 'Kích hoạt sản phẩm thành công');
        return redirect()->back();
    }
}
