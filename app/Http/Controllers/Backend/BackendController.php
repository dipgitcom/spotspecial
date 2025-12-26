<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItemDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\UserPost;
use App\Models\TruckManage;

class BackendController extends Controller
{
    // dashboard show
    public function index()
{
    // $userPosts = UserPost::all(); // Get all user posts
    $truckManages = TruckManage::all(); // Get all truck manages
    

    // You can add more data as needed, for example: counts, latest, etc.
    // $postCount = UserPost::count();
    $truckCount = TruckManage::count();

    return view('backend.layouts.dashboard', compact( 'truckManages',  'truckCount'));
}




}
