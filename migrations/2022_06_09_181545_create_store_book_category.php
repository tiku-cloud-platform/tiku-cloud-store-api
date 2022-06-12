<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateStoreBookCategory extends Migration
{
	public function up(): void
	{
		Schema::create('store_book_category', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->uuid("uuid")->unique();
			$table->uuid("store_uuid")->comment("商户uuid");
			$table->uuid("store_book_uuid")->comment("书籍uuid");
			$table->string("title", 32)->comment("分类名称");
			$table->string("parent_uuid", 32)->nullable()->comment("上级分类");
			$table->tinyInteger("is_show", false, true)->default(2)->comment("显示状态1显示2禁用");
			$table->integer("orders", false, true)->default(0)->comment("显示顺序");
			$table->timestamps();
			$table->softDeletes();
		});
		Db::select("alter table store_book_category comment '书籍分类'");
	}

	public function down(): void
	{
		Schema::dropIfExists('store_book_category');
	}
}
