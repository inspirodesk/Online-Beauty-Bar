<?php
namespace App\Services;

use Automattic\WooCommerce\Client;

class WooCommerceService
{
    protected $woocommerce;

    public function __construct()
    {
        $this->woocommerce = new Client(
            config('woocommerce.url'),
            config('woocommerce.consumer_key'),
            config('woocommerce.consumer_secret'),
            [
                'version' => 'wc/v3',
            ]
        );
    }

    public function getOrders()
    {
        return $this->woocommerce->get('orders');
    }

    public function updateProductStatus($productId, $status)
    {
        // Validate the status value
        $validStatuses = ['pending', 'processing', 'on-hold', 'completed', 'cancelled', 'refunded', 'failed', 'trash'];
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException('Invalid status value');
        }

        // Prepare the data
        $data = ['status' => $status];

        // Update the WooCommerce order status
        try {
            $response = $this->woocommerce->put('orders/' . $productId, $data);
            return $response;
        } catch (\Exception $e) {
            \Log::error('Error updating WooCommerce order status: ' . $e->getMessage());
            throw $e;
        }
    }
}
