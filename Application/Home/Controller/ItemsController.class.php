<?php
namespace Home\Controller;
use Think\Controller;
class ItemsController extends Controller {
    public function index($id){
        //echo $id;
        /*if (strlen($id) != 24) {
            $data = null;
        }else{*/
            $items = M('items');
            try {
                $data = $items->where(array('_id' => $id))->find();
                if ($data['prices'] == null) {
                    $prices = $this->getPrices((int)$id);
                }else {
                    $prices = $data['prices'];
                }

            } catch (Exception $e) {
                $data = $e;
            }
        //}

        //print_r($data);
        /*foreach($datas as $k => $v){
            $data = $datas[$k];
        }*/

        $data['detail'] = htmlspecialchars_decode($data['detail']);
       /* echo "<pre>";
        print_r($data);*/
        $this->assign('data', $data);
        $this->assign('prices', $prices);
        $this->display('test');
    }
    public function test(){
    	$items = M('items');
    	$datas = $items->select();
    	foreach($datas as $k => $v){
    		$data = $datas[$k];
    	}
    	$this->assign('data', $data);
    	$this->show();
    }

    public function getPrices($id){
        $sku = M('sku');
        $d = $sku->where(array('id'=>$id))->select();
        for ($i=0; $i < count($d); $i++) {
            $p[$d[$i]['name']]['price'] = $d[$i]['price'];
            $p[$d[$i]['name']]['stock'] = $d[$i]['stock'];
        }
        return $p;
    }
}
