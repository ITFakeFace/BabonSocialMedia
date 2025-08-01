<?php

use App\Events\TypingEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\EmoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FriendController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChatController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');


    });

    Route::group(['middleware' => ['auth']], function() {

        Route::group(['prefix' => 'chat', 'as' => 'chat.'], function () {
            Route::get('/{receiverId?}', [ChatController::class, 'index'])->name('index');
            Route::post('/{receiverId?}', [ChatController::class, 'store'])->name('store');
          });

        // Trigger typing event when a user starts typing
        Route::post('/start-typing', function (Illuminate\Http\Request $request) {
            $senderId = auth()->id();
            $receiverId = $request->receiverId;
            event(new TypingEvent($senderId, $receiverId, true));
        });

// Trigger typing event when a user stops typing
        Route::post('/stop-typing', function (Illuminate\Http\Request $request) {
            $senderId = auth()->id();
            $receiverId = $request->receiverId;

            event(new TypingEvent($senderId, $receiverId, false));
        });

        Route::prefix('newsfeed')->group(function () {
            Route::get('/home', [PostController::class, 'index1'])->name('newsfeed.home');
            Route::post('/create', [PostController::class, 'create']);
            Route::post('/postCreate', [PostController::class, 'postCreate']);
            Route::get('/delete/{id}', [PostController::class, 'delete']);
            Route::post('/edit', [PostController::class, 'edit']);
            Route::post('/report', [ReportController::class, 'createReport']);
        });

        Route::prefix('admin/dashboard')->group(function () {
            Route::get('/index',[UserController::class, 'index'])->name('admin.dashboard.index');
            Route::get('/user/listuser',[UserController::class, 'listUser'])->name('admin.dashboard.listuser');
            Route::get('/user/listuserban',[UserController::class, 'listUserBan'])->name('admin.dashboard.listuserban');
            Route::get('/admin/listadmin',[UserController::class, 'listAdmin'])->name('admin.dashboard.listadmin');
            Route::get('/admin/listticket',[UserController::class, 'listTicket'])->name('admin.dashboard.listticket');
            Route::get('/user/listuser/{id}',[UserController::class, 'isBan']);
            Route::get('/user/viewuserprofile/{id}',[UserController::class,'viewUserProfile']);
            Route::get('/admin/listticket/{id}',[UserController::class, 'isDone']);
            Route::get('/admin/ticketdetail/{id}',[TicketController::class, 'ticketDetail']);
            Route::post('/answerTicket',[TicketController::class, 'answerTicket'])->name('admin.answerTicket');
            Route::get('/admin/listreport',[UserController::class, 'listReport'])->name('admin.dashboard.listreport');
            Route::get('/admin/reportdetail/{id}',[ReportController::class, 'reportDetail']);
            Route::get('/admin/reportdetail/delete/{id}', [ReportController::class, 'deletePost']);
            Route::get('/admin/reportdetail/ban/{id}', [ReportController::class, 'isBan2']);
            Route::get('/admin/listreport/{id}',[ReportController::class, 'isDone']);
            Route::post('/admin/adminprofile/createPost',[PostController::class, 'createPostAdmin'])->name('admin.post');
        });

        Route::prefix('user')->group(function () {
            Route::get('/userprofile', [UserController::class,'viewInfo2'])->name('view.profile.userprofile');
            Route::get('/userprofile/{id}', [UserController::class,'viewInfo']);
            Route::get('/editprofile/{id}',[UserController::class, 'editProfile']);
            Route::post('/postEdit',[UserController::class, 'updateProfile'])->name('user.updateProfile');
            Route::post('/updatePassword',[UserController::class, 'updatePassword'])->name('user.updatePassword');
            Route::post('/updateDescription',[UserController::class, 'updateDescription'])->name('user.updateDescription');
            Route::post('/updateAvatar',[UserController::class, 'updateAvatar'])->name('user.updateAvatar');
            Route::post('/updateCover',[UserController::class, 'updateCover'])->name('user.updateCover');
            Route::get('/ticketsupport/{id}',[UserController::class, 'ticketSupport']);
            Route::post('/sendTicket',[TicketController::class, 'sendTicket'])->name('user.sendTicket');
        });

        Route::prefix('admin/')->group(function () {
            Route::get('/adminprofile',[UserController::class, 'viewProfileAdmin'])->name('view.profile.adminprofile');
            Route::get('/editprofile/{id}',[UserController::class, 'editProfile']);
            Route::post('/postEdit',[UserController::class, 'updateProfile'])->name('user.updateProfile');
            Route::post('/updatePassword',[UserController::class, 'updatePassword'])->name('user.updatePassword');
            Route::post('/updateDescription',[UserController::class, 'updateDescription'])->name('user.updateDescription');
            Route::post('/updateAvatar',[UserController::class, 'updateAvatar'])->name('user.updateAvatar');
            Route::post('/updateCover',[UserController::class, 'updateCover'])->name('user.updateCover');
            Route::get('/adminprofile/delete/{id}',[PostController::class, 'deletePostAdmin']);
        });

        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });

    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
    
Route::prefix('post')->group(function () {
    Route::post('/getPost', [PostController::class, 'getPost']);
    Route::post('/postCreate', [PostController::class, 'postCreate']);
});

Route::prefix('emote')->group(function(){
    Route::post('/emoteCreate',[EmoteController::class, 'createEmote']);
});

Route::prefix('comment')->group(function(){
    Route::post('/commentCreate',[CommentController::class, 'createComment']);
    Route::post('/editCmt',[CommentController::class, 'editCmt']);
    Route::get('/get/{id}',[CommentController::class, 'getCmt']);
    Route::get('/delete/{id}', [CommentController::class, 'delete']);
});

Route::post('/add-friend', [FriendController::class, 'makeFriend']);
Route::post('/remove-friend', [FriendController::class, 'removeFriend']);
Route::get('/markasread/{id}', [FriendController::class, 'markAsRead']);
Route::post('/reject-friend-request', [FriendController::class, 'sendFriendRequest']);
Route::post('/accept-friend-request', [FriendController::class, 'acceptFriendRequest']);
Route::post('/cancel-friend-request', [FriendController::class, 'cancelFriendRequest']);
Route::post('/reject-friend-request', [FriendController::class, 'rejectFriendRequest']);

Route::get('/user', function () {
    $user = Auth::user();
    return response()->json(['user' => $user]);
});
});
