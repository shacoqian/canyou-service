<?php
/**
 * Created by PhpStorm.
 * User: qianfeng
 * Date: 17-5-5
 * Time: 上午10:10
 */

namespace App\Http\Requests;


Class TestFormRequest extends FormRequest {
    public function rules() {
        return [
            ['id', 'required', 'message' => 'id不能为空', 'on' => 'index'],
            ['id', 'max:5', 'message' => 'id长度不能大于5', 'on' => ['index']],
            ['id', 'min:2', 'message' => 'id长度不能小于2', 'on' => ['index']],
        ];
    }
}