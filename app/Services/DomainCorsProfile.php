<?php
namespace App\Services\Cors;

use Spatie\Cors\CorsProfile\DefaultProfile;

class DomainCorsProfile extends DefaultProfile {
    
    public function allowOrigins(): array {
        $url = env('APP_FRONTEND_URL'.'*', '*');
        return [
            $url
        ];
    }
}