<?php
namespace App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

class FormRequest{

    protected $errors;

    /**
     * 表单校验规则
     * @param $request
     * @return array
     */
    protected function rules(){
        return [];
    }

    /**
     * 表单校验失败报错信息
     * @return array
     */
//    protected function messages(){
//        return [];
//    }

    //获取场景
    protected function getSenario(Request $request) {
        return explode('@', $request->route()[1]['uses'])[1];
        //return explode('@', $request->route()[1]['uses'])[1] . '_' . $request->get('senario');
    }

     /**
      * 解析验证规则
      * @return [rules_array, message_array]
      */
    public function parseRules($senario = '') {
        if (empty($senario)) {
            return [[],[]];
        }
        $rules = [];
        $message = [];
        foreach($this->rules() as $rule) {
            if (is_array($rule['on'])) {
                if (in_array($senario, $rule['on'])) {
                    $rules[$rule[0]][] = $rule[1];
                    $message[$rule[0] . '.' . explode(':',$rule[1])[0]] = $rule['message'];
                }
            } else {
                if ($rule['on'] == $senario) {
                    $rules[$rule[0]][] = $rule[1];
                    // @example: 'payment_password.max' => '支付密码不能超过16位!',
                    $message[$rule[0] . '.' . explode(':',$rule[1])[0]] = $rule['message'];
                }
            }
        }

        array_map(function($v){ return implode('|', $v); }, $rules);

        return [$rules, $message];
    }


    /**
     * 处理方法
     * @param Request $request
     * @return bool
     */
    public function handle(Request $request){
        list($rules, $message) = $this->parseRules($this->getSenario($request));
        $validator = Validator::make($request->all(),
            $rules,
            $message
        );
        if ($validator->fails()) {
            $this->errors =  $validator->errors();
            return false;
        }
        return true;
    }

    /**
     * 获取第一个错误描述
     * @return mixed
     */
    public function getFirstErrorMessage(){
        return $this->errors->first();
    }

    /**
     * 获取全部错误描述
     */
    public function getErrorMessages(){
        return $this->errors->messages();
    }
}