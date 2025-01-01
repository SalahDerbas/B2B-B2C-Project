<?php

namespace App\Interfaces\Source;

use Illuminate\Http\Request;

interface SourcePackageInterface
{

    /**
     *
     *
     * @return array The response data indicating the result of the payment attempt.
     */
    public function submitOrder($item_source_id);



    /**
     *
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the callback data.
     * @return bool Return true if the payment is successfully completed, false otherwise.
     */
    public function usagePackage(Request $request);



}
