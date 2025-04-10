<?php

namespace App\Http\Resources;

use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'goods' => GoodsResource::collection(Goods::where('user_id', Auth::id())->get()),
			'created_at' => $this->created_at,
			'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ],
		];
    }
}
