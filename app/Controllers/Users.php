<?php
namespace App\Controllers;
use App\Models\UserModel; use CodeIgniter\Exceptions\PageNotFoundException;
class Users extends BaseController
{
    public function index(){ return view('users/index',['title'=>'Staff Accounts','users'=>(new UserModel())->orderBy('full_name')->findAll()]); }
    public function new(){ return view('users/form',['title'=>'New Staff Account','user'=>null,'action'=>site_url('users')]); }
    public function create()
    {
        if(!$this->validate($this->rules(true))) return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        $data=$this->data(); $data['password']=password_hash((string)$this->request->getPost('password'),PASSWORD_DEFAULT);
        $file=$this->request->getFile('avatar'); if($file && $file->isValid()) $data['avatar']=$this->avatar($file->getTempName(),$file->getClientExtension());
        (new UserModel())->insert($data); return redirect()->to('/users')->with('success','Staff account created.');
    }
    public function edit(int $id){$u=(new UserModel())->find($id); if(!$u) throw PageNotFoundException::forPageNotFound(); return view('users/form',['title'=>'Edit Staff Account','user'=>$u,'action'=>site_url('users/'.$id)]);}
    public function update(int $id)
    {
        $m=new UserModel(); $old=$m->find($id); if(!$old) throw PageNotFoundException::forPageNotFound();
        if(!$this->validate($this->rules(false,$id))) return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        $data=$this->data(); $password=(string)$this->request->getPost('password'); if($password!=='') $data['password']=password_hash($password,PASSWORD_DEFAULT);
        $file=$this->request->getFile('avatar'); if($file && $file->getError()!==UPLOAD_ERR_NO_FILE && $file->isValid()){ $data['avatar']=$this->avatar($file->getTempName(),$file->getClientExtension()); $this->remove($old['avatar']); }
        $m->update($id,$data); return redirect()->to('/users')->with('success','Staff account updated.');
    }
    public function delete(int $id)
    {
        if($id===(int)session('user_id')) return redirect()->to('/users')->with('error','You cannot delete your own logged-in account.');
        $m=new UserModel(); $u=$m->find($id); if(!$u) throw PageNotFoundException::forPageNotFound();
        try{$m->delete($id); $this->remove($u['avatar']); return redirect()->to('/users')->with('success','Staff account deleted.');}catch(\Throwable $e){return redirect()->to('/users')->with('error','Staff accounts linked to sales cannot be deleted.');}
    }
    private function rules(bool $new,int $id=0):array
    {
        $unique=$new?'is_unique[users.username]':'is_unique[users.username,id,'.$id.']';
        $r=['username'=>'required|alpha_numeric_punct|min_length[3]|max_length[50]|'.$unique,'full_name'=>'required|max_length[100]','password'=>$new?'required|min_length[8]|max_length[255]':'permit_empty|min_length[8]|max_length[255]'];
        $f=$this->request->getFile('avatar'); if($f && $f->getError()!==UPLOAD_ERR_NO_FILE) $r['avatar']='uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]'; return $r;
    }
    private function data():array{return ['username'=>trim((string)$this->request->getPost('username')),'full_name'=>trim((string)$this->request->getPost('full_name'))];}
    private function avatar(string $temp,string $ext):string{$dir=FCPATH.'uploads'; if(!is_dir($dir)) mkdir($dir,0755,true); $ext=strtolower($ext)==='png'?'png':'jpg'; $name='avatar_'.bin2hex(random_bytes(12)).'.'.$ext; service('image')->withFile($temp)->fit(300,300,'center')->save($dir.'/'.$name,85); return $name;}
    private function remove(?string $name):void{if($name && is_file(FCPATH.'uploads/'.basename($name))) unlink(FCPATH.'uploads/'.basename($name));}
}
