<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\cartItems;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = DB::table('menus')
            ->select('name', 'description', 'category', 'price', 'most_ordered', 'img_url')
            ->get();
            
        
        // $menuItems = [
        //     [
        //         'name' => 'Friench Fries',
        //         'description' => 'Crispy golden fries served with sauce.',
        //         'category' => 'Snack',
        //         'price' => 22000,
        //         'most_ordered' => true,
        //         'image' => 'img/coffee_placeholder.png'
        //     ],
        // ];

        // Group by category manually
        $grouped = collect($menuItems)->groupBy('category');

        return view('welcome', ['menuItems' => $grouped]);
        // $menuItems = MenuItem::all()->groupBy('category');
        // return view('menu.index', compact('menuItems'));
    }

    public function orderPage()
    {
        // $menuItems = [
        //     [
        //         'id' => 1,
        //         'name' => 'Caffee Latte',
        //         'category' => 'Coffee',
        //         'price' => 22000,
        //         'image' => 'img/item_placeholder.png'
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'Espresso',
        //         'category' => 'Coffee',
        //         'price' => 22000,
        //         'image' => 'img/item_placeholder.png'
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'Moccachino',
        //         'category' => 'Coffee',
        //         'price' => 22000,
        //         'image' => 'img/item_placeholder.png'
        //     ],
        //     [
        //         'id' => 4,
        //         'name' => 'Caffee Latte',
        //         'category' => 'Coffee',
        //         'price' => 22000,
        //         'image' => 'img/item_placeholder.png'
        //     ],
        //     [
        //         'id' => 5,
        //         'name' => 'Caffee Latte',
        //         'category' => 'Drinks',
        //         'price' => 22000,
        //         'image' => 'img/item_placeholder.png'
        //     ],
        //     [
        //         'id' => 6,
        //         'name' => 'Caffee Latte',
        //         'category' => 'Coffee',
        //         'price' => 22000,
        //         'image' => 'img/item_placeholder.png'
        //     ],
        //     [
        //         'id' => 11,
        //         'name' => 'Friench Fries',
        //         'category' => 'Snack',
        //         'price' => 22000,
        //         'image' => 'img/item_placeholder.png'
        //     ]
        // ];

        // Duplicate for layout preview
        // $menuItems = array_merge($menuItems);
        $menuItems = DB::table('menus')
            ->select('id', 'name', 'description', 'category', 'price', 'most_ordered', 'img_url')
            ->get();

        $groupedItems = collect($menuItems)->groupBy('category');

        $basketOwner = DB::table('carts')
            ->where('user_id', Auth::id())
            ->latest() // ambil yang paling baru
            ->first();

        if ($basketOwner == null) {
            DB::table('carts')->insert(
            array(
                'user_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            )
        );
        }
            
        // $pass = collect($basketOwner);s

        $baskets = DB::table('cart_items')
            ->where('cart_id', $basketOwner->id)
            ->join('menus', 'menu_id', '=', 'menus.id')
            ->select('cart_items.id', 'cart_id', 'menu_id', 'menus.name', 'menus.description', 'menus.price', 'quantity', 'variant', 'size', 'ice', 'sugar', 'subtotal')
            ->get();

        // $state = 'hello world';

        // return view('home', ['baskets' => $baskets], compact('groupedItems'));

        return dd($basketOwner, $baskets);;
    }

    public function destroy(Request $request)
    {
        // dd(cartItems::find($request->input("delete-target")));
        cartItems::destroy($request->input("delete-target"));
        return redirect()->back();
    }

    public function store(Request $request)
    {
        // dd(cartItems::find($request->input("delete-target")));
        DB::table('cart_items')
            ->sum()
            ->firstOrCreate(
                [ 
                    //field => req->value
                    // TODO $ANCHOR BASED ON DATA SENT, NEED TO FIGURE
                    // THE $REQUEST WAS FROM WHAT FORM BASED ON FOREACH.
                    'menu_id' => $request->input("update_",$anchor), 
                    'variant' => $request->input("name_"), 
                    'size' => $request->input("name_"), 
                    'ice' => $request->input("name_"), 
                    'sugar' => $request->input("name_")
                ]
            )->increment('quantity');
    }
    
}

// cartItems
// itemable_type, quantity, price, subtotal, variant, size, ice, sugar, options, created_at, updated_at

// menus
// id, name, description, category, price, most_ordered, img_url