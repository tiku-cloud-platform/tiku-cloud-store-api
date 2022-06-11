<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateStoreBookContent extends Migration
{
	public function up(): void
	{
		Schema::create('store_book_content', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->uuid("uuid")->unique();
			$table->uuid("store_uuid")->comment("商户uuid");
			$table->uuid("store_book_uuid")->comment("书籍uuid");
			$table->uuid("store_book_category_uuid")->comment("所属分类");
			$table->string("title", 32)->comment("标题");
			$table->string("intro", 1000)->nullable()->comment("书籍简介");
			$table->longText("content")->comment("章节内容");
			$table->string("author", 100)->comment("书籍作者");
			$table->dateTime("publish_time", 0)->comment("发布时间");
			$table->string("tags", 100)->nullable()->comment("书籍标签");
			$table->integer("read_number", false, true)->default(0)->comment("阅读数量");
			$table->integer("click_number", false, true)->default(0)->comment("点赞数量");
			$table->integer("collection_number", false, true)->default(0)->comment("收藏数量");
			$table->string("source", 1000)->nullable()->comment("内容来源");
			$table->integer("orders", false, true)->default(0)->comment("显示顺序");
			$table->tinyInteger("is_show", false, true)->default(2)->comment("显示状态1显示2禁用");
			$table->timestamps();
			$table->softDeletes();
		});
		Db::select("alter table store_book_content comment '书籍章节'");
	}

	public function down(): void
	{
		Schema::dropIfExists('store_book_content');
	}
}
