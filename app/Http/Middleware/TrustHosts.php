<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array<int, string|null>
     */
    public function hosts()
    {
        return [
            'localhost', '0.0.0.0:3000', '', '127.0.0.1:3000', '127.0.0.1',
            'http://localhost:3000/', 'http://localhost:3000', 'localhost:3000', 'http://localhost',
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
