<?php

namespace App\Service;

class ProductHandler
{

    /**
     * 获取商品总金额
     * @param $products 商品列表
     * @return int
     */
    public function getTotalAmount($products): int
    {
        $totalAmount = 0;
        array_walk($products,function ($v) use (&$totalAmount){
            $totalAmount += $v['price'] ?? 0;
        });
        return $totalAmount;
    }

    /**
     * 根据商品类型过滤，且按金额降序排列
     * @param $products 商品列表
     * @param $type 商品类型
     * @return array
     */
    public function filterAndSortProducts($products,$type): array
    {
        $products = array_filter($products, function ($v) use ($type) {
            return strtolower($v["type"]) == strtolower($type);
        });
        $prices = array_column($products, "price");
        array_multisort($prices,SORT_NUMERIC,SORT_DESC,$products);
        return $products;
    }

    /**
     * 日期转时间戳
     * @param $products 商品列表
     * @return array
     */
    public function createAtToTime($products): array
    {
        foreach($products as &$v){
            $v["create_at"] = strtotime($v["create_at"]);
        }
        return $products;
    }
}