<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phim;
use App\Models\DanhGia;
use App\Models\BaiDang;
use App\Models\BinhLuan;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function loadDanhGia($phimId)
    {
        $phim = Phim::findOrFail($phimId);
        $danhGias = DanhGia::with('user')->where('phim_id', $phimId)->orderby('created_at', 'desc')->get();
        return view('subpages.danhgia', compact('phim', 'danhGias'));
    }

    public function loadBinhLuan($baiDangId)
    {
        $baiDang = BaiDang::findOrFail($baiDangId);
        $binhLuans = BinhLuan::with('user')->where('baidang_id', $baiDangId)->orderby('created_at', 'desc')->get();
        return view('subpages.binhluan', compact('baiDang', 'binhLuans'));
    }

    public function postBinhLuan(Request $request)
    {
        $user_id = Auth::user()->id;
        try {
            BinhLuan::create($request->only(['noi_dung','baidang_id'])+['user_id'=>$user_id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return response()->json([
            'error'=>false,
            'thongbao'=>'Đánh giá thành công',
        ],200);
    }

    public function getXoaBinhLuan($binhLuanId)
    {
        $binhLuan = BinhLuan::findOrFail($binhLuanId);
		try {
			$binhLuan->delete();
		} catch (Exception $e) {
			return response()->json([
				'error'=>true,
			],200);
		}
		return response()->json([
			'error'=>false,
		],200);
    }

    public function __invoke(Request $request)
    {
        //
    }
}