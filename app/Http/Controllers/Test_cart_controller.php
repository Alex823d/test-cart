<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\User_product_group;
use App\Models\Cart;
use App\Models\Product_group_item;

class Test_cart_controller extends Controller
{
    //

    public function addProductInCart(Request $request){

        $cart = new Cart;

        $cart->user_id = 15;

        $cart->product_id = $request->product_id;

        $cart->quantity = $request->quantity;

        $cart->save();
    }

    public function removeProductFromCart(Request $request){

        return Cart::where('product_id','=',$request->product_id)->delete();

    }

    public function setCartProductQuantity(Request $request){

        return Cart::where('product_id','=',$request->product_id)->update(['quantity' => $request->quantity]);

    }

    public function getUserCart(Request $request){

        $result = [];

        //getting cart
        $cart = Cart::leftJoin('products','products.product_id', '=', 'cart.product_id')->leftJoin('product_group_items','product_group_items.product_id', '=', 'cart.product_id')->select('cart.*','products.*','product_group_items.group_id')->get();


        $user_id = [];
        foreach ($cart as $item){
            $user_id[] = $item->user_id;
            $result['products'][] =  ['product_id' => $item->product_id,'quantity' => $item->quantity,'price' => $item->price];
        }

        //getting all discount grooups with items in this group by product owners in the cart
        $groups = User_product_group::whereIn('user_id',$user_id)->with('items')->get();

        $_discount = [];
        $count_in_cart = [];
        $discount_in_group = [];
        //grouping discount groups by owner and group id
        foreach ($groups as $group){
            $_discount[$group->user_id][$group->group_id] = $group;
            $count_in_cart[$group->group_id] = 0;
            $discount_in_group[$group->group_id] = 0;
        }


        //discount counting
        $total_discount = 0;

        foreach ($cart as $c_item){

            //determining that a discount group exists for the product in the cart
            if(isset($_discount[$c_item->user_id][$c_item->group_id])){
                
                $count_in_group = count($_discount[$c_item->user_id][$c_item->group_id]->items);//count items in this group

                foreach ($_discount[$c_item->user_id][$c_item->group_id]->items as $item){

                    //if product in cart exists in this group and quantity of this product > 1, increment product count in the cart of this group and counting discount for this product 
                    if(($c_item->quantity > 1) && $c_item->product_id == $item->product_id){

                        $count_in_cart[$c_item->group_id]++;
                        //because discount is available only if this product quantity: 2 in the cart
                        $discount_in_group[$c_item->group_id] += $_discount[$c_item->user_id][$c_item->group_id]->discount * $c_item->price / 100 * 2;

                    }
                }
                //checking if all cart products are in discount group, then add to total discount
                if($count_in_cart[$c_item->group_id] == $count_in_group){
                    $total_discount += $discount_in_group[$c_item->group_id];

                }
            }
        }

        //dd($cart,$_discount,$discount);

        
        $result['discount'] = $total_discount;
        return $result;
    }
}
