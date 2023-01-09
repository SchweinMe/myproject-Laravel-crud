<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Exception;


class ProductController extends Controller
{
    public function index() {               //return view => Server side
        $product_list = Product::get();
        return view('template/home', [
            'products' => $product_list
        ]);
    }

    public function getAllData() {
        $getAllData = Product::get();

        if($getAllData) {
            return response([
                'message' => 'ok',
                'description' => 'Get Data Success',
                'data' => $getAllData
            ], 200);
        } else {
            return response([
                'message' => 'error',
                'description' => 'Get Data Error'
            ], 401);
        }
    }

    public function onCreate(Request $req) {   // Create Product Function. (client side)
        //  dd($req);
        try {
            $createProduct = new Product();
            $createProduct->p_name = $req->name;
            $createProduct->p_description = $req->description;
            $createProduct->p_price = $req->price;
            $createProduct->p_category = $req->category;

            $result = $createProduct->save();
            if($result) {
                return response([          // return response เป็น array
                    'message' => 'ok',
                    'description' => 'Create Product Successfully.'
                ], 201);                    // status code
            } else {
                return response([
                    'message' => 'error',
                    'description' => 'Create Product Error.'
                ], 401);                     // status code
            }
        }catch (Exception $e) {
            return response([
                'message' => 'server error',
                'description' => $e
            ], 500);
        } 
    }
    public function onEdit($id) {
        $product = Product::where("id", $id)->first();

        if($product) {
            return response([
                'message' => 'ok',
                'description' => 'Get Product Successfully.',
                'product' => $product
            ], 200);
        } else {
            return response([
                'message' => 'error',
                'description' => 'Get Product Error'
            ], 404);
        }
    }

    public function onUpdate(Request $request) {
        // dd($request);
        $product = Product::where("id", $request->id)->first();
        if($product) {
            $product->p_name = $request->name;
            $product->p_description = $request->description;
            $product->p_price = $request->price;
            $product->p_category = $request->category;
            $product->save();

            return response([
                'message' => 'ok',
                'description' => 'Update Product Successfully.'
            ], 200);
        } else {
            return response([
                'message' => 'error',
                'description' => 'Update Product Error.'
            ], 401);
        }

    }

    public function onDelete($id) {
        // dd($id);
        $product = Product::where("id", $id)->delete();

        if($product) {
            return response([
                'message' => 'ok',
                'description' => 'Delete Product Sucessfully.'
            ], 200);
        } else {
            return response([
                'massage' => 'error',
                'description' => 'Delete Product Error'
            ], 400);
        }
    }
}
