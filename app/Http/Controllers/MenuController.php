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
        
        return redirect('home');
        
        }
            
        // $pass = collect($basketOwner);s

        $baskets = DB::table('cart_items')
            ->where('cart_id', $basketOwner->id)
            ->join('menus', 'menu_id', '=', 'menus.id')
            ->select('cart_items.id', 'cart_id', 'menu_id', 'menus.name', 'menus.description', 'menus.price', 'quantity', 'variant', 'size', 'ice', 'sugar', 'subtotal')
            ->get();

        // $state = 'hello world';

        return view('home', ['baskets' => $baskets], compact('groupedItems'));

        // return dd($basketOwner, $baskets);;
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
        
        $anchor = array_values($request->all());
        $anchor = $anchor[1];

        // if ($request->input("ice_") . $anchor == null) {
            
        //     return dd($anchor, $request);
        // }


        
        // return dd($anchor, $request);
        
        // DB::insert('insert into cart_items (id, boardOwner, itemName, itemDesc, itemPrice, created_at, updated_at, status) values (?, ?, ?, ?, ?, ?, ?, ?)', [NULL, $request->route('id'), '', '', NULL, NULL, NULL, 'unchecked']);
        

        $basketOwner = DB::table('carts')
            ->where('user_id', Auth::id())
            ->latest() // ambil yang paling baru
            ->first();

        $cartItem = DB::table('cart_items')
            ->where('cart_id', $basketOwner->id)
            ->where('menu_id', $request->input("update_" . $anchor))
            ->where('variant', $request->input("variant-" . $anchor))
            ->where('size', $request->input("size-" . $anchor))
            ->where('ice', $request->input('ice-' . $anchor) === 'null' ? 'No Ice' : $request->input('ice-' . $anchor))
            ->where('sugar', $request->input("sugar-" . $anchor))
            ->first();
            
        // return dd($cartItem->id, $request);

        if ($cartItem) {
            DB::table('cart_items')
                ->where('id', $cartItem->id)
                ->increment('quantity');
        } else {
            DB::table('cart_items')->insert([
                'cart_id'  => $basketOwner->id,
                'menu_id'  => $request->input("update_" . $anchor),
                'variant'  => $request->input("variant-" . $anchor),
                'size'     => $request->input("size-" . $anchor),
                'ice'      => $request->input('ice-' . $anchor) === 'null' ? 'No Ice' : $request->input('ice-' . $anchor),
                'sugar'    => $request->input("sugar-" . $anchor),
                'quantity' => 1,
            ]);
        }

        $cartItem = DB::table('cart_items')
            ->where('cart_id', $basketOwner->id)
            ->where('menu_id', $request->input("update_" . $anchor))
            ->where('variant', $request->input("variant-" . $anchor))
            ->where('size', $request->input("size-" . $anchor))
            ->where('ice', $request->input("ice-" . $anchor))
            ->where('sugar', $request->input("sugar-" . $anchor))
            ->first();

        $iceOrNo = DB::table('cart_items')
            ->where('cart_id', $basketOwner->id)
            ->where('ice', $request->input("ice-" . $anchor))
            ->first();

        if ($iceOrNo === null) {    
            // DB::insert('insert into cart_items (ice) values (?)', ['No Ice']);
            DB::table('cart_items')
                ->where('id', $cartItem->id)
                ->insert([
                'ice'      => 'No Ice',
            ]);
        }
        
        // return dd($iceOrNo->ice, $cartItem->id, $request);
        // DB::table('cart_items')

        //     // ->sum()
        //     ->updateOrInsert(
        //         [ 
        //             //field => req->value
        //             // TODO $ANCHOR BASED ON DATA SENT, NEED TO FIGURE
        //             // THE $REQUEST WAS FROM WHAT FORM BASED ON FOREACH.
        //             'menu_id' => $request->input("update_".$anchor), 
        //             'variant' => $request->input("variant-".$anchor), 
        //             'size' => $request->input("size-".$anchor), 
        //             'ice' => $request->input("ice-options-".$anchor), 
        //             'sugar' => $request->input("sugar-".$anchor)
        //         ]
        //     )->increment('quantity');

        
        // return dd($cartItem, $request);
            
        return redirect('home');
    }
    
}

// cartItems
// itemable_type, quantity, price, subtotal, variant, size, ice, sugar, options, created_at, updated_at

// menus
// id, name, description, category, price, most_ordered, img_url