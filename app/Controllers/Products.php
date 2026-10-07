<?php
namespace App\Controllers;
use App\Models\ProductModel; use CodeIgniter\Exceptions\PageNotFoundException;
class Products extends BaseController
{
    public function index(){ return view('products/index',['title'=>'Products','products'=>(new ProductModel())->orderBy('name')->findAll()]); }
    public function new(){ return view('products/form',['title'=>'New Product','product'=>null,'action'=>site_url('products')]); }
    public function create(){ return $this->saveNew(); }
    private function saveNew(){ if(!$this->validate($this->rules(true))) return redirect()->back()->withInput()->with('errors',$this->validator->getErrors()); $data=$this->data(); $file=$this->request->getFile('image'); if($file && $file->isValid()) $data['image']=$this->image($file->getTempName(),$file->getClientExtension(),'product'); (new ProductModel())->insert($data); return redirect()->to('/products')->with('success','Product added.'); }
    public function edit(int $id){ $p=(new ProductModel())->find($id); if(!$p) throw PageNotFoundException::forPageNotFound(); return view('products/form',['title'=>'Edit Product','product'=>$p,'action'=>site_url('products/'.$id)]); }
    public function update(int $id){ $m=new ProductModel(); $old=$m->find($id); if(!$old) throw PageNotFoundException::forPageNotFound(); if(!$this->validate($this->rules(false))) return redirect()->back()->withInput()->with('errors',$this->validator->getErrors()); $data=$this->data(); $file=$this->request->getFile('image'); if($file && $file->getError()!==UPLOAD_ERR_NO_FILE && $file->isValid()){ $data['image']=$this->image($file->getTempName(),$file->getClientExtension(),'product'); $this->remove($old['image']); } $m->update($id,$data); return redirect()->to('/products')->with('success','Product updated.'); }
    public function delete(int $id){ $m=new ProductModel(); $p=$m->find($id); if(!$p) throw PageNotFoundException::forPageNotFound(); try{$m->delete($id); $this->remove($p['image']); return redirect()->to('/products')->with('success','Product deleted.');}catch(\Throwable $e){return redirect()->to('/products')->with('error','Products used in sales cannot be deleted.');} }
    private function rules(bool $required):array{ $r=['name'=>'required|max_length[100]','price'=>'required|decimal|greater_than_equal_to[0]','stock_quantity'=>'required|integer|greater_than_equal_to[0]']; $f=$this->request->getFile('image'); if($required ? ($f && $f->getError()!==UPLOAD_ERR_NO_FILE) : ($f && $f->getError()!==UPLOAD_ERR_NO_FILE)) $r['image']='uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|ext_in[image,jpg,jpeg,png]'; return $r; }
    private function data():array{return ['name'=>trim((string)$this->request->getPost('name')),'price'=>$this->request->getPost('price'),'stock_quantity'=>$this->request->getPost('stock_quantity')];}
    private function image(string $temp,string $ext,string $prefix):string{ $dir=FCPATH.'uploads'; if(!is_dir($dir)) mkdir($dir,0755,true); $ext=strtolower($ext)==='png'?'png':'jpg'; $name=$prefix.'_'.bin2hex(random_bytes(12)).'.'.$ext; service('image')->withFile($temp)->fit(600,600,'center')->save($dir.'/'.$name,85); return $name; }
    private function remove(?string $name):void{ if($name && is_file(FCPATH.'uploads/'.basename($name))) unlink(FCPATH.'uploads/'.basename($name)); }
}
