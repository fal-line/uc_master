<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function indexMenu()
    {
        $menuItems = DB::table('menus')
            ->select('id', 'name', 'description', 'category', 'price', 'most_ordered', 'img_url')
            ->get();
            
        return view('management/menu', ['menuItems' => $menuItems]);
    }

    public function detailMenu(Request $request)
    {
        $menuItems = DB::table('menus')
            ->where('id', $request->route('id'))
            ->select('id', 'name', 'description', 'category', 'price', 'most_ordered', 'img_url')
            ->get();
            
        return view('management/menuDetail', ['menuItems' => $menuItems]);

        
    }


    // name="name"
    // name="description"
    // name="price"
    // name="category"
    // name="most_ordered"
    // nama="gambar"
    public function updateMenu(Request $request, Menu $Menu){
            // Validasi
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // maksimal 2MB
        ]);

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            
            $file = $request->file('gambar');
            $path = 'img/menuImg/'. $file->getClientOriginalName();
                    // return dd($request, $path);
		    $file->move('img/menuImg',$file->getClientOriginalName());
            
            
        Menu::where('id', $request->route('id'))
                        ->update([
                            'name' => $request->name,
                            'description' => $request->description,
                            'category' => str_replace([" / Don't change"], '', $request->category),
                            'price' => str_replace(['+', '-'], '', filter_var($request->price, FILTER_SANITIZE_NUMBER_INT)),
                            'most_ordered' => $request->has('most_ordered'),
                            'img_url' => $path
                        ]);
                    return redirect()->route('menuData');
                    // return dd($request, $path);
        }else{

        Menu::where('id', $request->route('id'))
                        ->update([
                            'name' => $request->name,
                            'description' => $request->description,
                            'category' => str_replace([" / Don't change"], '', $request->category),
                            'price' => str_replace(['+', '-'], '', filter_var($request->price, FILTER_SANITIZE_NUMBER_INT)),
                            'most_ordered' => $request->has('most_ordered')
                        ]);
                        return redirect()->route('menuData');
                    // return dd($request);

        }

    }

    public function deleteMenu(Request $request)
    {
        Menu::destroy($request->route('id'));
        return redirect()->route('menuData');
    }

    public function createMenu(Request $request)
    {
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // maksimal 2MB
        ]);

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            
            $file = $request->file('gambar');
            $path = 'img/menuImg/'. $file->getClientOriginalName();
                    // return dd($request, $path);
		    $file->move('img/menuImg',$file->getClientOriginalName());
            
            
        Menu::create([
                        'name' => $request->name,
                        'description' => $request->description,
                        'category' => $request->category,
                        'price' => str_replace(['+', '-'], '', filter_var($request->price, FILTER_SANITIZE_NUMBER_INT)),
                        'most_ordered' => $request->has('most_ordered'),
                        'img_url' => $path
                    ]);
                    return redirect()->route('menuData');
                    // return dd($request, $path);
        }else{

        Menu::create([
                        'name' => $request->name,
                        'description' => $request->description,
                        'category' => $request->category,
                        'price' => str_replace(['+', '-'], '', filter_var($request->price, FILTER_SANITIZE_NUMBER_INT)),
                        'most_ordered' => $request->has('most_ordered'),
                        'img_url' => 'img/item_placeholder.png'
                    ]);
                    return redirect()->route('menuData');
                    // return dd($request);

        }

        
    }
    
}

// str_replace(['+', '-'], '', filter_var($request->input("price_".$p), FILTER_SANITIZE_NUMBER_INT)
