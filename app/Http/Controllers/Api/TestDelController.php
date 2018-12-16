<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestDelController extends Controller
{
    /**
     * 删除生词本
     *
     * @SWG\Delete(path="/api/v1/new/words/{$ids}",
     *   tags={"Students"},
     *   summary="删除生词本-可测试-qym",
     *   description="删除生词本",
     *   produces={"application/json"},
     * @SWG\Parameter(
     *     in="header",
     *     name="Authorization",
     *     type="string",
     *     description="用户旧的jwt-token, value以Bearer开头",
     *     required=true,
     *     default="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9saXZlcy5jb21cL2FwaVwvdjFcL3N0dWRlbnRcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNTI3NjUyNjQzLCJleHAiOjE1Mjk4MTI2NDMsIm5iZiI6MTUyNzY1MjY0MywianRpIjoiYnBMWDFKZWozODNZUFVLWCIsInN1YiI6IjYzNDYxMzUxNzAiLCJwcnYiOiJmYTdhZTZlNDcwNzZkYTJkNDY0ZDNiZjFhNGQyYzI2MTMxMzk1MzJkIn0.--KWf1geFDtAGHl0Hu0ZpjZEJqcf_y2ErujnlYN6VNQ"
     *   ),
     * @SWG\Response(response="default",     description="操作成功")
     * )
     */
    public function destroy($ids)
    {
        return $ids;
        try{
            $id = hashIdDecode($ids);
            $deleted = $this->repository->delete($id);
            if ($deleted) {
                return $this->response(2006, '生词本删除成功', [$deleted]);
            }
        }catch(\Exception $e){
            Log::error('生词本删除失败',[$e]);
            return $this->response(2007,'生词本删除失败');
        }
    }
}
