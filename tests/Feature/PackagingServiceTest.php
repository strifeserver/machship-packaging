<?php

namespace Tests\Feature;

use App\Services\PackagingService;
use Tests\TestCase;

class PackagingServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProcessPackaging()
    {
        // Mocking request input data
        ##Valid Data
        $request = (object) [
            'products' => [
                ['name' => 'Product1', 'length' => 10, 'width' => 8, 'height' => 5, 'weight' => 2, 'quantity' => 1],
                ['name' => 'Product2', 'length' => 25, 'width' => 20, 'height' => 15, 'weight' => 8, 'quantity' => 1],
            ]
        ];

        ##4 Unfit Products 
        // $request = (object) [
        //     'products' => [
        //         ['length' => 10, 'width' => 5, 'height' => 3, 'weight' => 1, 'quantity' => 2],
        //         ['length' => 25, 'width' => 20, 'height' => 15, 'weight' => 5, 'quantity' => 1],
        //         ['length' => 50, 'width' => 40, 'height' => 30, 'weight' => 20, 'quantity' => 1],
        //         ['length' => 60, 'width' => 50, 'height' => 40, 'weight' => 30, 'quantity' => 1],
        //         ['length' => 70, 'width' => 60, 'height' => 50, 'weight' => 40, 'quantity' => 1],
        //         ['length' => 80, 'width' => 70, 'height' => 60, 'weight' => 50, 'quantity' => 1],
        //         ['length' => 90, 'width' => 80, 'height' => 70, 'weight' => 60, 'quantity' => 1],
        //         ['length' => 100, 'width' => 90, 'height' => 80, 'weight' => 70, 'quantity' => 1],
        //     ],
        // ];

        // Create an instance of PackagingService
        $service = new PackagingService();

        // Call the processPackaging method
        $result = $service->processPackaging($request);

        // Assert that packedBoxes is not empty
        $this->assertNotEmpty($result['packedBoxes'], 'Should not be empty');

        // Assert that unfitProducts is empty
        $this->assertEmpty($result['unfitProducts'], 'Unfit products must be empty.');

        // Assert that the returned status is 'success'
        $this->assertEquals('success', $result['status'], 'Status must be success');
    }
}
