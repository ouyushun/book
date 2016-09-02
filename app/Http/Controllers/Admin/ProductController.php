<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Books;
use App\Entity\PdtImage;
use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\Product;
use Illuminate\Http\Request;
use App\Models\M3Result;

class ProductController extends Controller
{

  public function toProduct()
  {
    $products = Books::all();
    foreach ($products as $product) {
      $product->category = Category::find($product->category_id);
    }

    return view('admin.product')->with('products', $products);
  }

  public function toProductInfo(Request $request) {
    $id = $request->input('id', '');

    $product = Books::find($id);
    $product->category = Category::find($product->category_id);

    $pdt_content = Product::where('book_id', $id)->first();
    $pdt_images = PdtImage::where('book_id', $id)->get();
      
    return view('admin.product_info')->with('product', $product)
                                     ->with('pdt_content', $pdt_content)
                                     ->with('pdt_images', $pdt_images);
  }

  public function toProductAdd() {
    $categories = Category::whereNotNull('parent_id')->get();

    return view('admin.product_add')->with('categories', $categories);
  }

    public function toProductEdit(Request $request) {
        
        $id = $request->input('id', '');

        $product = Books::find($id);
        $categories = Category::whereNotNull('parent_id')->get();
        $pdt_content = Product::where('book_id', $id)->first();
        $pdt_images = PdtImage::where('book_id', $id)->get();
        
        return view('admin.product_edit')->with('product', $product)
            ->with('pdt_content', $pdt_content)
            ->with('pdt_images', $pdt_images)
            ->with('categories', $categories);
    }
  

  /********************Service*********************/
  public function productEdit(Request $request)
  {
    $product_id = $request->input('product_id',''); 
    $name = $request->input('name', '');
    $summary = $request->input('summary', '');
    $price = $request->input('price', '');
    $category_id = $request->input('category_id', '');
    $preview = $request->input('preview', '');
    $content = $request->input('content', '');

    $preview1 = $request->input('preview1', '');
    $preview2 = $request->input('preview2', '');
    $preview3 = $request->input('preview3', '');
    $preview4 = $request->input('preview4', '');
    $preview5 = $request->input('preview5', '');

    $product =  Books::find($product_id);
    $product->summary = $summary;
    $product->price = $price;
    $product->category_id = $category_id;
    $product->preview = $preview;
    $product->name = $name;
    $product->save();

    $pdt_content = Product::where('book_id',$product_id)->first();
    $pdt_content->book_id = $product->book_id;
    $pdt_content->pdt_content = $content;
    $pdt_content->save();

        //首先将所有的图片清空
      PdtImage::where('book_id',$product_id)->delete();
      
      if($preview1 != '') {
      $pdt_images = new PdtImage();
      $pdt_images->image_path = $preview1;
      $pdt_images->image_no = 1;
      $pdt_images->book_id = $product_id;
      $pdt_images->save();
    }
    if($preview2 != '') {
      $pdt_images = new PdtImage();
      $pdt_images->image_path = $preview2;
      $pdt_images->image_no = 2;
      $pdt_images->book_id = $product_id;
      $pdt_images->save();
    }
    if($preview3 != '') {
      $pdt_images = new PdtImage();
      $pdt_images->image_path = $preview3;
      $pdt_images->image_no = 3;
      $pdt_images->book_id = $product_id;
      $pdt_images->save();
    }
    if($preview4 != '') {
      $pdt_images = new PdtImage();
      $pdt_images->image_path = $preview4;
      $pdt_images->image_no = 4;
      $pdt_images->book_id = $product_id;
      $pdt_images->save();
    }
    if($preview5 != '') {
      $pdt_images = new PdtImage();
      $pdt_images->image_path = $preview5;
      $pdt_images->image_no = 5;
      $pdt_images->book_id = $product_id;
      $pdt_images->save();
    }

    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '添加成功';

    return $m3_result->toJson();
  }

    public function productAdd(Request $request)
    {
        $name = $request->input('name', '');
        $summary = $request->input('summary', '');
        $price = $request->input('price', '');
        $category_id = $request->input('category_id', '');
        $preview = $request->input('preview', '');
        $content = $request->input('content', '');

        $preview1 = $request->input('preview1', '');
        $preview2 = $request->input('preview2', '');
        $preview3 = $request->input('preview3', '');
        $preview4 = $request->input('preview4', '');
        $preview5 = $request->input('preview5', '');

        $product = new Books();
        $product->summary = $summary;
        $product->price = $price;
        $product->category_id = $category_id;
        $product->preview = $preview;
        $product->name = $name;
        $product->save();

        $pdt_content = new Product();
        $pdt_content->book_id = $product->book_id;
        $pdt_content->pdt_content = $content;
        $pdt_content->save();

        if($preview1 != '') {
            $pdt_images = new PdtImage();
            $pdt_images->image_path = $preview1;
            $pdt_images->image_no = 1;
            $pdt_images->book_id = $product->book_id;
            $pdt_images->save();
        }
        if($preview2 != '') {
            $pdt_images = new PdtImage();
            $pdt_images->image_path = $preview2;
            $pdt_images->image_no = 2;
            $pdt_images->book_id = $product->book_id;
            $pdt_images->save();
        }
        if($preview3 != '') {
            $pdt_images = new PdtImage();
            $pdt_images->image_path = $preview3;
            $pdt_images->image_no = 3;
            $pdt_images->book_id = $product->book_id;
            $pdt_images->save();
        }
        if($preview4 != '') {
            $pdt_images = new PdtImage();
            $pdt_images->image_path = $preview4;
            $pdt_images->image_no = 4;
            $pdt_images->book_id = $product->book_id;
            $pdt_images->save();
        }
        if($preview5 != '') {
            $pdt_images = new PdtImage();
            $pdt_images->image_path = $preview5;
            $pdt_images->image_no = 5;
            $pdt_images->book_id = $product->book_id;
            $pdt_images->save();
        }

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '添加成功';

        return $m3_result->toJson();
    }

    public function productDelete(Request $request)
    {
        $book_id = $request->input('id', '');
        Books::find($book_id)->delete();
        PdtImage::where('book_id',$book_id)->delete();
        Product::where('book_id',$book_id)->delete();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '删除成功';

        return $m3_result->toJson();
    }

}
