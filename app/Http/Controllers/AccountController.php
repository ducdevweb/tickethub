<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    protected $AccountService;
    public function __construct(AccountService $AccountService){
        $this->AccountService = $AccountService;
    }

    public function booking(){
        return view("user.account.booking");
    }
    public function account(){
        return view("user.account.account");
    }
    public function update_user(Request $request){
        $this->AccountService->updateUser( $request);
        return redirect()->back();
    }

    public function chat(){
        return view("user.account.chat");
    }
    public function message(){
        return view("user.account.message");
    }
    public function favourite(){
        $favourites=$this->AccountService->getFavourite();
        return view("user.account.favourite",compact('favourites'));
    }
    public function order(){
        $orders=$this->AccountService->getOrder();
        return view("user.account.order",compact('orders'));
    }
   
    public function detail_order($id_order){
        $detailOrders= $this->AccountService->listDetailOrder($id_order);
        
        return view("user.account.detail_order",compact("detailOrders"));
    }
    public function comment(){
        $comments= $this->AccountService->getCommentUser();
        return view("user.account.comment",compact("comments"));
    }
}
