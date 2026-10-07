<?php
namespace App\Controllers;
use App\Models\ProductModel; use App\Models\CustomerModel;
class Sales extends BaseController
{
    public function index(){ $rows=db_connect()->table('sales s')->select('s.*,p.name product_name,c.full_name customer_name,u.full_name staff_name')->join('products p','p.id=s.product_id')->join('customers c','c.id=s.customer_id','left')->join('users u','u.id=s.sold_by')->orderBy('s.created_at','DESC')->get()->getResultArray(); return view('sales/index',['title'=>'Sales History','sales'=>$rows]); }
    public function new(){ return view('sales/form',['title'=>'Record Sale','products'=>(new ProductModel())->where('stock_quantity >',0)->orderBy('name')->findAll(),'customers'=>(new CustomerModel())->orderBy('full_name')->findAll()]); }
    public function create()
    {
        $rules=['product_id'=>'required|integer|is_not_unique[products.id]','customer_id'=>'permit_empty|integer|is_not_unique[customers.id]','quantity'=>'required|integer|greater_than[0]'];
        if(!$this->validate($rules)) return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        $db=db_connect(); $db->transBegin();
        try{
            $product=$db->query('SELECT * FROM products WHERE id = ? FOR UPDATE',[(int)$this->request->getPost('product_id')])->getRowArray();
            $quantity=(int)$this->request->getPost('quantity');
            if(!$product || $quantity>(int)$product['stock_quantity']){ $db->transRollback(); return redirect()->back()->withInput()->with('errors',['quantity'=>'Requested quantity exceeds available stock.']); }
            $db->table('sales')->insert(['product_id'=>$product['id'],'customer_id'=>$this->request->getPost('customer_id')?:null,'sold_by'=>(int)session('user_id'),'quantity'=>$quantity,'total_price'=>number_format((float)$product['price']*$quantity,2,'.',''),'created_at'=>date('Y-m-d H:i:s')]);
            $db->table('products')->where('id',$product['id'])->update(['stock_quantity'=>(int)$product['stock_quantity']-$quantity]);
            if($db->transStatus()===false) throw new \RuntimeException('Transaction failed.');
            $db->transCommit(); return redirect()->to('/sales')->with('success','Sale recorded and stock updated.');
        }catch(\Throwable $e){ $db->transRollback(); return redirect()->back()->withInput()->with('error','The sale could not be recorded. Please try again.'); }
    }
}
