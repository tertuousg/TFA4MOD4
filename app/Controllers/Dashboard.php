<?php
namespace App\Controllers;
use App\Models\ProductModel; use App\Models\CustomerModel; use App\Models\UserModel; use App\Models\SaleModel;
class Dashboard extends BaseController
{
    public function index(){ return view('dashboard',['title'=>'Dashboard','productCount'=>(new ProductModel())->countAllResults(),'customerCount'=>(new CustomerModel())->countAllResults(),'userCount'=>(new UserModel())->countAllResults(),'saleCount'=>(new SaleModel())->countAllResults()]); }
}
