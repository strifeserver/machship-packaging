<?php
namespace App\Services;

class PackagingService
{

    public function boxes()
    {
        $boxes = [
            ["name" => "BOXA", "length" => 20, "width" => 15, "height" => 10, "weight_limit" => 5],
            ["name" => "BOXB", "length" => 30, "width" => 25, "height" => 20, "weight_limit" => 10],
            ["name" => "BOXC", "length" => 60, "width" => 55, "height" => 50, "weight_limit" => 50],
            ["name" => "BOXD", "length" => 50, "width" => 45, "height" => 40, "weight_limit" => 30],
            ["name" => "BOXE", "length" => 40, "width" => 35, "height" => 30, "weight_limit" => 20],
        ];

        return $boxes;
    }

    ##Sort smallest box to largest
    ##
    public function sortedBoxes()
    {
        $boxes = $this->boxes();
        ## Calculate and add total_volume to each box (debug display)
        foreach ($boxes as $key => $box) {
            $total_volume = $box['length'] * $box['width'] * $box['height'];
            $boxes[$key]['total_volume'] = $total_volume;
        }
        ## Sort boxes by total_volume (Small priority)
        usort($boxes, function ($a, $b) {
            return $a['total_volume'] - $b['total_volume'];
        });
        ## Add sort_order increment
        foreach ($boxes as $key => &$box) {
            $box['sort_order'] = $key + 1;
        }
        return $boxes;
    }

    ## CALCULATE TOTAL AND WEIGHT OF PRODUCT
    private function calculateTotalVolumeAndWeight($products)
    {
        $totalVolume = 0;
        $totalWeight = 0;

        foreach ($products as $product) {
            $productVolume = $product['length'] * $product['width'] * $product['height'] * $product['quantity'];
            $productWeight = $product['weight'] * $product['quantity'];
            $totalVolume += $productVolume;
            $totalWeight += $productWeight;
        }

        return [$totalVolume, $totalWeight];
    }
    ## CALCULATE TOTAL AND WEIGHT OF A PRODUCT

    ## check if all individual product dimensions fit within the box dimensions
    public function dimensionsFit($products, $box)
    {
        foreach ($products as $product) {
            if (
                $product['length'] > $box['length'] ||
                $product['width'] > $box['width'] ||
                $product['height'] > $box['height']
            ) {
                return false;
            }
        }
        return true;
    }

    public function sortProducts($products)
    {
        ## Calculate and add total_volume to each product
        foreach ($products as $key => $product) {
            $total_volume = $product['length'] * $product['width'] * $product['height'];
            $products[$key]['total_volume'] = $total_volume;
        }

        ## Sort products by total_volume (Descending order)
        usort($products, function ($a, $b) {
            return ($b['total_volume'] ?? 0) - ($a['total_volume'] ?? 0);
        });

        return $products;
    }

    public function processPackaging($request)
    {
        $returns = [
            'status' => 'success',
            'code' => 200,
        ];
        $boxes = $this->sortedBoxes();
        $products = $request->input('products');

        $packedBoxes = [];
        $unfitProducts = [];
        while (!empty($products)) {
            list($totalVolume, $totalWeight) = $this->calculateTotalVolumeAndWeight($products);

            $allProductsFitInOneBox = false;

            foreach ($boxes as $box) {
                if ($totalWeight <= $box['weight_limit'] && $totalVolume <= ($box['length'] * $box['width'] * $box['height']) && $this->dimensionsFit($products, $box)
                ) {
                    $packedBoxes[] = ['box' => $box, 'products' => $products];
                    $allProductsFitInOneBox = true;
                    $products = []; ## CLEAR
                    break;
                }
            }

            if (!$allProductsFitInOneBox) {
                ##Take the largest product and allocate it to its own box.
                $sortProducts = $this->sortProducts($products);
                $largestProduct = array_shift($products);

                $productPacked = false;
                foreach ($boxes as $box) {
                    if (
                        $largestProduct['weight'] <= $box['weight_limit'] &&
                        ($largestProduct['length'] * $largestProduct['width'] * $largestProduct['height']) <= ($box['length'] * $box['width'] * $box['height']) &&
                        $this->dimensionsFit([$largestProduct], $box)
                    ) {

                        $packedBoxes[] = ['box' => $box, 'products' => [$largestProduct]];
                        $productPacked = true;
                        break;
                    }
                }

                if (!$productPacked) {
                    $unfitProducts[] = $largestProduct;
                }
            }
        }

        $returns['packedBoxes'] = $packedBoxes;
        $returns['unfitProducts'] = $unfitProducts;

        if (count($unfitProducts) > 0) {
            $returns['status'] = 'error';
            $returns['code'] = 400;
        }
        return $returns;
    }

}
