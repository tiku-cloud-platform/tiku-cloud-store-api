<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateStoreBook extends Migration
{
	public function up(): void
	{
		Schema::create('store_book', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->uuid("uuid")->unique();
			$table->uuid("store_uuid")->comment("商户uuid");
			$table->uuid("file_uuid")->comment("书籍封面图片id");
			$table->string("title", 32)->comment("书籍名称");
			$table->string("author", 100)->comment("书籍作者");
			$table->string("tags", 100)->nullable()->comment("书籍标签");
			$table->string("source", 1000)->nullable()->comment("书籍来源");
			$table->integer("numbers", false, true)->default(0)->comment("书籍章节数");
			$table->text("intro")->nullable()->comment("书籍简介");
			$table->integer("collection_number", false, true)->default(0)->comment("收藏数量");
			$table->tinyInteger("level", false, true)->default(1)->comment("手册难度");
			$table->decimal("score", 6, 2)->default(0.00)->comment("评分");
			$table->integer("orders", false, true)->default(0)->comment("显示顺序");
			$table->tinyInteger("is_show", false, true)->default(2)->comment("显示状态1显示2禁用");
			$table->timestamps();
			$table->softDeletes();
		});
		Db::select("alter table store_book comment '书籍基础信息'");
	}

	public function down(): void
	{
		Schema::dropIfExists('store_book');
	}
}
