<?php

declare(strict_types=1);

namespace App\Modules\Documents\Infrastructure\Providers;

use App\Modules\Documents\Domain\Ports\DocumentStoragePort;
use App\Modules\Documents\Infrastructure\Salesforce\SalesforceDocumentsAdapter;
use Illuminate\Support\ServiceProvider;

class DocumentsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DocumentStoragePort::class, SalesforceDocumentsAdapter::class);
    }
}
