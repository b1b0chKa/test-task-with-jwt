<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoodsResource;
use App\Models\Goods;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodsController extends Controller
{
    public function getAll()
	{
		$goods = Goods::where('user_id', Auth::id())->get();

		if (empty($goods["data"]))
		{
			return response()->json([
				'message' => "You don't have any goods"
			],404);
		}

		return GoodsResource::collection($goods);
	}
}
