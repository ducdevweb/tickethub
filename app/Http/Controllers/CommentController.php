<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  protected $AuthService;
  public function __construct(AuthService $AuthService)
  {
    $this->AuthService = $AuthService;
  }
 
  public function addComment(Request $request){
    $this->AuthService->storeComment($request);
    return redirect()->back() ;
  }
}
