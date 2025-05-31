<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = [
            [
                'name' => 'Caffee Latte',
                'description' => 'A creamy blend of espresso and steamed milk.',
                'category' => 'Coffee',
                'price' => 22000,
                'most_ordered' => true,
                'image' => 'img/coffee_placeholder.png'
            ],
            [
                'name' => 'Espresso',
                'description' => 'Strong and bold single shot of coffee.',
                'category' => 'Coffee',
                'price' => 18000,
                'most_ordered' => false,
                'image' => 'img/coffee_placeholder.png'
            ],
            [
                'name' => 'Friench Fries',
                'description' => 'Crispy golden fries served with sauce.',
                'category' => 'Snack',
                'price' => 22000,
                'most_ordered' => true,
                'image' => 'img/coffee_placeholder.png'
            ],
        ];

        // Group by category manually
        $grouped = collect($menuItems)->groupBy('category');

        return view('welcome', ['menuItems' => $grouped]);
        $menuItems = MenuItem::all()->groupBy('category');
        return view('menu.index', compact('menuItems'));
    }

    public function orderPage()
    {
        $menuItems = [
            [
                'id' => 1,
                'name' => 'Caffee Latte',
                'category' => 'Coffee',
                'price' => 22000,
                'image' => 'img/item_placeholder.png'
            ],
            [
                'id' => 2,
                'name' => 'Espresso',
                'category' => 'Coffee',
                'price' => 22000,
                'image' => 'img/item_placeholder.png'
            ],
            [
                'id' => 3,
                'name' => 'Moccachino',
                'category' => 'Coffee',
                'price' => 22000,
                'image' => 'img/item_placeholder.png'
            ],
            [
                'id' => 4,
                'name' => 'Caffee Latte',
                'category' => 'Coffee',
                'price' => 22000,
                'image' => 'img/item_placeholder.png'
            ],
            [
                'id' => 5,
                'name' => 'Caffee Latte',
                'category' => 'Drinks',
                'price' => 22000,
                'image' => 'img/item_placeholder.png'
            ],
            [
                'id' => 6,
                'name' => 'Caffee Latte',
                'category' => 'Coffee',
                'price' => 22000,
                'image' => 'img/item_placeholder.png'
            ],
            [
                'id' => 11,
                'name' => 'Friench Fries',
                'category' => 'Snack',
                'price' => 22000,
                'image' => 'img/item_placeholder.png'
            ]
        ];

        // Duplicate for layout preview
        // $menuItems = array_merge($menuItems);

        $groupedItems = collect($menuItems)->groupBy('category');

        return view('order.index', compact('groupedItems'));
    }
}
