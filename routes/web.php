<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCreate;
use App\Http\Controllers\AdminDelete;
use App\Http\Controllers\AdminEdit;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TicketController;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;
//Ticket
Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/ticket/{type}', [TicketController::class, 'showTickets'])->where('type', 'music|tour|workshop')->name('ticket.show');;
Route::get('/ticket/{id_ticket}', [TicketController::class, 'showDetail'])->name('ticket.detail');
Route::get('/favourite/{id_ticket}', [TicketController::class, 'favourite']);
Route::get('/search', [TicketController::class, 'search'])->name('search');
Route::get('/qr/{id}', [AuthController::class, 'viewQr'])->name('viewQr');
Route::get('/event_detail/{id_event}', [TicketController::class, 'detail_event']);

//Auth
Route::get('/pageLogin', [AuthController::class, 'pageLogin'])->name('pageLogin');
Route::post('/check_login', [AuthController::class, 'checkLogin'])->name('checkLogin');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/checkRegister', [AuthController::class, 'checkRegister'])->name('checkRegister');

Route::group(['middleware' => [CheckLogin::class]], function () {
     //Cart
     Route::post('/addCart/{id_ticket}', [CartController::class, 'addCart'])->name('addCart');
     Route::get('/addCart/{id_ticket}', [CartController::class, 'addCart'])->name('getAddCarts');
     Route::get('/cart', [CartController::class, 'ShowCart'])->name('cart');
     Route::post('/cart/update/{id_cart}', [CartController::class, 'updateQuantity'])->name('cartUpdate');
     Route::get('/cart/del-cart/{id_cart}', [CartController::class, 'delCart'])->name('cart.del');

     Route::post('/comments/{id_ticket}', action: [CommentController::class, 'addComment'])->name('addComment');

     //Checkout
     Route::get('/checkout', [CheckOutController::class, 'ShowCheckOut'])->name('checkout');

     Route::post('/checkout/process', [CheckOutController::class, 'process'])->name('checkout.process');
     Route::get('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');
     Route::get('/thank-you', [CheckoutController::class, 'thankYou'])->name('thank-you');
     Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

     // Account
     Route::get('/chat', [AccountController::class, 'chat']);
     Route::get('/booking', [AccountController::class, 'booking']);
     Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
     Route::get('/messages/{userId}', [MessageController::class, 'show'])->name('messages.show');
     Route::post('/messages/send', [MessageController::class, 'store'])->name('messages.store');
     Route::get('/account', [AccountController::class, 'account']);
     Route::put('/update_user', [AccountController::class, 'update_user'])->name('updateUser');
     Route::get('/order', [AccountController::class, 'order']);
     Route::get('/order/{id_order}', [AccountController::class, 'detail_order']);
     Route::get('/comment', [AccountController::class, 'comment']);
     Route::get('/favourite', [AccountController::class, 'favourite']);

     // Admin
     Route::prefix('admin')->group(function () {

          // index
          Route::get('/home', [AdminController::class, 'index'])->name('home_admin');
          Route::get('/user', [AdminController::class, 'user'])->name('admin.index.user');
          Route::get('/ticket', [AdminController::class, 'ticket'])->name('admin.index.ticket');
          Route::get('/revenue', [AdminController::class, 'revenue']);
          Route::get('/report', [AdminController::class, 'report']);
          Route::get('/event', [AdminController::class, 'event'])->name('admin.index.event');
          Route::get('/setting', [AdminController::class, 'setting']);
          Route::get('/chat', [AdminChatController::class, 'index'])->name('admin.chat.index');
          Route::post('/chat/send', [AdminChatController::class, 'sendMessage'])->name('admin.chat.send');
          Route::get('/booking_manager', [AdminController::class, 'booking']);
          Route::get('/recycle_bin', [AdminController::class, 'recycle_bin'])->name('admin.recycle-bin');
          Route::get('/export/{type}/{id}/{fileType}', [AdminController::class, 'exportFile'])->name('export.file');

          // detail
          Route::get('/event_detail/{id_event}', [AdminController::class, 'event_detail'])->name('admin.detail.event');
          Route::get('/ticket_detail/{id_ticket}', [AdminController::class, 'ticket_detail'])->name('admin.detail.ticket');
          Route::get('/user_detail/{id_user}', [AdminController::class, 'user_detail'])->name('admin.detail.user');
          Route::get('/revenue_detail/{id_event}', [AdminController::class, 'detail_revenue'])->name('admin.detail.revenue');
          Route::get('/report_detail/{id_detail}', [AdminController::class, 'detail_report'])->name('admin.detail.report');

          // create
          Route::get('/create_ticket', [AdminCreate::class, 'create_ticket']);
          Route::post('/add_ticket', [AdminCreate::class, 'add_ticket'])->name('admin.create.ticket');
          Route::post('/add_event', [AdminCreate::class, 'add_event'])->name('admin.create.event');
          Route::get('/create_user', [AdminCreate::class, 'create_user']);
          Route::get('/admin/events/{id}/map', [AdminController::class, 'showMap'])->name('admin.events.map');

          // edit
          Route::get('/edit_ticket/{id_ticket}', [AdminEdit::class, 'edit_ticket']);
          Route::put('/update_ticket/{id_ticket}', [AdminEdit::class, 'update_ticket'])->name('admin.update.ticket');
          Route::get('/edit_event/{id_event}', [AdminEdit::class, 'edit_event']);
          Route::put('/update_event/{id_event}', [AdminEdit::class, 'update_event'])->name('admin.update.event');
          Route::get('/edit_user', [AdminEdit::class, 'edit_user']);
          Route::get('/update_user/{id}', [AdminEdit::class, 'update_user']);

          // delete
          Route::get('/recycle_bin', [AdminDelete::class, 'recycle_bin'])->name('admin.recycle-bin');
          Route::delete('/admin/event/{id_event}', [AdminDelete::class, 'del_event'])->name('admin.delete.event');
          Route::delete('/admin/ticket/{id_ticket}', [AdminDelete::class, 'del_ticket'])->name('admin.delete.ticket');
          Route::delete('/admin/user/{id}', [AdminDelete::class, 'del_user'])->name('admin.delete.user');
          //trash
          Route::put('/event/restore/{id_event}', [AdminDelete::class, 'restoreEvent'])->name('admin.restore.event');
          Route::delete('/event/force-delete/{id_event}', [AdminDelete::class, 'forceDeleteEvent'])->name('admin.force-delete.event');
          Route::put('/ticket/restore/{id_ticket}', [AdminDelete::class, 'restoreTicket'])->name('admin.restore.ticket');
          Route::delete('/ticket/force-delete/{id_ticket}', [AdminDelete::class, 'forceDeleteTicket'])->name('admin.force-delete.ticket');
          Route::put('/user/restore/{id}', [AdminDelete::class, 'restoreUser'])->name('admin.restore.user');
          Route::delete('/user/force-delete/{id}', [AdminDelete::class, 'forceDeleteUser'])->name('admin.force-delete.user');
     });
});
