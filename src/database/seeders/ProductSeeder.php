<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $products = [
            [
                'name' => 'キウイ',
                'price' => 800,
                'image' => 'images/kiwi.png',
                'description' => 'キウイは甘みと酸味のバランスが絶妙なフルーツです。ビタミンCなどの栄養素も豊富のため、美肌効果や疲労回復効果も期待できます。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [3, 4], // 秋、冬
            ],
            [
                'name' => 'ストロベリー',
                'price' => 1200,
                'image' => 'images/strawberry.png',
                'description' => '大人から子供まで大人気のストロベリー。当店では鮮度抜群の完熟いちごを使用しています。ビタミンCはもちろん食物繊維も豊富なため、腸内環境の改善も期待できます。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [1], // 春
            ],
            [
                'name' => 'オレンジ',
                'price' => 850,
                'image' => 'images/orange.png',
                'description' => '当店では酸味と甘みのバランスが抜群のネーブルオレンジを使用しています。酸味は控えめで、甘さと濃厚な果汁が魅力の商品です。もぎたてフルーツのスムージをお召し上がりください！',
                'seasons' => [4], // 冬
            ],
            [
                'name' => 'スイカ',
                'price' => 700,
                'image' => 'images/watermelon.png',
                'description' => '夏の暑い時期にぴったりの甘くてみずみずしいスイカ。当店ではシャリッとした食感が魅力のスイカを使用しています。旬のスイカを使用したスムージーをお楽しみください！',
                'seasons' => [2], // 夏
            ],
            [
                'name' => 'ピーチ',
                'price' => 1000,
                'image' => 'images/peach.png',
                'description' => '桃の芳醇な香りととろけるような甘さを堪能できるスムージー。当店ではジューシーで濃厚な甘さが魅力の桃を使用しています。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [2], // 夏
            ],
            [
                'name' => 'シャインマスカット',
                'price' => 1400,
                'image' => 'images/muscat.png',
                'description' => 'みずみずしく爽やかな香りが魅力のシャインマスカット。大粒で糖度が高く、上品な甘さを楽しめます。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [2, 3], // 夏、秋
            ],
            [
                'name' => 'パイナップル',
                'price' => 800,
                'image' => 'images/pineapple.png',
                'description' => 'ほどよい酸味と甘さが絶妙なパイナップルスムージー。ビタミンCなどの栄養素も豊富のため、夏バテ予防にも効果的です。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [1, 2], // 春、夏
            ],
            [
                'name' => 'ブドウ',
                'price' => 1100,
                'image' => 'images/grapes.png',
                'description' => 'ブドウの中でも人気の高い国産の「巨峰」を使用しています。高い糖度と適度な酸味が魅力で、鮮やかなパープルで見た目も可愛い商品です。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [2, 3], // 夏、秋
            ],
            [
                'name' => 'バナナ',
                'price' => 600,
                'image' => 'images/banana.png',
                'description' => '低カロリーでありながら栄養満点のため、ダイエット中の方にもおすすめの商品です。1杯でバナナの濃厚な甘みを存分に堪能できます。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [2], // 夏
            ],
            [
                'name' => 'メロン',
                'price' => 900,
                'image' => 'images/melon.png',
                'description' => '香りがよくジューシーで品のある甘さが人気のメロンスムージー。カリウムが多く含まれているためむくみ解消効果も抜群です。もぎたてフルーツのスムージーをお召し上がりください！',
                'seasons' => [1, 2], // 春、夏
            ],
        ];

        foreach ($products as $p) {
            $seasonIds = $p['seasons'];
            unset($p['seasons']);

            $p['created_at'] = $now;
            $p['updated_at'] = $now;

            $productId = DB::table('products')->insertGetId($p);

            $rows = [];
            foreach ($seasonIds as $sid) {
                $rows[] = [
                    'product_id' => $productId,
                    'season_id' => $sid,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('product_season')->insert($rows);
        }
    }
}
