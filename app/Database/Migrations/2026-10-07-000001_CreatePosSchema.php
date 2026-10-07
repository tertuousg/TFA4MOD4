<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CreatePosSchema extends Migration
{
    public function up()
    {
        $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'name'=>['type'=>'VARCHAR','constraint'=>100],'price'=>['type'=>'DECIMAL','constraint'=>'10,2'],'stock_quantity'=>['type'=>'INT','default'=>0],'image'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],'created_at'=>['type'=>'DATETIME']]);
        $this->forge->addKey('id', true); $this->forge->createTable('products');
        $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'full_name'=>['type'=>'VARCHAR','constraint'=>100],'email'=>['type'=>'VARCHAR','constraint'=>100],'phone'=>['type'=>'VARCHAR','constraint'=>20,'null'=>true],'created_at'=>['type'=>'DATETIME']]);
        $this->forge->addKey('id', true); $this->forge->createTable('customers');
        $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'username'=>['type'=>'VARCHAR','constraint'=>50],'full_name'=>['type'=>'VARCHAR','constraint'=>100],'password'=>['type'=>'VARCHAR','constraint'=>255],'avatar'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],'created_at'=>['type'=>'DATETIME']]);
        $this->forge->addKey('id', true); $this->forge->addUniqueKey('username'); $this->forge->createTable('users');
        $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'product_id'=>['type'=>'INT','unsigned'=>true],'customer_id'=>['type'=>'INT','unsigned'=>true,'null'=>true],'sold_by'=>['type'=>'INT','unsigned'=>true],'quantity'=>['type'=>'INT'],'total_price'=>['type'=>'DECIMAL','constraint'=>'10,2'],'created_at'=>['type'=>'DATETIME']]);
        $this->forge->addKey('id', true); $this->forge->addForeignKey('product_id','products','id','RESTRICT','CASCADE'); $this->forge->addForeignKey('customer_id','customers','id','SET NULL','CASCADE'); $this->forge->addForeignKey('sold_by','users','id','RESTRICT','CASCADE'); $this->forge->createTable('sales');
    }
    public function down(){ $this->forge->dropTable('sales',true); $this->forge->dropTable('users',true); $this->forge->dropTable('customers',true); $this->forge->dropTable('products',true); }
}
