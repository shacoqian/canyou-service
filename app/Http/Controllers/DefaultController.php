<?php
/**
 * Created by PhpStorm.
 * User: FengQian
 * Date: 2017/8/22
 * Time: 下午5:13
 */

namespace App\Http\Controllers;

use App\Models\AccountModel;
use Illuminate\Support\Facades\Redis;


class DefaultController extends Controller {

    public function index() {
        echo 'first blood';
    }

    public function database() {
        $result = AccountModel::get()->toArray();
        var_dump($result);
    }

    public function redis() {
        Redis::set('aa', '123456');
        $a = Redis::get('aa');
        var_dump($a);
    }

}