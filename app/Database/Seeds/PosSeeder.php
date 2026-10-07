<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class PosSeeder extends Seeder
{
    public function run()
    {
        $now=date('Y-m-d H:i:s');
        $this->db->table('products')->insertBatch([['name'=>'Wireless Mouse','price'=>599.00,'stock_quantity'=>25,'created_at'=>$now],['name'=>'Mechanical Keyboard','price'=>1899.00,'stock_quantity'=>12,'created_at'=>$now],['name'=>'USB-C Cable','price'=>249.00,'stock_quantity'=>40,'created_at'=>$now]]);
        $this->db->table('customers')->insertBatch([['full_name'=>'Juan Dela Cruz','email'=>'juan@example.com','phone'=>'09171234567','created_at'=>$now],['full_name'=>'Maria Santos','email'=>'maria@example.com','phone'=>'09181234567','created_at'=>$now]]);
        $this->db->table('users')->insert(['username'=>'admin','full_name'=>'System Administrator','password'=>password_hash('password123',PASSWORD_DEFAULT),'created_at'=>$now]);
    }
}
